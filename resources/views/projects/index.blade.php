@extends('layouts.app')

@section('title', 'Mes Projets')

@section('content')
<div class="main-content">

    <!-- 🔍 Barre de recherche -->
    <form method="GET" action="{{ route('projects.index') }}" class="mb-4 search-bar">
        <div class="input-group">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="🔍 Rechercher un projet..."
                value="{{ request('search') }}"
            >
            <button class="btn btn-outline-primary" type="submit">Rechercher</button>
        </div>
    </form>

    <!-- 🖼️ Galerie des projets -->
    @if($projects->isEmpty())
        <div class="alert alert-info">Aucun projet trouvé.</div>
    @else
    <div class="project-gallery">
        @foreach($projects as $project)
            <div class="project-card">
                <h5 class="fw-bold mb-1">{{ $project->title }}</h5>
                <p class="text-muted mb-2">{{ $project->description ?? 'projet' }}</p>

                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('projects.show', $project) }}" class="btn-icon" title="Voir">📄</a>
                    <a href="{{ route('projects.edit', $project) }}"class="btn-icon" title="Modifier">✏️</a>
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn-icon" type="submit" title="Supprimer">🗑️</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    @endif

</div>
@endsection
