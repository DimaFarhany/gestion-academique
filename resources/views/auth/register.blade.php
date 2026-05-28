<x-guest-layout>

    @php
        $role = request('role', 'student');
    @endphp

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            Créer un compte
        </h2>

        <p class="text-sm text-gray-500">
            Choisissez d’abord le type de compte à créer.
        </p>
    </div>

    <!-- CHOIX ROLE -->

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-6">

        <!-- ETUDIANT -->
        <a href="{{ route('register', ['role' => 'student']) }}"
           class="px-4 py-3 rounded-lg border text-center font-semibold transition
           {{ $role === 'student'
                ? 'bg-blue-600 text-white border-blue-600'
                : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">

            Étudiant
        </a>

        <!-- ENSEIGNANT -->
        <a href="{{ route('register', ['role' => 'teacher']) }}"
           class="px-4 py-3 rounded-lg border text-center font-semibold transition
           {{ $role === 'teacher'
                ? 'bg-blue-600 text-white border-blue-600'
                : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">

            Enseignant
        </a>

        <!-- ADMIN -->
        <a href="{{ route('register', ['role' => 'admin']) }}"
           class="px-4 py-3 rounded-lg border text-center font-semibold transition
           {{ $role === 'admin'
                ? 'bg-blue-600 text-white border-blue-600'
                : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">

            Administration
        </a>

    </div>

    <!-- FORM -->

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <input type="hidden" name="role" value="{{ $role }}">

        <!-- NOM -->

        <div>
            <x-input-label for="name" :value="__('Nom complet')" />

            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
            />

            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- EMAIL -->

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
            />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- PASSWORD -->

        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- CONFIRM PASSWORD -->

        <div class="mt-4">
            <x-input-label
                for="password_confirmation"
                :value="__('Confirmer le mot de passe')"
            />

            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required
            />

            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2"
            />
        </div>

        <!-- ===================================================== -->
        <!-- ETUDIANT -->
        <!-- ===================================================== -->

        @if($role === 'student')

            <div class="mt-6 p-5 rounded-xl bg-gray-50 border">

                <h3 class="font-bold text-lg mb-4">
                    Informations étudiant
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- MATRICULE AUTO -->

                    <div>
                        <x-input-label for="matricule" :value="__('Matricule')" />

                        <x-text-input
                            id="matricule"
                            class="block mt-1 w-full bg-gray-100"
                            type="text"
                            name="matricule"
                            :value="$matricule ?? ''"
                            readonly
                        />

                        <p class="text-xs text-gray-500 mt-1">
                            Généré automatiquement par le système.
                        </p>

                        <x-input-error
                            :messages="$errors->get('matricule')"
                            class="mt-2"
                        />
                    </div>

                    <!-- NIVEAU -->

                    <div>
                        <x-input-label for="niveau" :value="__('Niveau')" />

                        <x-text-input
                            id="niveau"
                            class="block mt-1 w-full"
                            type="text"
                            name="niveau"
                            :value="old('niveau')"
                            required
                        />

                        <x-input-error
                            :messages="$errors->get('niveau')"
                            class="mt-2"
                        />
                    </div>

                    <!-- FILIERE -->

                    <div class="md:col-span-2">
                        <x-input-label for="filiere" :value="__('Filière')" />

                        <x-text-input
                            id="filiere"
                            class="block mt-1 w-full"
                            type="text"
                            name="filiere"
                            :value="old('filiere')"
                            required
                        />

                        <x-input-error
                            :messages="$errors->get('filiere')"
                            class="mt-2"
                        />
                    </div>

                </div>

            </div>

        @endif

        <!-- ===================================================== -->
        <!-- ENSEIGNANT -->
        <!-- ===================================================== -->

        @if($role === 'teacher')

            <div class="mt-6 p-5 rounded-xl bg-gray-50 border">

                <h3 class="font-bold text-lg mb-4">
                    Informations enseignant
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- SPECIALITE -->

                    <div class="md:col-span-2">
                        <x-input-label for="specialite" :value="__('Spécialité')" />

                        <x-text-input
                            id="specialite"
                            class="block mt-1 w-full"
                            type="text"
                            name="specialite"
                            :value="old('specialite')"
                            required
                        />

                        <x-input-error
                            :messages="$errors->get('specialite')"
                            class="mt-2"
                        />
                    </div>

                    <!-- TELEPHONE -->

                    <div class="md:col-span-2">
                        <x-input-label for="telephone" :value="__('Téléphone')" />

                        <x-text-input
                            id="telephone"
                            class="block mt-1 w-full"
                            type="text"
                            name="telephone"
                            :value="old('telephone')"
                            required
                        />

                        <x-input-error
                            :messages="$errors->get('telephone')"
                            class="mt-2"
                        />
                    </div>

                </div>

            </div>

        @endif

        <!-- ===================================================== -->
        <!-- ADMIN -->
        <!-- ===================================================== -->

        @if($role === 'admin')

            <div class="mt-6 p-5 rounded-xl bg-gray-50 border">

                <h3 class="font-bold text-lg mb-4">
                    Accès administration
                </h3>

                <div>

                    <x-input-label
                        for="admin_code"
                        :value="__('Code administrateur')"
                    />

                    <x-text-input
                        id="admin_code"
                        class="block mt-1 w-full"
                        type="password"
                        name="admin_code"
                        required
                    />

                    <x-input-error
                        :messages="$errors->get('admin_code')"
                        class="mt-2"
                    />

                </div>

                <p class="text-sm text-gray-500 mt-2">
                    Le code doit être fourni par l’administration.
                </p>

            </div>

        @endif

        <!-- ACTIONS -->

        <div class="flex items-center justify-between mt-6">

            <a
                class="underline text-sm text-gray-600 hover:text-gray-900"
                href="{{ route('login') }}"
            >
                Déjà inscrit ?
            </a>

            <x-primary-button class="ms-4">
                Créer le compte
            </x-primary-button>

        </div>

    </form>

</x-guest-layout>