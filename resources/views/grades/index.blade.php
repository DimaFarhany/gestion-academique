@extends('layouts.academic')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="fw-bold mb-1">Liste des notes</h1>
        <p class="text-muted mb-0">Gestion des notes des étudiants.</p>
    </div>

    <a href="{{ route('grades.create') }}" class="btn btn-primary">
        Ajouter une note
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Étudiant</th>
                    <th>Cours</th>
                    <th>Type</th>
                    <th>Note</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grades as $grade)
                    <tr>
                        <td>{{ $grade->enrollment?->student?->user?->name ?? '---' }}</td>
                        <td>{{ $grade->enrollment?->course?->title ?? '---' }}</td>
                        <td>{{ $grade->type }}</td>
                        <td>{{ $grade->grade }}/20</td>
                        <td>
                            <a href="{{ route('grades.show', $grade) }}" class="btn btn-sm btn-info text-white">Voir</a>
                            <a href="{{ route('grades.edit', $grade) }}" class="btn btn-sm btn-warning text-white">Modifier</a>
                            <form action="{{ route('grades.destroy', $grade) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette note ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Aucune note trouvée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $grades->links() }}
    </div>
</div>

@endsection