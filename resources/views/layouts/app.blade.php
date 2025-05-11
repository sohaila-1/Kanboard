<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Kanboard')</title>
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }


    main {
        flex: 1;
    }

    .kanban-board {
        display: flex;
        gap: 1.5rem;
        overflow-x: auto;
        padding-bottom: 1rem;
    }

    .kanban-column {
        min-width: 300px;
        background-color: #ebecf0;
        border-radius: 10px;
        padding: 1rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .kanban-column h4 {
        font-size: 1.1rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .kanban-card {
        background-color: white;
        border-radius: 6px;
        padding: 0.75rem;
        margin-bottom: 0.75rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: transform 0.1s;
    }

    .kanban-card:hover {
        transform: scale(1.02);
    }
</style>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('projects.index') }}">Kanboard</a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('projects.create') }}">➕ Nouveau projet</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @auth
                    <li class="nav-item">
                        <span class="nav-link">👋 {{ Auth::user()->name }}</span>
                    </li>
                    <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link" style="padding: 0;">🚪 Se déconnecter</button>
                    </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">📝 S'inscrire</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">🔐 Se connecter</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<main class="container mt-4">
    @yield('content')
</main>

<footer class="bg-dark text-white text-center py-3">
        <div class="container">
            <small>© {{ date('Y') }} Kanboard — Tous droits réservés.</small>
        </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')

</body>
</html>
