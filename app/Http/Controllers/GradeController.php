<?php

namespace App\Http\Controllers;

use App\Http\Requests\GradeRequest;
use App\Models\Enrollment;
use App\Models\Grade;

class GradeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $grades = Grade::with(['enrollment.student.user', 'enrollment.course.teacher.user'])
                ->latest()
                ->paginate(10);
        } elseif ($user->role === 'teacher') {
            $teacher = $user->teacher;

            abort_if(!$teacher, 403, 'Profil enseignant introuvable.');

            $grades = Grade::with(['enrollment.student.user', 'enrollment.course.teacher.user'])
                ->whereHas('enrollment.course', function ($query) use ($teacher) {
                    $query->where('teacher_id', $teacher->id);
                })
                ->latest()
                ->paginate(10);
        } else {
            abort(403, 'Accès non autorisé.');
        }

        return view('grades.index', compact('grades'));
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $enrollments = Enrollment::with(['student.user', 'course'])
                ->where('status', 'validated')
                ->latest()
                ->get();
        } elseif ($user->role === 'teacher') {
            $teacher = $user->teacher;

            abort_if(!$teacher, 403, 'Profil enseignant introuvable.');

            $enrollments = Enrollment::with(['student.user', 'course'])
                ->where('status', 'validated')
                ->whereHas('course', function ($query) use ($teacher) {
                    $query->where('teacher_id', $teacher->id);
                })
                ->latest()
                ->get();
        } else {
            abort(403, 'Accès non autorisé.');
        }

        return view('grades.create', compact('enrollments'));
    }

    public function store(GradeRequest $request)
    {
        $user = auth()->user();

        $enrollment = Enrollment::with('course')->findOrFail($request->enrollment_id);

        if ($enrollment->status !== 'validated') {
            abort(403, 'Cette inscription doit être validée avant de noter.');
        }

        if ($user->role === 'teacher') {
            $teacher = $user->teacher;

            abort_if(!$teacher, 403, 'Profil enseignant introuvable.');

            abort_if(
                $enrollment->course->teacher_id !== $teacher->id,
                403,
                'Inscription non autorisée.'
            );
        }

        Grade::create($request->validated());

        return redirect()
            ->route('grades.index')
            ->with('success', 'Note ajoutée avec succès.');
    }

    public function show(Grade $grade)
    {
        $grade->load(['enrollment.student.user', 'enrollment.course.teacher.user']);

        return view('grades.show', compact('grade'));
    }

    public function edit(Grade $grade)
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $enrollments = Enrollment::with(['student.user', 'course'])
                ->where('status', 'validated')
                ->latest()
                ->get();
        } elseif ($user->role === 'teacher') {
            $teacher = $user->teacher;

            abort_if(!$teacher, 403, 'Profil enseignant introuvable.');

            $enrollments = Enrollment::with(['student.user', 'course'])
                ->where('status', 'validated')
                ->whereHas('course', function ($query) use ($teacher) {
                    $query->where('teacher_id', $teacher->id);
                })
                ->latest()
                ->get();
        } else {
            abort(403, 'Accès non autorisé.');
        }

        return view('grades.edit', compact('grade', 'enrollments'));
    }

    public function update(GradeRequest $request, Grade $grade)
    {
        $grade->update($request->validated());

        return redirect()
            ->route('grades.index')
            ->with('success', 'Note modifiée avec succès.');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()
            ->route('grades.index')
            ->with('success', 'Note supprimée avec succès.');
    }

    public function myGrades()
    {
        $student = auth()->user()?->student;

        abort_if(!$student, 403, 'Aucun profil étudiant trouvé.');

        $grades = Grade::with(['enrollment.course'])
            ->whereHas('enrollment', function ($query) use ($student) {
                $query->where('student_id', $student->id);
            })
            ->latest()
            ->paginate(10);

        return view('grades.my', compact('grades', 'student'));
    }
}