@extends('layouts.academic')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Modifier une inscription</h1>
            <p class="text-muted mb-0">Mettre à jour une inscription existante.</p>
        </div>

        <a href="{{ route('enrollments.index') }}" class="btn btn-secondary">
            Retour
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('enrollments.update', $enrollment) }}" method="POST">
                @csrf
                @method('PUT')

                @include('enrollments._form', ['enrollment' => $enrollment])

                <button type="submit" class="btn btn-primary">
                    Mettre à jour
                </button>
            </form>
        </div>
    </div>
@endsection