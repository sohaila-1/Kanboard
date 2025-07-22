@extends('layouts.app')

@section('title', 'Créer une tâche')

@section('content')
    <div class="container py-5">
        <div class="mx-auto" style="max-width: 600px;">
            <div class="card shadow-sm rounded-4 p-4">
                <h2 class="mb-4">+ Tâche pour : <strong>{{ $project->title }}</strong></h2>

                <form id="task-form" method="POST" action="{{ route('tasks.store', ['project' => $project->id]) }}">
                    @csrf

                    <input type="hidden" id="project-id" value="{{ $project->id }}">

                    <div class="mb-3">
                        <label for="title" class="form-label">📝 Titre</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Ex. Ajouter une tâche" required>
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

                    <div id="sync-status" class="text-muted mb-3" style="font-size: 0.9rem;"></div>

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

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('task-form');
            const statusBox = document.getElementById('sync-status');
            const OFFLINE_KEY = 'offline_tasks';

            form.addEventListener('submit', function (e) {
                if (!navigator.onLine) {
                    e.preventDefault(); // Empêche l'envoi classique

                    const task = {
                        project_id: document.getElementById('project-id').value,
                        title: document.getElementById('title').value,
                        description: document.getElementById('description').value,
                        category: document.getElementById('category').value,
                        priority: document.getElementById('priority').value,
                        due_date: document.getElementById('due_date').value,
                        due_time: document.getElementById('due_time').value,
                        created_at: new Date().toISOString(),
                        synced: false
                    };

                    let tasks = JSON.parse(localStorage.getItem(OFFLINE_KEY)) || [];
                    tasks.push(task);
                    localStorage.setItem(OFFLINE_KEY, JSON.stringify(tasks));

                    form.reset();
                    statusBox.textContent = '📡 Tâche enregistrée localement. Elle sera synchronisée dès que la connexion revient.';
                }
            });

            async function syncTasks() {
                let tasks = JSON.parse(localStorage.getItem(OFFLINE_KEY)) || [];
                if (tasks.length === 0) return;

                for (let task of tasks) {
                    if (!task.synced) {
                        try {
                            const response = await fetch(`/api/projects/${task.project_id}/tasks`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify(task)
                            });

                            if (response.ok) {
                                task.synced = true;
                                statusBox.textContent = '✅ Tâche synchronisée avec succès.';
                            } else {
                                statusBox.textContent = '⚠️ Erreur de synchronisation.';
                            }
                        } catch (err) {
                            console.error(err);
                            statusBox.textContent = '🔴 Échec de connexion à l’API.';
                        }
                    }
                }

                tasks = tasks.filter(t => !t.synced);
                localStorage.setItem(OFFLINE_KEY, JSON.stringify(tasks));
            }

            window.addEventListener('online', () => {
                statusBox.textContent = '🟢 Connexion restaurée. Synchronisation en cours...';
                syncTasks();
            });

            if (navigator.onLine) {
                syncTasks();
            }
        });
    </script>
@endsection
