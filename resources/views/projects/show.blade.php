@extends('layouts.app')

@section('title', 'Projet : ' . $project->title)

@section('content')

@if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container mt-4">
    <h2 class="mb-1">📁 {{ $project->title }}</h2>
    <p class="text-muted">Créé le : {{ $project->created_at->format('d/m/Y') }}</p>
    <p><strong>Chef de projet :</strong> {{ $project->creator->name ?? 'Inconnu' }}</p>
    <hr>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">🗂️ Tâches du projet</h4>
        <a href="{{ route('tasks.create', $project->id) }}" class="btn btn-primary">➕ Ajouter une tâche</a>
    </div>

    @if ($tasks->isEmpty())
        <div class="alert alert-info mt-3">Aucune tâche n’a été ajoutée à ce projet pour le moment.</div>
    @else
        @foreach ($tasks as $task)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $task->title }}</h5>
                    <strong>Créée par :</strong> <span class="badge bg-info text-dark">{{ $task->creator->name ?? 'Inconnu' }}</span>
                    <p class="mb-1"><strong>Catégorie :</strong>
                        @if ($task->category)
                            <span class="badge
                                @switch($task->category)
                                    @case('à faire') bg-secondary @break
                                    @case('en cours') bg-warning text-dark @break
                                    @case('fait') bg-success @break
                                    @case('annulé') bg-danger @break
                                    @default bg-light text-dark
                                @endswitch">
                                {{ ucfirst($task->category) }}
                            </span>
                        @else
                            <span class="text-muted">Non définie</span>
                        @endif
                    </p>
                    <p class="mb-1"><strong>Échéance :</strong>
                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Aucune' }}
                    </p>
                    <p class="mb-3"><strong>Créée le :</strong> {{ $task->created_at->format('d/m/Y à H:i') }}</p>

                    <div class="d-flex gap-2">
                        <a href="{{ route('tasks.show', [$project, $task]) }}" class="btn btn-sm btn-outline-primary">🔍 Voir</a>
                        <a href="{{ route('tasks.edit', [$project, $task]) }}" class="btn btn-sm btn-outline-warning">✏️ Modifier</a>
                        <form action="{{ route('tasks.destroy', [$project, $task]) }}" method="POST" onsubmit="return confirm('Supprimer cette tâche ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    @if (auth()->id() === $project->user_id)
        <div class="my-4 d-flex justify-content-between align-items-center">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#inviteModal">➕ Inviter un membre</button>
        </div>
    @endif
<br>
    <ul class="list-group mb-4">
        @foreach ($project->members as $member)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>
                    {{ $member->name }} ({{ $member->email }})
                    @if ($member->id === $project->user_id)
                        <span class="badge bg-secondary">Chef de projet</span>
                    @endif
                </span>

                @if (auth()->id() === $project->user_id && $member->id !== $project->user_id)
                    <form action="{{ route('projects.members.destroy', [$project->id, $member->id]) }}" method="POST" onsubmit="return confirm('Retirer ce membre ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Retirer</button>
                    </form>
                @endif
            </li>
        @endforeach
    </ul>

    <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">⬅️ Retour à mes projets</a>
</div>

<!-- Modal d'invitation -->
<div class="modal fade" id="inviteModal" tabindex="-1" aria-labelledby="inviteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('projects.members.store', $project) }}" class="modal-content">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="inviteModalLabel">👤 Inviter un membre</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="inviteEmail" class="form-label">Adresse email</label>
                <input type="email" name="email" id="inviteEmail" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">➕ Ajouter</button>
        </div>
    </form>
  </div>
</div>

@endsection
