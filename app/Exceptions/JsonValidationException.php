<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\Validator;

// Alumno: Carlos Alejandro Ambriz
class JsonValidationException extends Exception
{
    public function __construct(private Validator $validator)
    {
        parent::__construct('Validation failed');
    }

    public function render()
    {
        return response()->json([
            'message' => 'Validation failed',
            'errors'  => $this->validator->errors(),
        ], 422);
    }
}