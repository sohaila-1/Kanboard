@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="col-md-6">
        {{-- ✅ Message flash de succès --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- ✅ Message flash d’erreur général --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                Veuillez corriger les erreurs ci-dessous.
            </div>
        @endif

        <div class="card shadow">
            <div class="card-body">
                <h4 class="text-center mb-4">📄 Inscription à Kanboard</h4>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Nom --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">👤 Nom</label>
                        <input type="text" name="name" id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">📧 Email</label>
                        <input type="email" name="email" id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Mot de passe --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">🔒 Mot de passe</label>
                        <input type="password" name="password" id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Confirmation mot de passe --}}
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">🔒 Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
