@extends('layouts.app')

@section('title', 'Mot de passe oublié')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height: 75vh;">
    <div class="card shadow p-4" style="min-width: 400px;">
        <h4 class="text-center mb-4">🔑 Mot de passe oublié</h4>

        @if (session('status'))
            <div class="alert alert-success text-center">
                ✅ {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">📧 Adresse email</label>
                <input type="email" id="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       required autofocus value="{{ old('email') }}">

                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Envoyer le lien de réinitialisation
            </button>
        </form>
    </div>
</div>
@endsection
