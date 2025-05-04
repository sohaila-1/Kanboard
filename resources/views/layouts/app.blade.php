<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Kanboard')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

<nav>
    <a href="{{ route('projects.index') }}">🏠 Accueil</a>
    <a href="{{ route('projects.create') }}">➕ Nouveau projet</a>

    @auth
        <span style="margin-left: 2rem;">👋 {{ Auth::user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" style="background:none; color:white; border:none; cursor:pointer;">🚪 Se déconnecter</button>
        </form>
    @else
        <a href="{{ route('login') }}" style="float: right;">🔐 Se connecter</a>
        <a href="{{ route('register') }}" style="float: right; margin-right: 1rem;">📝 S'inscrire</a>
    @endauth
</nav>


<div class="container">
    @yield('content')
</div>

</body>
</html>
