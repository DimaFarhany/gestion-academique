<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Liste des cours
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {

            $courses = Course::with('teacher.user')
                ->latest()
                ->paginate(10);

            return view('courses.index', [
                'courses' => $courses,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | TEACHER
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'teacher') {

            $teacher = $user->teacher;

            abort_if(
                !$teacher,
                403,
                'Profil enseignant introuvable.'
            );

            $courses = Course::with('teacher.user')
                ->where('teacher_id', $teacher->id)
                ->latest()
                ->paginate(10);

            return view('courses.index', [
                'courses' => $courses,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | STUDENT
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'student') {

            $student = $user->student;

            abort_if(
                !$student,
                403,
                'Profil étudiant introuvable.'
            );

            $courses = Course::with('teacher.user')
                ->latest()
                ->paginate(10);

            /*
            |--------------------------------------------------------------------------
            | Statuts des demandes
            |--------------------------------------------------------------------------
            */

            $requests = Enrollment::where(
                    'student_id',
                    $student->id
                )
                ->pluck('status', 'course_id');

            return view('courses.index', [
                'courses' => $courses,
                'requests' => $requests,
            ]);
        }

        abort(403, 'Accès non autorisé.');
    }

    /*
    |--------------------------------------------------------------------------
    | Formulaire création cours
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $this->authorizeAdmin();

        $teachers = Teacher::with('user')
            ->orderBy('id')
            ->get();

        return view('courses.create', [
            'teachers' => $teachers,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Enregistrer cours
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $this->validateCourse($request);

        Course::create($validated);

        return redirect()
            ->route('courses.index')
            ->with(
                'success',
                'Cours ajouté avec succès.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Afficher cours
    |--------------------------------------------------------------------------
    */

    public function show(Course $course)
    {
        $user = auth()->user();

        $course->load('teacher.user');

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {

            return view('courses.show', [
                'course' => $course,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | TEACHER
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'teacher') {

            $teacher = $user->teacher;

            abort_if(
                !$teacher,
                403,
                'Profil enseignant introuvable.'
            );

            abort_if(
                $course->teacher_id !== $teacher->id,
                403,
                'Accès non autorisé.'
            );

            return view('courses.show', [
                'course' => $course,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | STUDENT
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'student') {

            return view('courses.show', [
                'course' => $course,
            ]);
        }

        abort(403, 'Accès non autorisé.');
    }

    /*
    |--------------------------------------------------------------------------
    | Formulaire modification
    |--------------------------------------------------------------------------
    */

    public function edit(Course $course)
    {
        $this->authorizeAdmin();

        $teachers = Teacher::with('user')
            ->orderBy('id')
            ->get();

        return view('courses.edit', [
            'course' => $course,
            'teachers' => $teachers,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Modifier cours
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Course $course)
    {
        $this->authorizeAdmin();

        $validated = $this->validateCourse(
            $request,
            $course->id
        );

        $course->update($validated);

        return redirect()
            ->route('courses.index')
            ->with(
                'success',
                'Cours modifié avec succès.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Supprimer cours
    |--------------------------------------------------------------------------
    */

    public function destroy(Course $course)
    {
        $this->authorizeAdmin();

        $course->delete();

        return redirect()
            ->route('courses.index')
            ->with(
                'success',
                'Cours supprimé avec succès.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Validation cours
    |--------------------------------------------------------------------------
    */

    private function validateCourse(
        Request $request,
        ?int $courseId = null
    ): array {

        return $request->validate([

            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('courses', 'code')
                    ->ignore($courseId),
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'credits' => [
                'required',
                'integer',
                'min:0',
            ],

            'teacher_id' => [
                'required',
                'exists:teachers,id',
            ],

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Vérification admin
    |--------------------------------------------------------------------------
    */

    private function authorizeAdmin(): void
    {
        abort_if(
            auth()->user()->role !== 'admin',
            403,
            'Accès non autorisé.'
        );
    }
}