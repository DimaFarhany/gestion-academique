<?php

namespace App\Http\Requests;

use App\Models\Enrollment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $enrollmentId = $this->route('enrollment')?->id;

        return [
            'student_id' => [
                'required',
                'exists:students,id',
                Rule::unique('enrollments', 'student_id')
                    ->where(fn ($query) => $query
                        ->where('course_id', $this->course_id)
                        ->where('academic_year', $this->academic_year)
                    )
                    ->ignore($enrollmentId),
            ],
            'course_id' => ['required', 'exists:courses,id'],
            'academic_year' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
        ];
    }
}