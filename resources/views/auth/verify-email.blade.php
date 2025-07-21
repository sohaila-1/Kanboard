@extends('layouts.app')

@section('title', 'Vérifiez votre email')

@section('content')
<div class="container mt-5 text-center">
    <h2 class="mb-3">📧 Vérifiez votre adresse email</h2>
    <p>Un lien de vérification a été envoyé à <strong>{{ auth()->user()->email }}</strong>.</p>
    <p>Veuillez cliquer sur le lien pour accéder à votre espace.</p>

    @if (session('status'))
        <div class="alert alert-success mt-3">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}" class="mt-4">
        @csrf
        <button type="submit" class="btn btn-outline-primary">🔁 Renvoyer le lien</button>
    </form>
</div>
@endsection
