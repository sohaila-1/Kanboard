@extends('layouts.app')

@section('title', 'Mes Projets')

@section('content')
@if(session('success'))
    <div class="container mt-4">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    </div>
@endif
<div class="container mt-4">
    <h2 class="mb-4"><i class="bi bi-kanban"></i> Mes Projets</h2>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach ($projects as $project)
            <div class="col">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">{{ $project->title }}</h5>
                            @if ($project->description)
                                <p class="card-text text-muted">{{ $project->description }}</p>
                            @endif
                        </div>
                        <div class="mt-3 d-flex justify-content-between">
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-primary btn-sm">📄 Voir</a>
                            <a href="{{ route('projects.edit', $project) }}" class="btn btn-outline-warning btn-sm">✏️ Modifier</a>
                            <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">🗑 Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
