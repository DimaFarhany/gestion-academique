<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnrollmentRequest;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['student.user', 'course'])
            ->latest()
            ->paginate(10);

        return view('enrollments.index', compact('enrollments'));
    }

    public function create()
    {
        $students = Student::with('user')->orderBy('id')->get();
        $courses = Course::orderBy('title')->get();

        return view('enrollments.create', compact('students', 'courses'));
    }

    public function store(EnrollmentRequest $request)
    {
        Enrollment::create($request->validated());

        return redirect()
            ->route('enrollments.index')
            ->with('success', 'Inscription ajoutée avec succès.');
    }

    public function show(Enrollment $enrollment)
    {
        $enrollment->load(['student.user', 'course']);

        return view('enrollments.show', compact('enrollment'));
    }

    public function edit(Enrollment $enrollment)
    {
        $students = Student::with('user')->orderBy('id')->get();
        $courses = Course::orderBy('title')->get();

        return view('enrollments.edit', compact('enrollment', 'students', 'courses'));
    }

    public function update(EnrollmentRequest $request, Enrollment $enrollment)
    {
        $enrollment->update($request->validated());

        return redirect()
            ->route('enrollments.index')
            ->with('success', 'Inscription modifiée avec succès.');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return redirect()
            ->route('enrollments.index')
            ->with('success', 'Inscription supprimée avec succès.');
    }

    public function myEnrollments()
    {
        $student = auth()->user()?->student;

        abort_if(!$student, 403, 'Aucun profil étudiant trouvé.');

        $enrollments = Enrollment::with('course')
            ->where('student_id', $student->id)
            ->latest()
            ->paginate(10);

        return view('enrollments.my', compact('enrollments', 'student'));
    }

    public function requestEnrollment(Course $course)
    {
        $student = auth()->user()?->student;

        abort_if(!$student, 403, 'Aucun profil étudiant trouvé.');

        $existing = Enrollment::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existing && $existing->status === 'pending') {
            return back()->with('error', 'Votre demande est déjà en attente.');
        }

        if ($existing && $existing->status === 'validated') {
            return back()->with('error', 'Vous êtes déjà inscrit à ce cours.');
        }

        Enrollment::updateOrCreate(
            [
                'student_id' => $student->id,
                'course_id' => $course->id,
            ],
            [
                'academic_year' => now()->year . '-' . (now()->year + 1),
                'status' => 'pending',
            ]
        );

        return back()->with('success', 'Demande d’inscription envoyée.');
    }

    public function approve(Enrollment $enrollment)
    {
        $enrollment->update([
            'status' => 'validated',
        ]);

        return back()->with('success', 'Inscription validée.');
    }

    public function refuse(Enrollment $enrollment)
    {
        $enrollment->update([
            'status' => 'refused',
        ]);

        return back()->with('success', 'Inscription refusée.');
    }
}