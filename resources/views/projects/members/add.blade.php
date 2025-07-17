@extends('layouts.app')

@section('title', 'Partager le projet')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm p-4">
        <h3>👥 Partager le projet : {{ $project->title }}</h3>

        <!-- ✅ Formulaire d’ajout de membre -->
        <form action="{{ route('projects.members.store', $project) }}" method="POST" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email de l'utilisateur à inviter</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">➕ Ajouter</button>
        </form>

        <!-- ✅ Liste des membres -->
        <hr>
        <h5 class="mt-4">Membres actuels :</h5>
        <ul class="list-group">
            @foreach ($project->members as $member)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $member->name }} ({{ $member->email }})
                    <form action="{{ route('projects.members.destroy', [$project, $member]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">❌ Retirer</button>
                    </form>
                </li>
            @endforeach
        </ul>

        <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-secondary mt-4">⬅️ Retour au projet</a>
    </div>
</div>
@endsection
