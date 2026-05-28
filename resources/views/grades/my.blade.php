@extends('layouts.academic')

@section('content')

<div class="mb-4">
    <h1 class="fw-bold mb-1">Mes notes</h1>
    <p class="text-muted mb-0">Consultation de vos résultats personnels.</p>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Cours</th>
                    <th>Type</th>
                    <th>Note</th>
                    <th>Commentaire</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grades as $grade)
                    <tr>
                        <td>{{ $grade->enrollment?->course?->title ?? '---' }}</td>
                        <td>{{ $grade->type }}</td>
                        <td>{{ $grade->grade }}/20</td>
                        <td>{{ $grade->comment ?? '---' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">Aucune note trouvée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $grades->links() }}
    </div>
</div>

@endsection