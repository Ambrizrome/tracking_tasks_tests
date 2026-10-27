<?php

namespace App\Services;

use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskResponsiblesRequest;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TaskService
{
    public function getAll(): array
    {
        return Task::with('responsibles')->get()->toArray();
    }

    public function find(int $task_id): Task
    {
        return Task::with('responsibles')->findOrFail($task_id);
    }

    public function store(TaskCreateRequest $request): Task
    {
        return DB::transaction(function () use ($request) {
            $data = $request->validated();

            // Los responsables son opcionales
            $userIds = $data['responsible_user_ids'] ?? [];
            unset($data['responsible_user_ids']);

            // El estado inicial lo decide el sistema, no el usuario
            $data['status'] = Task::BACKLOG_STATUS;

            $task = Task::create($data);

            // Si hay responsables, el helper también estampa assigned_at
            $this->assignResponsibles($task, $userIds);

            return $task->load('responsibles');
        });
    }

    public function update(Request $request, int $task_id): Task
    {
        $task = $this->find($task_id);

        // fill() asigna los datos SIN guardar, así podemos saber si status cambió
        $task->fill($request->except('responsible_user_ids'));

        if ($task->isDirty('status')) {
            if ($task->status === Task::IN_PROCESS_STATUS) {
                $task->started_at = now();
            } elseif ($task->status === Task::COMPLETED_STATUS) {
                $task->finished_at = now();
            }
        }

        $task->save();

        // La respuesta incluye los responsables asignados
        return $task->load('responsibles');
    }

    public function destroy(int $task_id): void
    {
        $task = $this->find($task_id);
        $task->delete();
    }

    // Asignar uno o varios responsables a una tarea existente
    public function addResponsibles(TaskResponsiblesRequest $request, int $task_id): Task
    {
        return DB::transaction(function () use ($request, $task_id) {
            $task = $this->find($task_id); // 404 si la tarea no existe

            $this->assignResponsibles($task, $request->validated()['responsible_user_ids']);

            return $task->load('responsibles');
        });
    }

    // Desasignar uno o varios responsables (solo borra filas del pivote)
    public function removeResponsibles(TaskResponsiblesRequest $request, int $task_id): array
    {
        return DB::transaction(function () use ($request, $task_id) {
            $task = $this->find($task_id);
            $userIds = $request->validated()['responsible_user_ids'];

            // Si alguno de los usuarios no está asignado a esta tarea -> 422
            $assignedIds = $task->responsibles()->pluck('users.id')->all();
            $notAssigned = array_values(array_diff($userIds, $assignedIds));

            if (!empty($notAssigned)) {
                throw ValidationException::withMessages([
                    'responsible_user_ids' => [
                        'Los usuarios [' . implode(', ', $notAssigned) . '] no están asignados a esta tarea.',
                    ],
                ]);
            }

            // detach() borra únicamente filas de task_responsible_users.
            // No toca la tabla tasks ni la tabla users.
            $removed = $task->responsibles()->detach($userIds);

            return [
                'removed_count' => $removed,
                'task'          => $task->load('responsibles'), // los que siguen asignados
            ];
        });
    }

    // Helper: asigna sin duplicar y estampa assigned_at la primera vez
    private function assignResponsibles(Task $task, array $userIds): void
    {
        // syncWithoutDetaching inserta solo los que faltan -> sin duplicados
        $task->responsibles()->syncWithoutDetaching($userIds);

        // assigned_at se estampa una sola vez (cuando aún es null)
        if ($task->assigned_at === null && count($userIds) > 0) {
            $task->update(['assigned_at' => now()]);
        }
    }
}