@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="dashboard-container">
    <!-- 🔹 Résumé -->
    <section class="summary-card glassmorphism">
        <div class="summary-content">
            <h2>Votre activité</h2>
            <div class="stats-container">
                <div class="stat-item">
                    <span class="stat-value">{{ $projects_count }}</span>
                    <span class="stat-label">Projets</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $tasks_count }}</span>
                    <span class="stat-label">Tâches</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 🔹 Mes projets -->
    <section class="section-container">
        <div class="section-header">
            <h2><i class="icon-folder"></i> Mes projets</h2>
            <a href="{{ route('projects.create') }}" class="btn btn-primary">
                <i class="icon-plus"></i> Nouveau projet
            </a>
        </div>

        @forelse($projects as $project)
            <div class="project-card">
                <div class="project-info">
                    <h3>{{ $project->title }}</h3>
                    <div class="meta-info">
                        <span class="task-count">{{ $project->tasks_count }} tâche(s)</span>
                        <span class="progress-badge">{{ $project->completion }}% complété</span>
                    </div>
                </div>
                <div class="project-actions">
                    <a href="{{ route('projects.show', $project) }}" class="btn-icon">
                        <i class="icon-eye"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="icon-folder-open"></i>
                <p>Aucun projet créé</p>
                <a href="{{ route('projects.create') }}" class="btn btn-primary">Créer un projet</a>
            </div>
        @endforelse
    </section>

    <!-- 🔹 Tâches urgentes -->
    <section class="section-container">
        <div class="section-header">
            <h2><i class="icon-alert"></i> Tâches prioritaires</h2>
        </div>

        @forelse($tasks as $task)
            <div class="task-card priority-{{ strtolower($task->priority) }}">
                <div class="task-info">
                    <h4>{{ $task->title }}</h4>
                    <div class="task-meta">
                        <span class="due-date">
                            <i class="icon-calendar"></i>
                            {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : 'Sans date' }}
                        </span>
                        <span class="priority-badge">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </div>
                </div>
                <div class="task-status">
                    <div class="progress-circle" data-percent="{{ $task->progress }}"></div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="icon-check-circle"></i>
                <p>Aucune tâche urgente</p>
            </div>
        @endforelse
    </section>
</div>
@endsection

<style>
:root {
    --primary: #4361ee;
    --secondary: #3f37c9;
    --light: #f8f9fa;
    --dark: #212529;
    --success: #4cc9f0;
    --warning: #f8961e;
    --danger: #f94144;
    --gray: #6c757d;
}

.dashboard-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
    display: grid;
    grid-gap: 2rem;
}

/* Summary Card */
.summary-card {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 10px 20px rgba(73, 103, 236, 0.15);
}

.summary-content h2 {
    margin: 0 0 1rem;
    font-weight: 600;
}

.stats-container {
    display: flex;
    gap: 2rem;
}

.stat-item {
    text-align: center;
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 700;
    display: block;
    line-height: 1;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

/* Section Styles */
.section-container {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.section-header h2 {
    margin: 0;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Cards */
.project-card, .task-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    transition: transform 0.2s, box-shadow 0.2s;
}

.project-card {
    background: var(--light);
    border-left: 4px solid var(--primary);
}

.project-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.08);
}

.task-card {
    background: white;
    border: 1px solid #eee;
}

/* Priority Colors */
.task-card.priority-élevée, .task-card.priority-elevee {
    border-left: 4px solid var(--danger);
}

.task-card.priority-moyenne {
    border-left: 4px solid var(--warning);
}

.task-card.priority-basse {
    border-left: 4px solid var(--success);
}

/* Typography */
h3, h4 {
    margin: 0 0 0.5rem;
    font-weight: 600;
}

h3 {
    font-size: 1.1rem;
}

h4 {
    font-size: 1rem;
}

/* Meta Info */
.meta-info, .task-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.85rem;
    color: var(--gray);
}

.task-count, .due-date {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.progress-badge {
    background: rgba(67, 97, 238, 0.1);
    color: var(--primary);
    padding: 0.25rem 0.5rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 500;
}

.priority-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 500;
}

.task-card.priority-élevée .priority-badge,
.task-card.priority-elevee .priority-badge {
    background: rgba(249, 65, 68, 0.1);
    color: var(--danger);
}

.task-card.priority-moyenne .priority-badge {
    background: rgba(248, 150, 30, 0.1);
    color: var(--warning);
}

.task-card.priority-basse .priority-badge {
    background: rgba(76, 201, 240, 0.1);
    color: var(--success);
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.25rem;
    border-radius: 8px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-primary:hover {
    background: var(--secondary);
    transform: translateY(-1px);
}

.btn-icon {
    background: none;
    border: none;
    color: var(--gray);
    padding: 0.5rem;
    border-radius: 50%;
    transition: all 0.2s;
}

.btn-icon:hover {
    background: rgba(0,0,0,0.05);
    color: var(--dark);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 2rem;
    color: var(--gray);
}

.empty-state i {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state p {
    margin: 0.5rem 0 1.5rem;
}

/* Icons (using Unicode or icon font) */
.icon-folder:before { content: "📁"; }
.icon-plus:before { content: "+"; }
.icon-eye:before { content: "👁️"; }
.icon-alert:before { content: "⚠️"; }
.icon-calendar:before { content: "📅"; }
.icon-folder-open:before { content: "📂"; }
.icon-check-circle:before { content: "✅"; }

/* Progress Circle */
.progress-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: conic-gradient(var(--primary) 0% var(--progress), #eee var(--progress) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 0.6rem;
    font-weight: bold;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-container {
        grid-template-columns: 1fr;
        padding: 1rem;
    }
    
    .stats-container {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>
