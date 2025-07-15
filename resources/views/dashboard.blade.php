@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="dashboard-container">

    <!-- 🔹 Résumé -->
    <section class="box">
        <h2>📊 Résumé</h2>
        <p>Vous avez <strong>{{ $projects_count }}</strong> projet(s) et <strong>{{ $tasks_count }}</strong> tâche(s) au total.</p>
    </section>

    <!-- 🔹 Mes projets -->
    <section class="box">
        <h2>📁 Mes projets</h2>
        <a href="{{ route('projects.create') }}" class="btn-new">+ Nouveau projet</a>

        @forelse($projects as $project)
            <div class="item">
                <div>
                    <strong>{{ $project->title }}</strong><br>
                    <span>{{ $project->tasks_count }} tâches</span>
                </div>
                <a href="{{ route('projects.show', $project) }}" class="btn">Voir</a>
            </div>
        @empty
            <p>Vous n'avez pas encore de projet. Cliquez sur <strong>+ Nouveau projet</strong> pour commencer !</p>
        @endforelse
    </section>

    <!-- 🔹 Tâches urgentes -->
    <section class="box">
        <h2>📌 Tâches urgentes / à venir</h2>

        @forelse($tasks as $task)
            <div class="item">
                <div>
                    <strong>{{ $task->title }}</strong><br>
                    📅 {{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Pas de deadline' }}<br>
                    🔺 Priorité : <span class="priority {{ strtolower($task->priority) }}">{{ ucfirst($task->priority) }}</span>
                </div>
            </div>
        @empty
            <p>Aucune tâche urgente</p>
        @endforelse
    </section>

</div>
@endsection
