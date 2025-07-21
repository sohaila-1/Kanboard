@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
    <div class="card shadow p-4" style="min-width: 400px;">
        <h4 class="text-center mb-4">📝 Inscription à Kanboard</h4>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nom -->
            <div class="mb-3">
                <label for="name" class="form-label">👤 Nom</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">📧 Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <!-- Mot de passe -->
            <div class="mb-3">
                <label for="password" class="form-label">🔐 Mot de passe</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <!-- Confirmation -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">🔐 Confirmer le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">S’inscrire</button>
        </form>
    </div>
</div>
@endsection
