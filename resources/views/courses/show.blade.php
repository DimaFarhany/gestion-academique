@extends('layouts.academic')

@section('content')
    <h1 class="fw-bold mb-4">Détails du cours</h1>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <p><strong>Code :</strong> {{ $course->code }}</p>
            <p><strong>Titre :</strong> {{ $course->title }}</p>
            <p><strong>Description :</strong> {{ $course->description ?? '---' }}</p>
            <p><strong>Crédits :</strong> {{ $course->credits }}</p>
        </div>
    </div>
@endsection