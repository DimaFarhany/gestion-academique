<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Afficher formulaire inscription
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        // Matricule généré automatiquement
        $matricule = 'ETU-' . now()->format('Y') . '-' . rand(1000, 9999);

        return view('auth.register', compact('matricule'));
    }

    /*
    |--------------------------------------------------------------------------
    | Enregistrer utilisateur
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): RedirectResponse
    {
        $role = $request->input('role', 'student');

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([

            /*
            |--------------------------------------------------------------------------
            | Informations générales
            |--------------------------------------------------------------------------
            */

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:' . User::class,
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],

            'role' => [
                'required',
                Rule::in(['student', 'teacher', 'admin']),
            ],

            /*
            |--------------------------------------------------------------------------
            | Étudiant
            |--------------------------------------------------------------------------
            */

            'niveau' => [
                Rule::requiredIf($role === 'student'),
                'nullable',
                'string',
                'max:255',
            ],

            'filiere' => [
                Rule::requiredIf($role === 'student'),
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Enseignant
            |--------------------------------------------------------------------------
            */

            'specialite' => [
                Rule::requiredIf($role === 'teacher'),
                'nullable',
                'string',
                'max:255',
            ],

            'telephone' => [
                Rule::requiredIf($role === 'teacher'),
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Admin
            |--------------------------------------------------------------------------
            */

            'admin_code' => [
                Rule::requiredIf($role === 'admin'),
                'nullable',
                'string',
            ],

        ]);

        /*
        |--------------------------------------------------------------------------
        | Vérification code admin
        |--------------------------------------------------------------------------
        */

        if ($role === 'admin' && $request->admin_code !== 'ADMIN2026') {

            return back()
                ->withErrors([
                    'admin_code' => 'Code administrateur invalide.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Création utilisateur
        |--------------------------------------------------------------------------
        */

        $user = User::create([
            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make($request->password),

            'role' => $role,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Création étudiant
        |--------------------------------------------------------------------------
        */

        if ($role === 'student') {

            Student::create([

                'user_id' => $user->id,

                // Matricule automatique
                'matricule' => 'ETU-' . now()->format('Y') . '-' . rand(1000, 9999),

                'niveau' => $request->niveau,

                'filiere' => $request->filiere,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Création enseignant
        |--------------------------------------------------------------------------
        */

        if ($role === 'teacher') {

            Teacher::create([

                'user_id' => $user->id,

                'specialite' => $request->specialite,

                'telephone' => $request->telephone,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Connexion automatique
        |--------------------------------------------------------------------------
        */

        event(new Registered($user));

        Auth::login($user);

        /*
        |--------------------------------------------------------------------------
        | Redirection
        |--------------------------------------------------------------------------
        */

        return redirect()->route('dashboard');
    }
}