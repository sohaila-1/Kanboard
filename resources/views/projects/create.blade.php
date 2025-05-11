@extends('layouts.app')

@section('title', 'Créer un projet')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">📁 Créer un nouveau projet</h2>

    <form action="{{ route('projects.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Titre du projet</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description (facultative)</label>
            <textarea name="description" id="description" rows="4" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Créer</button>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary ms-2">⬅️ Retour à la liste</a>
    </form>
</div>
@endsection
