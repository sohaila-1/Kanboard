@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card shadow-sm p-4 w-100" style="max-width: 600px;">
        <div class="text-center">
            <h2 class="mb-3">👋 Bienvenue <span class="text-primary">{{ Auth::user()->name }}</span></h2>
            <p class="text-muted">Voici un aperçu de votre activité :</p>
        </div>

        <ul class="list-group list-group-flush mb-3">
            <li class="list-group-item">
                🗂️ <strong>{{ $projects_count }}</strong> projet(s) créé(s)
            </li>
            <li class="list-group-item">
                ✅ <strong>{{ $tasks_count }}</strong> tâche(s) au total
            </li>
        </ul>

        <div class="text-center">
            <a href="{{ route('projects.index') }}" class="btn btn-outline-dark">
                📁 Voir mes projets
            </a>
        </div>
    </div>
</div>
@endsection
