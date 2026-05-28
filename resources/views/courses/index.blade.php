@extends('layouts.academic')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Liste des cours</h1>
            <p class="text-muted mb-0">Gestion des cours universitaires.</p>
        </div>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('courses.create') }}" class="btn btn-primary">
                Ajouter un cours
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Titre</th>
                        <th>Enseignant</th>
                        <th>Crédits</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        @php
                            $status = isset($requests) ? ($requests[$course->id] ?? null) : null;
                        @endphp

                        <tr>
                            <td>{{ $course->id }}</td>
                            <td>{{ $course->code }}</td>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->teacher?->user?->name ?? '---' }}</td>
                            <td>{{ $course->credits }}</td>
                            <td>
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-info text-white">
                                        Voir
                                    </a>
                                    <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-warning text-white">
                                        Modifier
                                    </a>
                                @elseif(auth()->user()->role === 'teacher')
                                    <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-info text-white">
                                        Voir
                                    </a>
                                @elseif(auth()->user()->role === 'student')
                                    @if(!$status)
                                        <form action="{{ route('courses.request-enrollment', $course) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                Demander inscription
                                            </button>
                                        </form>
                                    @elseif($status === 'pending')
                                        <span class="badge bg-warning text-dark">En attente</span>
                                    @elseif($status === 'validated')
                                        <span class="badge bg-success">Validée</span>
                                    @elseif($status === 'refused')
                                        <span class="badge bg-danger">Refusée</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Aucun cours trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $courses->links() }}
        </div>
    </div>
@endsection