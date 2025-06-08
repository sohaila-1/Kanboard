@extends('layouts.app')

@section('title', 'Modifier la tâche')

@section('content')
<div class="container">
    <h2>Modifier la Tâche</h2>
    <form action="{{ route('tasks.update', [$projectId, $task]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $task->title ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $task->description ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Catégorie</label>
            <select name="category" id="category" class="form-select">
                <option value="">-- Sélectionner --</option>
                <option value="à faire" {{ (old('category', $task->category ?? '') === 'à faire') ? 'selected' : '' }}>À faire</option>
                <option value="en cours" {{ (old('category', $task->category ?? '') === 'en cours') ? 'selected' : '' }}>En cours</option>
                <option value="fait" {{ (old('category', $task->category ?? '') === 'fait') ? 'selected' : '' }}>Fait</option>
                <option value="annulé" {{ (old('category', $task->category ?? '') === 'annulé') ? 'selected' : '' }}>Annulé</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">📅 Date limite</label>
            <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date', optional($task->due_date ?? null)->format('Y-m-d')) }}">
        </div>

        <div class="mb-3">
            <label for="due_time" class="form-label">🕒 Heure</label>
            <input type="time" name="due_time" id="due_time" class="form-control" value="{{ old('due_time', optional($task->due_date ?? null)->format('H:i')) }}">
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
