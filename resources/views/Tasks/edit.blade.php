@extends('layouts.app')

@section('title', 'Modifier la tâche')

@section('content')
<div class="main-content">
    <h2 class="mb-4">Modifier la tâche : <strong>{{ $task->title }}</strong></h2>

    <form method="POST" action="{{ route('tasks.update', [$projectId, $task->id]) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $task->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Colonne (Kanban)</label>
            <select name="category" id="category" class="form-select">
                <option value="à faire" {{ $task->category === 'à faire' ? 'selected' : '' }}>À faire</option>
                <option value="en cours" {{ $task->category === 'en cours' ? 'selected' : '' }}>En cours</option>
                <option value="fait" {{ $task->category === 'fait' ? 'selected' : '' }}>Fait</option>
                <option value="annulé" {{ $task->category === 'annulé' ? 'selected' : '' }}>Annulé</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
