@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="container text-center py-5">
    <h1 class="display-4 fw-bold mb-3">Bienvenue sur <span class="text-primary">Kanboard</span></h1>
    <p class="lead text-muted">Un outil collaboratif pour organiser, suivre et réussir vos projets</p>

    <div class="d-flex justify-content-center gap-3 my-4">
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-person-plus"></i> S'inscrire
        </a>
        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
            <i class="bi bi-lock"></i> Se connecter
        </a>
    </div>
    <div class="my-4">
        <img src="{{ asset('images/kanban.png') }}" alt="Illustration Kanban"
        class="img-fluid" style="max-height: 300px;">
    </div>

    <div class="card shadow-sm mt-5 mx-auto" style="max-width: 600px;">
        <div class="card-body text-start">
            <h5 class="card-title mb-3">🔧 Fonctionnalités principales</h5>
            <ul class="list-unstyled">
                <li class="mb-2">✅ Création et gestion de projets et tâches</li>
                <li class="mb-2">📌 Vue Kanban intuitive avec glisser-déposer</li>
                <li class="mb-2">📅 Calendrier avec date et heure</li>
                <li class="mb-2">👥 Gestion des membres de projet</li>
                <li class="mb-2">🌓 Mode sombre disponible</li>
            </ul>
        </div>
    </div>
</div>
@endsection
