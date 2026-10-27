<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TaskResponsiblesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'responsible_user_ids'   => ['required', 'array', 'min:1'],
            // exists -> los usuarios deben existir en la tabla users
            // distinct -> sin ids repetidos dentro del mismo request
            'responsible_user_ids.*' => ['integer', 'distinct', 'exists:users,id'],
        ];
    }
}
