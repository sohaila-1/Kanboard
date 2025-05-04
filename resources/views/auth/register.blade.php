@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
    <h1>📝 Inscription</h1>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label for="name">Nom :</label>
        <input type="text" name="name" id="name" required>

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>

        <label for="password_confirmation">Confirmer le mot de passe :</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>

        <button type="submit">S'inscrire</button>
    </form>

    <a href="{{ route('login') }}">🔐 Déjà inscrit ? Connexion</a>
@endsection
