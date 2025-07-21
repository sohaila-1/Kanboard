@extends('layouts.app')

@section('title', 'Vérification Email')

@section('content')
<div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="col-md-8">
        @if (session('success'))
            <div class="alert alert-success shadow-sm text-center fs-5">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow border-0">
            <div class="card-body p-4 text-center">
                <h2 class="mb-3">📬 Vérifiez votre adresse email</h2>
                <p class="mb-4">
                    Un email de vérification a été envoyé à <strong>{{ auth()->user()->email }}</strong>.
                    Veuillez cliquer sur le lien dans cet email pour activer votre compte.
                </p>

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary">
                        🔁 Renvoyer l’email de vérification
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
