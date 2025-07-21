@extends('layouts.app')

@section('title', 'Créer une tâche')

@section('content')
<div class="container py-5">
    <div class="mx-auto" style="max-width: 600px;">
        <div class="card shadow-sm rounded-4 p-4">

            <h2 class="mb-4"> + Tâche pour  : <strong>{{ $project->title }}</strong></h2>

            <form method="POST" action="{{ route('tasks.store', ['project' => $project->id]) }}">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">📝 Titre</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Ex. Ajouter une tache " required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">🗒️ Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Facultatif..."></textarea>
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">📂 Catégorie</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">-- Sélectionner une colonne --</option>
                        <option value="à faire">À faire</option>
                        <option value="en cours">En cours</option>
                        <option value="fait">Fait</option>
                        <option value="annulé">Annulé</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="priority" class="form-label">⚠️ Priorité</label>
                    <select name="priority" id="priority" class="form-select" required>
                        <option value="">-- Choisir une priorité --</option>
                        <option value="Élevée">Élevée</option>
                        <option value="Moyenne">Moyenne</option>
                        <option value="Basse">Basse</option>
                    </select>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="due_date" class="form-label">📅 Date limite</label>
                        <input type="date" name="due_date" id="due_date" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="due_time" class="form-label">⏰ Heure</label>
                        <input type="time" name="due_time" id="due_time" class="form-control">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4">
                        ✅ Créer
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection