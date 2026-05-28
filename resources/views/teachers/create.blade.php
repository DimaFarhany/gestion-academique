@extends('layouts.academic')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="fw-bold mb-1">Ajouter un enseignant</h1>
        <p class="text-muted mb-0">Création d’un nouvel enseignant.</p>
    </div>

    <a href="{{ route('teachers.index') }}" class="btn btn-secondary">
        Retour
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">

        <form action="{{ route('teachers.store') }}" method="POST">
            @csrf

            @include('teachers._form')

            <button type="submit" class="btn btn-primary">
                Enregistrer
            </button>
        </form>

    </div>
</div>

@endsection