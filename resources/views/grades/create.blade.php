@extends('layouts.academic')

@section('content')

<h1 class="fw-bold mb-4">
    Ajouter une note
</h1>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

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

        <form action="{{ route('grades.store') }}"
              method="POST">

            @csrf

            <!-- Inscription validée -->
            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Inscription validée
                </label>

                <select name="enrollment_id"
                        class="form-select"
                        required>

                    <option value="">
                        Choisir une inscription validée
                    </option>

                    @foreach($enrollments as $enrollment)

                        <option value="{{ $enrollment->id }}"
                            {{ old('enrollment_id') == $enrollment->id ? 'selected' : '' }}>

                            {{ $enrollment->student?->user?->name ?? '---' }}
                            —
                            {{ $enrollment->course?->title ?? '---' }}
                            ({{ $enrollment->academic_year }})

                        </option>

                    @endforeach

                </select>

                @error('enrollment_id')
                    <div class="text-danger mt-1">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <!-- Type -->
            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Type
                </label>

                <select name="type"
                        class="form-select"
                        required>

                    <option value="">
                        Choisir un type
                    </option>

                    <option value="TP"
                        {{ old('type') == 'TP' ? 'selected' : '' }}>
                        TP
                    </option>

                    <option value="DS"
                        {{ old('type') == 'DS' ? 'selected' : '' }}>
                        DS
                    </option>

                    <option value="EXAM"
                        {{ old('type') == 'EXAM' ? 'selected' : '' }}>
                        EXAM
                    </option>

                </select>

                @error('type')
                    <div class="text-danger mt-1">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <!-- Note -->
            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Note
                </label>

                <input type="number"
                       step="0.01"
                       min="0"
                       max="20"
                       name="grade"
                       class="form-control"
                       value="{{ old('grade') }}"
                       required>

                @error('grade')
                    <div class="text-danger mt-1">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <!-- Commentaire -->
            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Commentaire
                </label>

                <textarea name="comment"
                          rows="3"
                          class="form-control">{{ old('comment') }}</textarea>

                @error('comment')
                    <div class="text-danger mt-1">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <button type="submit"
                    class="btn btn-primary">
                Enregistrer
            </button>

        </form>

    </div>

</div>

@endsection