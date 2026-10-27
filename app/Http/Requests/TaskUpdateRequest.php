<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Models\Task;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // sometimes: solo se valida si viene en el body
            // required:  si viene, no puede ser null ni vacío
            'status' => [
                'sometimes',
                'required',
                Rule::in([
                    Task::BACKLOG_STATUS,
                    Task::IN_PROCESS_STATUS,
                    Task::COMPLETED_STATUS,
                ]),
            ],
        ];
    }
}
