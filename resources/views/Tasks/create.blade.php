@extends('layouts.app')

@section('title', 'Créer une tâche')

@section('content')
<div class="container">
    <h2>Nouvelle Tâche pour le projet : {{ $project->title }}</h2>

    <form method="POST" action="{{ route('tasks.store', ['project' => $project->id]) }}">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Catégorie</label>
            <select name="category" id="category" class="form-select">
                <option value="">-- Sélectionner --</option>
                <option value="à faire">À faire</option>
                <option value="en cours">En cours</option>
                <option value="fait">Fait</option>
                <option value="annulé">Annulé</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">📅 Date limite</label>
            <input type="date" name="due_date" id="due_date" class="form-control">
        </div>

        <div class="mb-3">
            <label for="due_time" class="form-label">🕒 Heure</label>
            <input type="time" name="due_time" id="due_time" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>
@endsection
