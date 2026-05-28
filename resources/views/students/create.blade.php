@extends('layouts.academic')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h1 class="fw-bold mb-1">
            Ajouter un étudiant
        </h1>

        <p class="text-muted mb-0">
            Création d’un nouvel étudiant.
        </p>
    </div>

    <a href="{{ route('students.index') }}"
       class="btn btn-secondary">
        Retour
    </a>

</div>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <form action="{{ route('students.store') }}"
              method="POST">

            @csrf

            <!-- Nom -->
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Nom complet
                </label>

                <input type="text"
                       name="name"
                       class="form-control"
                       required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Email
                </label>

                <input type="email"
                       name="email"
                       class="form-control"
                       required>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Mot de passe
                </label>

                <input type="password"
                       name="password"
                       class="form-control"
                       required>
            </div>

            <!-- Matricule -->
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Matricule
                </label>

                <input type="text"
                       name="matricule"
                       class="form-control"
                       required>
            </div>

            <!-- Sexe -->
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Sexe
                </label>

                <select name="gender"
                        class="form-select"
                        required>

                    <option value="Homme">
                        Homme
                    </option>

                    <option value="Femme">
                        Femme
                    </option>

                </select>
            </div>

            <!-- Date naissance -->
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Date de naissance
                </label>

                <input type="date"
                       name="birth_date"
                       class="form-control">
            </div>

            <!-- Niveau -->
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Niveau
                </label>

                <input type="text"
                       name="level"
                       class="form-control">
            </div>

            <!-- Filière -->
            <div class="mb-4">
                <label class="form-label fw-semibold">
                    Filière
                </label>

                <input type="text"
                       name="field"
                       class="form-control">
            </div>

            <button type="submit"
                    class="btn btn-primary">
                Enregistrer
            </button>

        </form>

    </div>

</div>

@endsection