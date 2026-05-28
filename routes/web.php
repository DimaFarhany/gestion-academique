<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard dynamique
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {

        $role = auth()->user()->role;

        if ($role === 'admin') {
            return view('dashboard', [
                'studentCount' => \App\Models\Student::count(),
                'courseCount' => \App\Models\Course::count(),
                'enrollmentCount' => \App\Models\Enrollment::count(),
                'gradeCount' => \App\Models\Grade::count(),
            ]);
        }

        elseif ($role === 'teacher') {
            $teacher = auth()->user()->teacher;

            return view('dashboard', [
                'courseCount' => $teacher
                    ? \App\Models\Course::where('teacher_id', $teacher->id)->count()
                    : 0,

                'gradeCount' => $teacher
                    ? \App\Models\Grade::whereHas('enrollment.course', function ($query) use ($teacher) {
                        $query->where('teacher_id', $teacher->id);
                    })->count()
                    : 0,
            ]);
        }

        else {
            $student = auth()->user()->student;

            return view('dashboard', [
                'enrollmentCount' => $student
                    ? \App\Models\Enrollment::where('student_id', $student->id)->count()
                    : 0,

                'gradeCount' => $student
                    ? \App\Models\Grade::whereHas('enrollment', function ($query) use ($student) {
                        $query->where('student_id', $student->id);
                    })->count()
                    : 0,
            ]);
        }

    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Profil
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Liste des cours : admin + teacher + student
    |--------------------------------------------------------------------------
    */
    Route::get('/courses', [CourseController::class, 'index'])
        ->name('courses.index');

    /*
    |--------------------------------------------------------------------------
    | ADMIN uniquement
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {
        Route::resource('students', StudentController::class);
        Route::resource('teachers', TeacherController::class);
        Route::resource('enrollments', EnrollmentController::class);

        Route::patch('/enrollments/{enrollment}/approve', [EnrollmentController::class, 'approve'])
            ->name('enrollments.approve');

        Route::patch('/enrollments/{enrollment}/refuse', [EnrollmentController::class, 'refuse'])
            ->name('enrollments.refuse');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN + TEACHER
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,teacher')->group(function () {
        Route::resource('courses', CourseController::class)->except(['index']);
        Route::resource('grades', GradeController::class);

        Route::get('/courses/{course}/students', [GradeController::class, 'getStudentsByCourse'])
            ->name('courses.students');
    });

    /*
    |--------------------------------------------------------------------------
    | STUDENT
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:student')->group(function () {
        Route::get('/my-enrollments', [EnrollmentController::class, 'myEnrollments'])
            ->name('enrollments.my');

        Route::get('/my-grades', [GradeController::class, 'myGrades'])
            ->name('grades.my');

        Route::post('/courses/{course}/request-enrollment', [EnrollmentController::class, 'requestEnrollment'])
            ->name('courses.request-enrollment');
    });

});

require __DIR__.'/auth.php';