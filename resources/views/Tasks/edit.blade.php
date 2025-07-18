@extends('layouts.app')

@section('title', 'Modifier la tâche')

@section('content')
<div class="container py-5">
    <div class="mx-auto" style="max-width: 600px;">
        <div class="card shadow-sm rounded-4 p-4">

            <h2 class="mb-4">✏️ Modifier la tâche</h2>

            <!-- ✅ Affichage des erreurs -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tasks.update', ['project' => $project->id, 'task' => $task->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">📝 Titre</label>
                    <input type="text" name="title" id="title" class="form-control"
                           value="{{ old('title', $task->title) }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">🗒️ Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="form-control">{{ old('description', $task->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">📂 Catégorie</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">-- Sélectionner --</option>
                        <option value="à faire" {{ old('category', $task->category) === 'à faire' ? 'selected' : '' }}>À faire</option>
                        <option value="en cours" {{ old('category', $task->category) === 'en cours' ? 'selected' : '' }}>En cours</option>
                        <option value="fait" {{ old('category', $task->category) === 'fait' ? 'selected' : '' }}>Fait</option>
                        <option value="annulé" {{ old('category', $task->category) === 'annulé' ? 'selected' : '' }}>Annulé</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="priority" class="form-label">🔥 Priorité</label>
                    <select name="priority" id="priority" class="form-select">
                        <option value="">-- Sélectionner une priorité --</option>
                        <option value="Élevée" {{ $task->priority === 'Élevée' ? 'selected' : '' }}>Élevée</option>
                        <option value="Moyenne" {{ $task->priority === 'Moyenne' ? 'selected' : '' }}>Moyenne</option>
                        <option value="Basse" {{ $task->priority === 'Basse' ? 'selected' : '' }}>Basse</option>
                    </select>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="due_date" class="form-label">📅 Date limite</label>
                        <input type="date" name="due_date" id="due_date" class="form-control"
                               value="{{ old('due_date', optional($task->due_date)->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="due_time" class="form-label">⏰ Heure</label>
                        <input type="time" name="due_time" id="due_time" class="form-control"
                               value="{{ old('due_time', optional($task->due_date)->format('H:i')) }}">
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-secondary">
                        ⬅️ Annuler
                    </a>
                    <button type="submit" class="btn btn-success px-4">
                        💾 Enregistrer
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
