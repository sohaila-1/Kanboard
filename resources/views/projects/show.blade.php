@extends('layouts.app')

@section('title', 'Détails du projet')

@section('content')
    <h1>{{ $project->title }}</h1>
    <p>{{ $project->description }}</p>

    <h2>📌 Tâches</h2>

    <ul>
        @forelse ($project->tasks as $task)
            <li>
                {{ $task->title }}
                <a href="{{ route('tasks.edit', ['project' => $project->id, 'task' => $task->id]) }}">✏️</a>
                <form action="{{ route('tasks.destroy', ['project' => $project->id, 'task' => $task->id]) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Supprimer cette tâche ?')">🗑️</button>
                </form>
            </li>
        @empty
            <li>Aucune tâche pour ce projet.</li>
        @endforelse
    </ul>

    <a href="{{ route('tasks.create', $project->id) }}">➕ Ajouter une tâche</a><br>
    <a href="{{ route('projects.index') }}">⬅️ Retour aux projets</a>
@endsection
