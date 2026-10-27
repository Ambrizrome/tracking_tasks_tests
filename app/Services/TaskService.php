<?php

namespace App\Services;

use App\Http\Requests\TaskCreateRequest;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

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
            $userIds = $data['responsible_user_ids'];
            unset($data['responsible_user_ids']);

            $task = Task::create($data);
            $this->assignResponsibles($task, $userIds);

            return $task->load('responsibles');
        });
    }

    public function update(Request $request, int $task_id): Task
    {
        return DB::transaction(function () use ($request, $task_id) {
            $task = $this->find($task_id);
            $task->update($request->except('responsible_user_ids'));

            if ($request->has('responsible_user_ids')) {
                $task->taskResponsibles()->delete();
                $this->assignResponsibles($task, $request->input('responsible_user_ids'));
            }

            return $task->load('responsibles');
        });
    }

    public function destroy(int $task_id): void
    {
        $task = $this->find($task_id);
        $task->delete();
    }

    private function assignResponsibles(Task $task, array $userIds): void
    {
        $task->taskResponsibles()->createMany(
            collect($userIds)->map(fn ($id) => ['user_id' => $id])->all()
        );
    }
}