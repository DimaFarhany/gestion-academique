<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->latest()->paginate(10);

        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'specialite' => ['required', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teacher',
        ]);

        Teacher::create([
            'user_id' => $user->id,
            'specialite' => $request->specialite,
            'telephone' => $request->telephone,
        ]);

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Enseignant ajouté avec succès.');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load('user');

        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $teacher->load('user');

        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'specialite' => ['required', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:255'],
        ]);

        $teacher->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $teacher->update([
            'specialite' => $request->specialite,
            'telephone' => $request->telephone,
        ]);

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Enseignant modifié avec succès.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->user?->delete();
        $teacher->delete();

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Enseignant supprimé avec succès.');
    }
}