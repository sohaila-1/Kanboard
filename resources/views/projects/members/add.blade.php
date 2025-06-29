@extends('layouts.app')

@section('title', 'Ajouter un membre')

@section('content')
    <h2 class="mb-4">Ajouter un membre au projet : <strong>{{ $project->title }}</strong></h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('projects.members.store', $project) }}" method="POST" class="w-50">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Adresse email de l'utilisateur</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="exemple@mail.com" required>
        </div>
        <button type="submit" class="btn btn-success">➕ Ajouter</button>
        <a href="{{ route('projects.show', $project) }}" class="btn btn-secondary">Retour</a>
    </form>
@endsection
