@extends('layouts.academic')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-slate-800">
            Liste des étudiants
        </h1>

        <a href="{{ route('students.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Ajouter un étudiant
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-100 text-slate-700">
                    <tr>
                        <th class="p-3 border-b">Nom</th>
                        <th class="p-3 border-b">Matricule</th>
                        <th class="p-3 border-b">Niveau</th>
                        <th class="p-3 border-b">Filière</th>
                        <th class="p-3 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr class="hover:bg-slate-50">
                            <td class="p-3 border-b">
                                {{ $student->user?->name ?? '---' }}
                            </td>
                            <td class="p-3 border-b">{{ $student->matricule }}</td>
                            <td class="p-3 border-b">{{ $student->niveau }}</td>
                            <td class="p-3 border-b">{{ $student->filiere }}</td>
                            <td class="p-3 border-b">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('students.show', $student) }}"
                                       class="text-blue-600 hover:underline">
                                        Voir
                                    </a>

                                    <a href="{{ route('students.edit', $student) }}"
                                       class="text-yellow-600 hover:underline">
                                        Modifier
                                    </a>

                                    <form action="{{ route('students.destroy', $student) }}"
                                          method="POST"
                                          onsubmit="return confirm('Supprimer cet étudiant ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-slate-500">
                                Aucun étudiant trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $students->links() }}
    </div>
@endsection