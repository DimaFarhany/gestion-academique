<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Académique</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }

        .sidebar {
            width: 280px;
            min-height: 100vh;
            background-color: #212529;
        }

        .sidebar-title {
            font-size: 24px;
            font-weight: bold;
        }

        .sidebar-link {
            width: 100%;
            text-align: left;
        }

        .content {
            flex-grow: 1;
        }
    </style>
</head>

<body>

@php
    $role = auth()->user()->role ?? 'student';
@endphp

<div class="d-flex">

    <!-- Sidebar -->
    <aside class="sidebar text-white p-4">

        <div class="mb-4">
            <h4 class="sidebar-title">Gestion Académique</h4>
            <small class="text-light">
                Plateforme universitaire
            </small>
        </div>

        <div class="d-grid gap-2">

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="btn {{ request()->routeIs('dashboard') ? 'btn-primary' : 'btn-outline-light' }} sidebar-link">
                Dashboard
            </a>

            @if($role === 'admin')
                <!-- Étudiants -->
                <a href="{{ route('students.index') }}"
                   class="btn {{ request()->routeIs('students.*') ? 'btn-primary' : 'btn-outline-light' }} sidebar-link">
                    Étudiants
                </a>

                <!-- Enseignants -->
                <a href="{{ route('teachers.index') }}"
                   class="btn {{ request()->routeIs('teachers.*') ? 'btn-primary' : 'btn-outline-light' }} sidebar-link">
                    Enseignants
                </a>

                <!-- Cours -->
                <a href="{{ route('courses.index') }}"
                   class="btn {{ request()->routeIs('courses.*') ? 'btn-primary' : 'btn-outline-light' }} sidebar-link">
                    Cours
                </a>

                <!-- Inscriptions -->
                <a href="{{ route('enrollments.index') }}"
                   class="btn {{ request()->routeIs('enrollments.*') ? 'btn-primary' : 'btn-outline-light' }} sidebar-link">
                    Inscriptions
                </a>

                <!-- Notes -->
                <a href="{{ route('grades.index') }}"
                   class="btn {{ request()->routeIs('grades.*') ? 'btn-primary' : 'btn-outline-light' }} sidebar-link">
                    Notes
                </a>

            @elseif($role === 'teacher')

                <!-- Cours -->
                <a href="{{ route('courses.index') }}"
                   class="btn {{ request()->routeIs('courses.*') ? 'btn-primary' : 'btn-outline-light' }} sidebar-link">
                    Cours
                </a>

                <!-- Notes -->
                <a href="{{ route('grades.index') }}"
                   class="btn {{ request()->routeIs('grades.*') ? 'btn-primary' : 'btn-outline-light' }} sidebar-link">
                    Notes
                </a>

            @elseif($role === 'student')

                <!-- Cours -->
                <a href="{{ route('courses.index') }}"
                   class="btn {{ request()->routeIs('courses.*') ? 'btn-primary' : 'btn-outline-light' }} sidebar-link">
                    Cours
                </a>

            @endif

            <!-- Profil -->
            <a href="{{ route('profile.edit') }}"
               class="btn {{ request()->routeIs('profile.*') ? 'btn-primary' : 'btn-outline-light' }} sidebar-link">
                Profil
            </a>

        </div>

        <!-- Logout -->
        <form method="POST"
              action="{{ route('logout') }}"
              class="mt-4">
            @csrf

            <button type="submit"
                    class="btn btn-danger w-100">
                Déconnexion
            </button>
        </form>

    </aside>

    <!-- Content -->
    <main class="content p-4">

        @yield('content')

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>