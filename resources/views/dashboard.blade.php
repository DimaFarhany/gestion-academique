@extends('layouts.academic')

@section('content')

<div class="mb-4">
    <h1 class="fw-bold mb-1">Dashboard</h1>

    <p class="text-muted">
        Bienvenue dans la plateforme de gestion académique.
    </p>
</div>

@php
    $role = auth()->user()->role ?? 'student';
@endphp

<div class="row g-4">

    @if($role === 'admin')

        <!-- Étudiants -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h3 class="fw-bold">Étudiants</h3>
                    <h1 class="mt-3 text-primary">
                        {{ $studentCount ?? 0 }}
                    </h1>
                </div>
            </div>
        </div>

        <!-- Cours -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h3 class="fw-bold">Cours</h3>
                    <h1 class="mt-3 text-success">
                        {{ $courseCount ?? 0 }}
                    </h1>
                </div>
            </div>
        </div>

        <!-- Inscriptions -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h3 class="fw-bold">Inscriptions</h3>
                    <h1 class="mt-3 text-warning">
                        {{ $enrollmentCount ?? 0 }}
                    </h1>
                </div>
            </div>
        </div>

        <!-- Notes -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h3 class="fw-bold">Notes</h3>
                    <h1 class="mt-3 text-danger">
                        {{ $gradeCount ?? 0 }}
                    </h1>
                </div>
            </div>
        </div>

    @elseif($role === 'teacher')

        <!-- Cours -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h3 class="fw-bold">Cours</h3>
                    <h1 class="mt-3 text-success">
                        {{ $courseCount ?? 0 }}
                    </h1>
                </div>
            </div>
        </div>

        <!-- Notes -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h3 class="fw-bold">Notes</h3>
                    <h1 class="mt-3 text-danger">
                        {{ $gradeCount ?? 0 }}
                    </h1>
                </div>
            </div>
        </div>

    @elseif($role === 'student')

        <!-- Mes notes -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h3 class="fw-bold">Mes notes</h3>
                    <h1 class="mt-3 text-danger">
                        {{ $gradeCount ?? 0 }}
                    </h1>
                </div>
            </div>
        </div>

        <!-- Mes inscriptions -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h3 class="fw-bold">Mes inscriptions</h3>
                    <h1 class="mt-3 text-warning">
                        {{ $enrollmentCount ?? 0 }}
                    </h1>
                </div>
            </div>
        </div>

        <!-- Accès aux cours -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h3 class="fw-bold">Cours</h3>
                    <p class="text-muted mb-3">
                        Consultez la liste des cours et demandez une inscription.
                    </p>

                    <a href="{{ route('courses.index') }}" class="btn btn-primary">
                        Voir les cours
                    </a>
                </div>
            </div>
        </div>

    @endif

</div>

@endsection