@extends('layouts.app')

@section('title', 'Nouvelle tâche')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">➕ Nouvelle tâche pour le projet <span class="text-primary">{{ $project->title }}</span></h2>

    <form action="{{ route('tasks.store', $project) }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Catégorie</label>
            <select name="category" id="category" class="form-select">
                <option value="À faire">À faire</option>
                <option value="En cours">En cours</option>
                <option value="Fait">Fait</option>
                <option value="Annulé">Annulé</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label">Priorité</label>
            <select name="priority" id="priority" class="form-select">
                <option value="Élevée">Élevée</option>
                <option value="Moyenne">Moyenne</option>
                <option value="Basse">Basse</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Date limite</label>
            <input type="date" name="due_date" id="due_date" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Créer la tâche</button>
        <a href="{{ route('projects.show', $project) }}" class="btn btn-secondary ms-2">⬅️ Retour au projet</a>
    </form>
</div>
@endsection
