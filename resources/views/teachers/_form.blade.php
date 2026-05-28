<div class="mb-3">
    <label class="form-label fw-semibold">Nom complet</label>
    <input type="text"
           name="name"
           class="form-control"
           value="{{ old('name', $teacher->user->name ?? '') }}"
           required>
    @error('name')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Email</label>
    <input type="email"
           name="email"
           class="form-control"
           value="{{ old('email', $teacher->user->email ?? '') }}"
           required>
    @error('email')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Mot de passe</label>
    <input type="password"
           name="password"
           class="form-control"
           placeholder="Laisser vide pour garder l’ancien mot de passe">
    @error('password')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Téléphone</label>
    <input type="text"
           name="telephone"
           class="form-control"
           value="{{ old('telephone', $teacher->telephone ?? '') }}">
    @error('telephone')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label class="form-label fw-semibold">Spécialité</label>
    <input type="text"
           name="specialite"
           class="form-control"
           value="{{ old('specialite', $teacher->specialite ?? '') }}"
           required>
    @error('specialite')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>