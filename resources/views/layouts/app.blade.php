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

        .sidebar h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #111;
            margin-bottom: 2rem;
            text-align: center;
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
            width: 100%; /* ✅ assure largeur plein écran */
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
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="sidebar">
            @if (!request()->is('/'))
                <a href="{{ route('home') }}" class="text-center fw-bold mb-4">
                    <span class="text-center fw-bold mb-4">🏠</span> Accueil
                </a>
            @endif
            <a href="{{ route('projects.create') }}">➕ Nouveau projet</a>
            <a href="{{ route('projects.index') }}">📁 Mes projets</a>
                {{-- Bouton retour contextuel --}}
            @if (Str::contains(Request::url(), ['kanban', 'calendar']))
            <a href="{{ route('projects.show', $project ?? request()->route('project')) }}" >⬅️ Retour au {{ $project->title }}</a>
            @endif
            <div class="mt-4">
                <button id="toggle-dark" class="btn btn-sm btn-outline-dark w-100">
                        🌙 Mode sombre
                </button>
            </div>


            @auth
                <a href="#">⚙️ Modifier profil</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-auto">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 mt-3">🚪 Se déconnecter</button>
                </form>
            @endauth
            
            @guest
                <div class="mt-auto">
                    <a href="{{ route('register') }}" class="btn btn-outline-primary w-100 mb-2">📝 S'inscrire</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100">🔐 Se connecter</a>
                </div>
            @endguest
        </div>

        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <footer>
        © {{ date('Y') }} Kanboard — Tous droits réservés.
    </footer>
    <script>
        // Toggle Dark Mode
        const toggleBtn = document.getElementById('toggle-dark');
        const html = document.documentElement;

        if (localStorage.getItem('theme') === 'dark') {
            html.classList.add('dark-mode');
        }

        toggleBtn.addEventListener('click', () => {
            html.classList.toggle('dark-mode');
            localStorage.setItem('theme', html.classList.contains('dark-mode') ? 'dark' : 'light');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
