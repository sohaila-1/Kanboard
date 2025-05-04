@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
    <h1>🔐 Connexion</h1>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required autofocus>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Se connecter</button>
    </form>

    <a href="{{ route('register') }}">📝 Créer un compte</a>
@endsection
