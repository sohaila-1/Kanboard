<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>@yield('title', 'Kanboard')</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .page-wrapper {
            flex: 1;
            display: flex;
            min-height: 0;
        }

        .sidebar {
            width: 240px;
            height: 100%;
            background-color: #fff;
            border-right: 1px solid #eee;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            padding: 2rem 1rem;
        }

        .sidebar a {
            color: #333;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.45rem 0.75rem;
            margin-bottom: 0.5rem;
            border-radius: 0.4rem;
            text-decoration: none;
            transition: background 0.2s ease;
        }

        .sidebar a:hover {
            background-color: #f0f0f0;
        }

        .sidebar a.active {
            background-color: #e8f0fe;
            font-weight: 600;
            color: #1a73e8;
        }

        .main-content {
            flex: 1;
            overflow-y: auto;
            padding: 2rem;
            width: 100%;
        }

        footer {
            height: 60px;
            background: #f8f9fa;
            text-align: center;
            line-height: 60px;
            font-size: 0.85rem;
            color: #888;
            border-top: 1px solid #ddd;
        }

        /* 🌙 Dark mode styles */
        .dark-mode {
            background-color: #2D4C63 !important;
            color: #f0f0f0;
        }

        .dark-mode .sidebar {
            background-color: #333 !important;
            color: #f0f0f0;
        }

        .dark-mode .sidebar a {
            color: #f0f0f0;
        }

        .dark-mode .sidebar a:hover {
            background-color: #3F6B6D;
        }

        .dark-mode .main-content {
            background-color: #1e2b38;
            color: #e6e6e6;
        }

        .dark-mode footer {
            background: #2D4C63;
            color: #ccc;
        }

        .dark-mode .btn-outline-dark {
            background-color: #800020;
            color: white;
            border-color: #800020;
        }

        /* 🎯 Sidebar mobile visible */
        #sidebar.mobile-visible {
            display: block !important;
            position: absolute;
            top: 56px;
            left: 0;
            width: 75%;
            background-color: white;
            z-index: 1050;
            height: calc(100% - 56px);
            box-shadow: 2px 0 10px rgba(0,0,0,0.2);
        }
</style>
</head>

<body>
<!-- 🔘 Bouton burger visible uniquement sur mobile -->
<button id="burger-toggle" class="btn btn-outline-secondary d-md-none m-2">
        ☰ Menu
</button>

    <div class="page-wrapper">
<!-- 📚 Sidebar -->
<div id="sidebar" class="sidebar d-none d-md-flex flex-column">
            @if (!request()->is('/'))
                <a href="{{ url('/') }}">🏠 Accueil</a>
            @endif

            @auth
                <a href="{{ route('projects.create') }}">➕ Nouveau projet</a>
                <a href="{{ route('projects.index') }}">📁 Mes projets</a>

                @if (Str::contains(Request::url(), ['kanban', 'calendar']))
                    <a href="{{ route('projects.show', $project ?? request()->route('project')) }}">
                        ⬅️ Retour au {{ $project->title ?? 'projet' }}
                    </a>
                @endif

                <a href="{{ route('profile.edit') }}">⚙️ Modifier profil</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-auto">
                                    @csrf
                <button type="submit" class="btn btn-outline-danger w-100 mt-3">🚪 Se déconnecter</button>
                </form>
            @endauth

            <div class="mt-4">
                    <button id="toggle-dark" class="btn btn-sm btn-outline-dark w-100">
                    🌙 Mode sombre
            </button>
</div>
</div>

        <!-- Contenu principal -->
<div class="main-content">
            @yield('content')
</div>
</div>

    <footer>
        © {{ date('Y') }} Kanboard — Tous droits réservés.
</footer>

    <!-- 📱 Script burger menu -->
<script>
        const burgerBtn = document.getElementById('burger-toggle');
        const sidebar = document.getElementById('sidebar');

        burgerBtn.addEventListener('click', () => {
            sidebar.classList.toggle('mobile-visible');
        });

        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !burgerBtn.contains(e.target)) {
                sidebar.classList.remove('mobile-visible');
            }
        });
</script>

    <!-- 🌙 Dark Mode Script -->
<script>
        const toggleDark = document.getElementById('toggle-dark');
        const html = document.documentElement;

        if (localStorage.getItem('theme') === 'dark') {
            html.classList.add('dark-mode');
        }

        toggleDark?.addEventListener('click', () => {
            html.classList.toggle('dark-mode');
            localStorage.setItem('theme', html.classList.contains('dark-mode') ? 'dark' : 'light');
        });
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>

