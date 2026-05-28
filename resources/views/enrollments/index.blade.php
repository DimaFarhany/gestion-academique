@extends('layouts.academic')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Liste des inscriptions</h1>
            <p class="text-muted mb-0">
                Gestion des demandes d’inscription des étudiants.
            </p>
        </div>
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
                        <th>Étudiant</th>
                        <th>Cours</th>
                        <th>Année académique</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($enrollments as $enrollment)

                        <tr>

                            <td>
                                {{ $enrollment->id }}
                            </td>

                            <td>
                                {{ $enrollment->student?->user?->name ?? '---' }}
                            </td>

                            <td>
                                {{ $enrollment->course?->title ?? '---' }}
                            </td>

                            <td>
                                {{ $enrollment->academic_year }}
                            </td>

                            <td>

                                @if($enrollment->status === 'pending')

                                    <span class="badge bg-warning text-dark">
                                        En attente
                                    </span>

                                @elseif($enrollment->status === 'validated')

                                    <span class="badge bg-success">
                                        Validée
                                    </span>

                                @elseif($enrollment->status === 'refused')

                                    <span class="badge bg-danger">
                                        Refusée
                                    </span>

                                @endif

                            </td>

                            <td>

                                <a href="{{ route('enrollments.show', $enrollment) }}"
                                   class="btn btn-sm btn-info text-white">
                                    Voir
                                </a>

                                @if($enrollment->status === 'pending')

                                    <form action="{{ route('enrollments.approve', $enrollment) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                class="btn btn-sm btn-success">
                                            Valider
                                        </button>

                                    </form>

                                    <form action="{{ route('enrollments.refuse', $enrollment) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger">
                                            Refuser
                                        </button>

                                    </form>

                                @endif

                                <form action="{{ route('enrollments.destroy', $enrollment) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Supprimer cette inscription ?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger">
                                        Supprimer
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center py-4">
                                Aucune inscription trouvée.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

            {{ $enrollments->links() }}

        </div>
    </div>
@endsection