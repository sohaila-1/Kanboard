@extends('layouts.app')
@section('title', $task->title)
@section('content')


<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <h3 class="mb-3">{{ $task->title }}</h3>
        <p class="text-muted"><strong>Projet :</strong> {{ $project->title }}</p>
        <p><strong>Description :</strong><br>{{ $task->description ?? '—' }}</p>


        <p>
            <strong>Priorité :</strong>
            <span class="badge bg-{{ match($task->priority) {
                'Élevée' => 'danger',
                'Moyenne' => 'warning',
                'Basse' => 'success',
                default => 'secondary'
            }}}">{{ $task->priority ?? 'Non définie' }}</span>
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
@endsection
