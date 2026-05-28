<div class="mb-3">
    <label class="form-label">Étudiant</label>

    <select name="student_id" class="form-select">
        <option value="">-- Choisir un étudiant --</option>

        @foreach($students as $student)
            <option value="{{ $student->id }}"
                {{ old('student_id', $grade?->student_id) == $student->id ? 'selected' : '' }}>

                {{ $student->user?->name ?? '---' }}

            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Cours</label>

    <select name="course_id" class="form-select">
        <option value="">-- Choisir un cours --</option>

        @foreach($courses as $course)
            <option value="{{ $course->id }}"
                {{ old('course_id', $grade?->course_id) == $course->id ? 'selected' : '' }}>

                {{ $course->title }}

            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Note</label>

    <input type="number"
           step="0.01"
           name="grade"
           class="form-control"
           value="{{ old('grade', $grade?->grade) }}">
</div>

<div class="mb-3">
    <label class="form-label">Type</label>

    <select name="type" class="form-select">
        <option value="DS">DS</option>
        <option value="Examen">Examen</option>
        <option value="TP">TP</option>
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Commentaire</label>

    <textarea name="comment"
              class="form-control"
              rows="4">{{ old('comment', $grade?->comment) }}</textarea>
</div>