@extends('layouts.academic')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="fw-bold mb-1">Modifier un cours</h1>
        <p class="text-muted mb-0">Mettre à jour le cours et son enseignant.</p>
    </div>

    <a href="{{ route('courses.index') }}" class="btn btn-secondary">Retour</a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <form action="{{ route('courses.update', $course) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Code</label>
                <input type="text" name="code" class="form-control" value="{{ old('code', $course->code) }}" required>
                @error('code') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Titre</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $course->title) }}" required>
                @error('title') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $course->description) }}</textarea>
                @error('description') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Crédits</label>
                <input type="number" name="credits" class="form-control" value="{{ old('credits', $course->credits) }}" required>
                @error('credits') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Enseignant</label>
                <select name="teacher_id" class="form-select" required>
                    <option value="">-- Choisir un enseignant --</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('teacher_id', $course->teacher_id) == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->user?->name ?? '---' }} - {{ $teacher->specialite }}
                        </option>
                    @endforeach
                </select>
                @error('teacher_id') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
</div>
@endsection