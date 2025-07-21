@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="dashboard-container">

    <!-- 🔹 Résumé -->
    <section class="box highlight">
        <h2>📊 Résumé</h2>
        <p class="summary-text">
            Vous avez <span class="badge">{{ $projects_count }}</span> projet(s) et
            <span class="badge">{{ $tasks_count }}</span> tâche(s) au total.
        </p>
    </section>

    <!-- 🔹 Mes projets -->
    <section class="box">
        <div class="section-header">
            <h2>📁 Mes projets</h2>
            <a href="{{ route('projects.create') }}" class="btn btn-primary">+ Nouveau projet</a>
        </div>

        @forelse($projects as $project)
            <div class="card">
                <div class="card-body">
                    <h3 class="project-title">{{ $project->title }}</h3>
                    <p class="text-muted">{{ $project->tasks_count }} tâche(s)</p>
                </div>
                <div class="card-actions">
                    <a href="{{ route('projects.show', $project) }}" class="btn btn-secondary">Voir</a>
                </div>
            </div>
        @empty
            <p class="no-content">Aucun projet. Cliquez sur <strong>+ Nouveau projet</strong> pour commencer.</p>
        @endforelse
    </section>

    <!-- 🔹 Tâches urgentes -->
    <section class="box">
        <h2>📌 Tâches urgentes / à venir</h2>

        @forelse($tasks as $task)
            <div class="card task-card">
                <div class="card-body">
                    <h4 class="task-title">{{ $task->title }}</h4>
                    <p>
                        📅 {{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Pas de deadline' }}<br>
                        🔺 Priorité :
                        <span class="badge badge-{{ strtolower($task->priority) }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </p>
                </div>
            </div>
        @empty
            <p class="no-content">Aucune tâche urgente.</p>
        @endforelse
    </section>

</div>
@endsection
<style>
    .dashboard-container {
    max-width: 900px;
    margin: auto;
    padding: 2rem;
}

.box {
    background: #fff;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 1px 6px rgba(0,0,0,0.1);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.btn {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
}

.btn-secondary {
    background-color: #f3f3f3;
    color: #333;
    border: 1px solid #ccc;
}

.card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #eee;
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 8px;
}

.task-title,
.project-title {
    margin: 0;
    font-size: 1.2rem;
    font-weight: bold;
}

.badge {
    background-color: #e0e0e0;
    padding: 0.2rem 0.6rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
}

.badge-basse {
    background-color: #8bc34a;
    color: white;
}

.badge-moyenne {
    background-color: #ffc107;
    color: black;
}

.badge-élevée,
.badge-elevee {
    background-color: #f44336;
    color: white;
}

.no-content {
    color: #777;
    font-style: italic;
}

.summary-text {
    font-size: 1.1rem;
}
</style>