@extends('layouts.app')

@section('title', 'Créer une tâche')

@section('content')
<div class="main-content">
    <h2 class="mb-4">Ajouter une tâche au projet : <strong>{{ $project->title }}</strong></h2>

    <form method="POST" action="{{ route('tasks.store', $project->id) }}">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Colonne (Kanban)</label>
            <select name="category" id="category" class="form-select" required>
                <option value="" disabled selected>-- Choisir une colonne --</option>
                <option value="à faire">À faire</option>
                <option value="en cours">En cours</option>
                <option value="fait">Fait</option>
                <option value="annulé">Annulé</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Créer la tâche</button>
    </form>
</div>
@endsection
