@extends('layouts.app')

@section('title', $project->title)

@section('content')
<div class="container-fluid mt-4 px-3 px-md-5">

    <!-- 🧠 En-tête du projet -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1">{{ $project->title }}</h2>
            <p class="text-muted mb-0">{{ $project->description ?? 'projet' }}</p>
        </div>
        <a href="{{ route('projects.members.add', $project) }}" class="btn btn-outline-success text-nowrap">
            👥 Ajouter un membre
        </a>
    </div>

    <!-- 🔍 Barre d’action -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
        <!-- Formulaire de recherche -->
        <form method="GET" action="{{ route('projects.show', $project) }}" class="d-flex">
            <input
                type="text"
                name="search"
                class="form-control form-control-sm me-2"
                placeholder="🔍 Rechercher une tâche..."
                style="max-width: 220px;"
                value="{{ request('search') }}"
            >
            <button type="submit" class="btn btn-sm btn-outline-primary">Rechercher</button>
        </form>

        <a href="{{ route('tasks.create', $project) }}" class="btn btn-sm btn-outline-primary">➕ Nouvelle tâche</a>
        <a href="{{ route('projects.kanban', $project) }}" class="btn btn-sm btn-outline-primary">🌈 Vue Kanban</a>
        <a href="{{ route('projects.calendar', $project) }}" class="btn btn-sm btn-outline-info">📅 Vue Calendrier</a>
        <a href="{{ route('projects.index') }}" class="btn btn-sm btn-outline-dark">⬅️ Retour</a>
    </div>

    <!-- ✅ Liste des tâches -->
    @if ($tasks->isEmpty())
        <div class="alert alert-info text-center py-4">
            <h5 class="mb-3">📭 Aucune tâche trouvée</h5>
            <p>Ce projet ne contient encore aucune tâche correspondant à votre recherche.</p>
            <a href="{{ route('tasks.create', $project) }}" class="btn btn-sm btn-outline-primary float-end">
                ➕ Ajouter une première tâche
            </a>
        </div>
    @else
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4 mb-5">
            @foreach ($tasks as $task)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title">{{ $task->title }}</h5>

                            <div class="mb-2 d-flex flex-wrap gap-2 align-items-center">
                                @php
                                    $priorityColor = match($task->priority) {
                                        'Élevée' => 'danger',
                                        'Moyenne' => 'warning',
                                        'Basse' => 'success',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $priorityColor }}">
                                    {{ $task->priority ?? 'Priorité ?' }}
                                </span>

                                @if($task->due_date)
                                    <small class="text-muted">
                                        📅 {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                                    </small>
                                @endif
                            </div>

                            <div class="mt-3 d-flex justify-content-end gap-2">
                                <a href="{{ route('tasks.edit', [$project, $task]) }}" class="btn btn-sm btn-outline-warning">✏️</a>
                                <form action="{{ route('tasks.destroy', [$project, $task]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">🗑</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
