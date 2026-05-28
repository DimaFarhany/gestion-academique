@extends('layouts.academic')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="fw-bold mb-1">Mes inscriptions</h1>
        <p class="text-muted mb-0">Liste de vos cours inscrits et de leur statut.</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Cours</th>
                    <th>Année académique</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enrollments as $enrollment)
                    <tr>
                        <td>{{ $enrollment->course?->title ?? '---' }}</td>
                        <td>{{ $enrollment->academic_year }}</td>
                        <td>
                            @if($enrollment->status === 'validée')
                                <span class="badge bg-success">Validée</span>
                            @elseif($enrollment->status === 'refusée')
                                <span class="badge bg-danger">Refusée</span>
                            @else
                                <span class="badge bg-warning text-dark">En attente</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4">
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