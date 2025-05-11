@extends('layouts.app')

@section('title', 'Modifier la tâche')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">✏️ Modifier la tâche</h2>

    <form action="{{ route('tasks.update', [$projectId, $task]) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Catégorie</label>
            <select name="category" id="category" class="form-select">
                @foreach (['À faire', 'En cours', 'Fait', 'Annulé'] as $cat)
                    <option value="{{ $cat }}" @if($task->category === $cat) selected @endif>{{ $cat }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Priorité</label>
            <select name="priority" id="priority" class="form-select">
                @foreach (['Élevée', 'Moyenne', 'Basse'] as $prio)
                    <option value="{{ $prio }}" @if($task->priority === $prio) selected @endif>{{ $prio }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Date limite</label>
            <input type="date" name="due_date" id="due_date" value="{{ $task->due_date }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">💾 Enregistrer</button>
        <a href="{{ route('projects.show', $projectId) }}" class="btn btn-secondary ms-2">⬅️ Retour au projet</a>
    </form>
</div>
@endsection
