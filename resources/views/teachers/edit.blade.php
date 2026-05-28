@extends('layouts.academic')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="fw-bold mb-1">Modifier un enseignant</h1>
        <p class="text-muted mb-0">
            Mettre à jour les informations de l’enseignant.
        </p>
    </div>

    <a href="{{ route('teachers.index') }}" class="btn btn-secondary">
        Retour
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">

        <form action="{{ route('teachers.update', $teacher) }}"
              method="POST">

            @csrf
            @method('PUT')

            @include('teachers._form')

            <button type="submit"
                    class="btn btn-primary">
                Mettre à jour
            </button>

        </form>

    </div>
</div>

@endsection