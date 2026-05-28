@extends('layouts.academic')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Détails de l'étudiant</h1>

            <a href="{{ route('students.index') }}"
               class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition">
                Retour
            </a>
        </div>

        <div class="bg-white shadow rounded-lg p-6 space-y-4">
            <p><strong>Nom :</strong> {{ $student->user?->name ?? '---' }}</p>
            <p><strong>Email :</strong> {{ $student->user?->email ?? '---' }}</p>
            <p><strong>Matricule :</strong> {{ $student->matricule }}</p>
            <p><strong>Sexe :</strong> {{ $student->sexe ?? '---' }}</p>
            <p><strong>Date de naissance :</strong> {{ $student->date_naissance?->format('d/m/Y') ?? '---' }}</p>
            <p><strong>Niveau :</strong> {{ $student->niveau }}</p>
            <p><strong>Filière :</strong> {{ $student->filiere }}</p>
        </div>
    </div>
@endsection