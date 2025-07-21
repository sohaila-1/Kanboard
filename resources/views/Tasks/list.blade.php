@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tâches du projet : {{ $project->title }} (Vue Liste)</h2>

    <form method="GET" action="{{ route('projects.tasks.list', $project) }}" class="mb-3">
        <div class="row">
            <div class="col">
                <input type="text" name="title" class="form-control" placeholder="Titre" value="{{ request('title') }}">
            </div>
            <div class="col">
                <input type="text" name="description" class="form-control" placeholder="Description" value="{{ request('description') }}">
            </div>
            <div class="col">
                <select name="category" class="form-control">
                    <option value="">Catégorie</option>
                    <option value="À faire">À faire</option>
                    <option value="En cours">En cours</option>
                    <option value="Fait">Fait</option>
                    <option value="Annulé">Annulé</option>
                </select>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Description</th>
                <th>Catégorie</th>
                <th>Priorité</th>
                <th>Date limite</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->category }}</td>
                    <td>{{ $task->priority }}</td>
                    <td>{{ $task->due_date }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Aucune tâche trouvée.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection