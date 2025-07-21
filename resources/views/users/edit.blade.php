@extends('layouts.app')

@section('title', 'Modifier mon profil')

@section('content')
<div class="container mt-4" style="max-width: 600px;">
    <h2 class="mb-4">⚙️ Modifier mon profil</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(isset($user))
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nom -->
        <div class="mb-3">
            <label for="name" class="form-label">👤 Nom</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">📧 Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <!-- Mot de passe -->
        <div class="mb-3">
            <label for="password" class="form-label">🔐 Nouveau mot de passe (optionnel)</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Laisser vide pour ne pas changer">
        </div>

        <!-- Confirmation mot de passe -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">🔐 Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">⬅️ Retour</a>
    </form>
    @else
        <div class="alert alert-danger">
            Utilisateur introuvable.
        </div>
    @endif
</div>
@endsection
