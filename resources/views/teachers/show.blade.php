@extends('layouts.academic')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="fw-bold mb-1">Détails de l’enseignant</h1>
        <p class="text-muted mb-0">Informations complètes de l’enseignant.</p>
    </div>

    <a href="{{ route('teachers.index') }}" class="btn btn-secondary">
        Retour
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <p><strong>Nom :</strong> {{ $teacher->user->name ?? '---' }}</p>
        <p><strong>Email :</strong> {{ $teacher->user->email ?? '---' }}</p>
        <p><strong>Spécialité :</strong> {{ $teacher->specialite }}</p>
        <p><strong>Téléphone :</strong> {{ $teacher->telephone ?? '---' }}</p>
    </div>
</div>

@endsection