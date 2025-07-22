@extends('layouts.app')
@section('title', $task->title)
@section('content')


<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <h3 class="mb-3">{{ $task->title }}</h3>
        <p class="text-muted"><strong>Projet :</strong> {{ $project->title }}</p>
        <p><strong>Description :</strong><br>{{ $task->description ?? '—' }}</p>


        @php
            $badgeClass = match($task->priority) {
                'Élevée' => 'danger',
                'Moyenne' => 'warning',
                'Basse' => 'success',
                default => 'secondary',
            };
        @endphp

    <p><strong>Assigné à :</strong>
        @forelse ($task->assignedUsers as $user)
            <span class="badge bg-info text-dark me-1">{{ $user->name }}</span>
            @empty
            <span class="text-muted">Aucun utilisateur assigné.</span>
        @endforelse
    </p>

    <p>
        <strong>Priorité :</strong>
        <span class="badge bg-{{ $badgeClass }}">{{ $task->priority ?? 'Non définie' }}</span>
    </p>


        @if ($task->due_date)
            <p><strong>Échéance :</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</p>
        @endif

        <!-- ✅ Boutons en bas -->
        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-secondary">⬅️ Retour au projet</a>
            <a href="{{ route('tasks.edit', [$project, $task]) }}" class="btn btn-sm btn-warning">✏️ Modifier</a>
        </div>
    </div>
</div>
<div class="container my-4">
    <div class="card shadow-sm p-3 rounded-4">
        <h4 class="mb-3">📦 Tâches en attente de synchronisation</h4>
        <ul id="offline-task-list" class="list-group mb-3"></ul>

        <button class="btn btn-primary" id="sync-now-btn">
            🔄 Forcer la synchronisation maintenant
        </button>

        <div id="sync-feedback" class="mt-3 text-muted" style="font-size: 0.9rem;"></div>
    </div>
</div>
@endsection
