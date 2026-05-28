@extends('layouts.academic')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Modifier un étudiant</h1>

            <a href="{{ route('students.index') }}"
               class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition">
                Retour
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg border border-red-200">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('students.update', $student) }}" method="POST">
                @csrf
                @method('PUT')

                @include('students._form', ['student' => $student])

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection