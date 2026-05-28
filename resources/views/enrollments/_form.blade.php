<div class="mb-3">
    <label class="form-label">Étudiant</label>
    <select name="student_id" class="form-select" required>
        <option value="">-- Choisir un étudiant --</option>
        @foreach($students as $student)
            <option value="{{ $student->id }}"
                {{ old('student_id', $enrollment?->student_id) == $student->id ? 'selected' : '' }}>
                {{ $student->user?->name ?? '---' }} - {{ $student->matricule }}
            </option>
        @endforeach
    </select>
    @error('student_id')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Cours</label>
    <select name="course_id" class="form-select" required>
        <option value="">-- Choisir un cours --</option>
        @foreach($courses as $course)
            <option value="{{ $course->id }}"
                {{ old('course_id', $enrollment?->course_id) == $course->id ? 'selected' : '' }}>
                {{ $course->title }}
            </option>
        @endforeach
    </select>
    @error('course_id')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Année académique</label>
    <input
        type="text"
        name="academic_year"
        class="form-control"
        value="{{ old('academic_year', $enrollment?->academic_year) }}"
        placeholder="2025-2026"
        required
    >
    @error('academic_year')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Statut</label>
    <select name="status" class="form-select" required>
        <option value="">-- Choisir un statut --</option>
        <option value="en attente" {{ old('status', $enrollment?->status) == 'en attente' ? 'selected' : '' }}>
            En attente
        </option>
        <option value="validée" {{ old('status', $enrollment?->status) == 'validée' ? 'selected' : '' }}>
            Validée
        </option>
        <option value="refusée" {{ old('status', $enrollment?->status) == 'refusée' ? 'selected' : '' }}>
            Refusée
        </option>
    </select>
    @error('status')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>