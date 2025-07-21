@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height: 75vh;">
    <div class="card shadow p-4" style="min-width: 400px;">
        <h4 class="text-center mb-4">🔐 Connexion à Kanboard</h4>

        @if (session('status'))
            <div class="alert alert-info">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">📧 Email</label>
                <input type="email" id="email" name="email" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">🔒 Mot de passe</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3 d-flex justify-content-between">
                <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
        </form>
    </div>
</div>
@endsection
