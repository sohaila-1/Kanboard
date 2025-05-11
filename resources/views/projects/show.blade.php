@extends('layouts.app')

@section('title', $project->title)

@section('content')
<div class="container mt-4">
    <!-- Titre et description -->
    <div class="mb-4">
        <h2 class="fw-bold">{{ $project->title }}</h2>
        @if ($project->description)
            <p class="text-muted">{{ $project->description }}</p>
        @else
            <p class="text-muted">projet</p>
        @endif
    </div>

    <!-- Titre et bouton tâche -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">📌 Tâches</h4>
        <a href="{{ route('tasks.create', $project) }}" class="btn btn-primary">➕ Nouvelle tâche</a>
    </div>

    @if ($project->tasks->count())
        <!-- Affichage style cartes -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4">
            @foreach ($project->tasks as $task)
                <div class="col">
                    <div class="card shadow-sm h-100 border-0" style="background-color: #fefefe; border-radius: 10px;">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title">{{ $task->title }}</h5>
                                @if ($task->description)
                                    <p class="card-text text-muted small">{{ $task->description }}</p>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="badge bg-secondary">{{ $task->category }}</span>
                                <div>
                                    <a href="{{ route('tasks.edit', [$project, $task]) }}" class="btn btn-sm btn-outline-warning me-1">✏️</a>
                                    <form action="{{ route('tasks.destroy', [$project, $task]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">🗑</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted">Aucune tâche pour ce projet.</p>
    @endif

    <!-- Boutons bas de page -->
    <div class="d-flex gap-2 mt-3">
        <a href="{{ route('projects.kanban', $project) }}" class="btn btn-outline-info">🧩 Vue Kanban</a>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">⬅️ Retour aux projets</a>
    </div>
</div>
@endsection
