<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->latest()->paginate(10);

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8'],

            'matricule' => ['required', 'string', 'max:255', Rule::unique('students', 'matricule')],
            'gender' => ['required', 'in:Homme,Femme'],
            'birth_date' => ['nullable', 'date'],
            'level' => ['required', 'string', 'max:255'],
            'field' => ['required', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
        ]);

        Student::create([
            'user_id' => $user->id,
            'matricule' => $validated['matricule'],
            'sexe' => $validated['gender'],
            'date_naissance' => $validated['birth_date'] ?? null,
            'niveau' => $validated['level'],
            'filiere' => $validated['field'],
        ]);

        return redirect()
            ->route('students.index')
            ->with('success', 'Étudiant ajouté avec succès.');
    }

    public function show(Student $student)
    {
        $student->load('user');

        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $student->load('user');

        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($student->user_id),
            ],
            'password' => ['nullable', 'string', 'min:8'],

            'matricule' => [
                'required',
                'string',
                'max:255',
                Rule::unique('students', 'matricule')->ignore($student->id),
            ],
            'gender' => ['required', 'in:Homme,Femme'],
            'birth_date' => ['nullable', 'date'],
            'level' => ['required', 'string', 'max:255'],
            'field' => ['required', 'string', 'max:255'],
        ]);

        $student->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => !empty($validated['password'])
                ? Hash::make($validated['password'])
                : $student->user->password,
        ]);

        $student->update([
            'matricule' => $validated['matricule'],
            'sexe' => $validated['gender'],
            'date_naissance' => $validated['birth_date'] ?? null,
            'niveau' => $validated['level'],
            'filiere' => $validated['field'],
        ]);

        return redirect()
            ->route('students.index')
            ->with('success', 'Étudiant modifié avec succès.');
    }

    public function destroy(Student $student)
    {
        $student->user?->delete();
        $student->delete();

        return redirect()
            ->route('students.index')
            ->with('success', 'Étudiant supprimé avec succès.');
    }
}