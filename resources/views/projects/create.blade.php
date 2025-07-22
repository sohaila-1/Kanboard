@extends('layouts.app')

@section('title', 'Créer un projet')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white text-center">
                        <h5>📁 Créer un nouveau projet</h5>
                    </div>

                    <div class="card-body">
                        <form id="project-form" action="{{ route('projects.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Titre du projet</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description (facultative)</label>
                                <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                            </div>

                            <div id="sync-status" class="text-muted mb-3" style="font-size: 0.9rem;"></div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('projects.index') }}" class="btn btn-secondary">⬅️ Retour à la liste</a>
                                <button type="submit" class="btn btn-dark">Créer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('project-form');
            const syncStatus = document.getElementById('sync-status');
            const STORAGE_KEY = 'offline_projects';

            form.addEventListener('submit', function (e) {
                if (!navigator.onLine) {
                    e.preventDefault();

                    const project = {
                        title: document.getElementById('title')?.value,
                        description: document.getElementById('description')?.value,
                        created_at: new Date().toISOString(),
                        synced: false
                    };

                    let projects = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
                    projects.push(project);
                    localStorage.setItem(STORAGE_KEY, JSON.stringify(projects));

                    form.reset();
                    if (syncStatus) {
                        syncStatus.textContent = '📡 Projet enregistré localement. Il sera synchronisé dès que la connexion revient.';
                    }
                }
            });

            async function syncProjects() {
                let projects = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
                if (projects.length === 0) return;

                let syncedCount = 0;

                for (let project of projects) {
                    if (!project.synced) {
                        try {
                            const response = await fetch(`/api/projects`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify(project)
                            });

                            if (response.ok) {
                                project.synced = true;
                                syncedCount++;
                            }
                        } catch (err) {
                            console.error('❌ Sync error:', err);
                        }
                    }
                }

                projects = projects.filter(p => !p.synced);
                localStorage.setItem(STORAGE_KEY, JSON.stringify(projects));

                if (syncedCount > 0 && syncStatus) {
                    syncStatus.textContent = `✅ ${syncedCount} projet(s) synchronisé(s) avec succès.`;
                }
            }

            window.addEventListener('online', () => {
                syncStatus.textContent = '🟢 Connexion restaurée. Synchronisation en cours...';
                syncProjects();
            });

            if (navigator.onLine) {
                syncProjects();
            }
        });
    </script>
@endsection
