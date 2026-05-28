<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $studentId = $this->route('student')?->id;

        return [
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('students', 'user_id')->ignore($studentId),
            ],
            'matricule' => [
                'required',
                'string',
                'max:255',
                Rule::unique('students', 'matricule')->ignore($studentId),
            ],
            'sexe' => ['nullable', 'string', 'max:255'],
            'date_naissance' => ['nullable', 'date'],
            'niveau' => ['required', 'string', 'max:255'],
            'filiere' => ['required', 'string', 'max:255'],
        ];
    }
}