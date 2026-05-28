@extends('layouts.academic')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="fw-bold mb-1">Liste des enseignants</h1>
        <p class="text-muted mb-0">
            Gestion des enseignants de la plateforme.
        </p>
    </div>

    <a href="{{ route('teachers.create') }}" class="btn btn-primary">
        Ajouter un enseignant
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">

        <table class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Spécialité</th>
                    <th>Téléphone</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($teachers as $teacher)
                    <tr>
                        <td>{{ $teacher->id }}</td>
                        <td>{{ $teacher->specialite }}</td>
                        <td>{{ $teacher->telephone }}</td>

                        <td>
                            <a href="{{ route('teachers.show', $teacher) }}"
                               class="btn btn-sm btn-info text-white">
                                Voir
                            </a>

                            <a href="{{ route('teachers.edit', $teacher) }}"
                               class="btn btn-sm btn-warning text-white">
                                Modifier
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">
                            Aucun enseignant trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>

@endsection