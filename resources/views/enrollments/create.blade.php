@extends('layouts.academic')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Ajouter une inscription</h1>
            <p class="text-muted mb-0">Inscrire un étudiant à un cours.</p>
        </div>

        <a href="{{ route('enrollments.index') }}" class="btn btn-secondary">
            Retour
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('enrollments.store') }}" method="POST">
                @csrf

                @include('enrollments._form', ['enrollment' => null])

                <button type="submit" class="btn btn-primary">
                    Enregistrer
                </button>
            </form>
        </div>
    </div>
@endsection