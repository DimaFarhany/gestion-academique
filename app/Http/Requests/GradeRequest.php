<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'enrollment_id' => ['required', 'exists:enrollments,id'],
            'grade' => ['required', 'numeric', 'min:0', 'max:20'],
            'type' => ['required', 'string', 'max:255'],
            'comment' => ['nullable', 'string'],
        ];
    }
}