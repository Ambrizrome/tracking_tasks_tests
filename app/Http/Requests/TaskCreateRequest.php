<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TaskCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
    return [
        'name'        => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        // 'status' eliminado: lo asigna el sistema (Task::BACKLOG_STATUS)
        'priority'    => ['required'],   //ajustar valores que usaremos
        'assigned_at' => ['nullable', 'date'],
        'expected_at' => ['nullable', 'date'],
        'due_at'      => ['nullable', 'date'],
        'started_at'  => ['nullable', 'date'],
        'finished_at' => ['nullable', 'date'],

        // Ahora es opcional: permite crear una tarea sin responsables
        'responsible_user_ids'   => ['nullable', 'array'],
        'responsible_user_ids.*' => ['integer', 'distinct', 'exists:users,id'],
        ];
    }
}
