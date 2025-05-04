@extends('layouts.app')

@section('title', 'Modifier le projet')

@section('content')
    <h1>✏️ Modifier le projet</h1>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="title">Titre :</label>
        <input type="text" name="title" id="title" value="{{ $project->title }}" required>

        <label for="description">Description :</label>
        <textarea name="description" id="description" rows="4">{{ $project->description }}</textarea>

        <button type="submit">💾 Enregistrer</button>
    </form>

    <a href="{{ route('projects.index') }}">⬅️ Retour à la liste</a>
@endsection
