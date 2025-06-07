@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="text-center">🧭 Menu</h5>
                    <hr>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('projects.create') }}" class="btn btn-outline-primary w-100">➕ Nouveau projet</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary w-100">📁 Voir mes projets</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="btn btn-outline-info w-100">⚙️ Modifier mes infos</a> {{-- à implémenter --}}
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100">🚪 Se déconnecter</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h2>👋 Bienvenue <span class="text-primary">{{ Auth::user()->name }}</span></h2>
                    <p class="text-muted">Voici un aperçu de votre activité :</p>

                    <hr>

                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item">
                            📁 <strong>{{ $projects_count }}</strong> projet(s) créé(s)
                        </li>
                        <li class="list-group-item">
                            ✅ <strong>{{ $tasks_count }}</strong> tâche(s) au total
                        </li>
                    </ul>

                    <a href="{{ route('projects.index') }}" class="btn btn-dark">📂 Voir mes projets</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
