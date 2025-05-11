@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #1d2b64, #f8cdda);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .creative-card {
        animation: fadeInUp 1s ease-in-out;
        border-radius: 1rem;
        background-color: rgba(255, 255, 255, 0.15); /* semi-transparent */
        backdrop-filter: blur(10px); /* effet flou */
        color: white; /* texte blanc pour lisibilité */
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .form-label {
        color: white;
    }

    .creative-btn {
        transition: all 0.3s ease;
    }

    .creative-btn:hover {
        transform: scale(1.03);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-6">
            <div class="card creative-card shadow-lg border-0">
                <div class="card-header text-center bg-dark text-white">
                    <h4>🔐 Connexion</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input id="email" type="email" class="form-control" name="email" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input">
                            <label class="form-check-label" for="remember">Se souvenir de moi</label>
                        </div>

                        <button type="submit" class="btn btn-dark creative-btn w-100">Connexion</button>
                    </form>

                    <div class="text-center mt-3">
                        📝 <a href="{{ route('register') }}" class="text-dark">Pas encore inscrit ? Créer un compte</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
