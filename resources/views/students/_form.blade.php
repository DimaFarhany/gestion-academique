<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block font-medium text-sm text-gray-700">Utilisateur</label>
        <select name="user_id" class="w-full border-gray-300 rounded-lg mt-1">
            <option value="">-- Choisir un utilisateur --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}"
                    {{ old('user_id', $student?->user_id) == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} - {{ $user->email }}
                </option>
            @endforeach
        </select>
        @error('user_id')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block font-medium text-sm text-gray-700">Matricule</label>
        <input type="text" name="matricule"
               value="{{ old('matricule', $student?->matricule) }}"
               class="w-full border-gray-300 rounded-lg mt-1">
        @error('matricule')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block font-medium text-sm text-gray-700">Sexe</label>
        <select name="sexe" class="w-full border-gray-300 rounded-lg mt-1">
            <option value="">-- Choisir --</option>
            <option value="Homme" {{ old('sexe', $student?->sexe) == 'Homme' ? 'selected' : '' }}>Homme</option>
            <option value="Femme" {{ old('sexe', $student?->sexe) == 'Femme' ? 'selected' : '' }}>Femme</option>
        </select>
        @error('sexe')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block font-medium text-sm text-gray-700">Date de naissance</label>
        <input type="date" name="date_naissance"
               value="{{ old('date_naissance', $student?->date_naissance?->format('Y-m-d')) }}"
               class="w-full border-gray-300 rounded-lg mt-1">
        @error('date_naissance')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block font-medium text-sm text-gray-700">Niveau</label>
        <input type="text" name="niveau"
               value="{{ old('niveau', $student?->niveau) }}"
               class="w-full border-gray-300 rounded-lg mt-1">
        @error('niveau')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block font-medium text-sm text-gray-700">Filière</label>
        <input type="text" name="filiere"
               value="{{ old('filiere', $student?->filiere) }}"
               class="w-full border-gray-300 rounded-lg mt-1">
        @error('filiere')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>