@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
    <div class="card shadow p-4" style="min-width: 400px;">
        <h4 class="text-center mb-4">🔐 Réinitialiser le mot de passe</h4>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="mb-3">
                <label for="password" class="form-label">🆕 Nouveau mot de passe</label>
                <input type="password" id="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       required>

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">🔁 Confirmer le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">
                Réinitialiser mon mot de passe
            </button>
        </form>
    </div>
</div>
@endsection
