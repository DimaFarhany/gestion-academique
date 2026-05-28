@extends('layouts.academic')

@section('content')

<h1 class="fw-bold mb-4">
    Détails de la note
</h1>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <p>
            <strong>Étudiant :</strong>
            {{ $grade->student?->user?->name ?? '---' }}
        </p>

        <p>
            <strong>Cours :</strong>
            {{ $grade->course?->title ?? '---' }}
        </p>

        <p>
            <strong>Type :</strong>
            {{ $grade->type }}
        </p>

        <p>
            <strong>Note :</strong>
            {{ $grade->grade }}/20
        </p>

        <p>
            <strong>Commentaire :</strong>
            {{ $grade->comment ?? '---' }}
        </p>

    </div>

</div>

@endsection