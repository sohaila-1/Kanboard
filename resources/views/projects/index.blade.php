@extends('layouts.app')

@section('title', 'Liste des projets')

@section('content')
    <h1>📋 Mes Projets</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($projects->isEmpty())
        <p>Aucun projet pour le moment.</p>
    @else
        <ul>
            @foreach ($projects as $project)
                <li>
                    <strong>{{ $project->title }}</strong> — {{ $project->description }}<br>
                    <a href="{{ route('projects.show', $project->id) }}">➡️ Voir</a> |
                    <a href="{{ route('projects.edit', $project->id) }}">✏️ Modifier</a>
                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Supprimer ce projet ?')">🗑️ Supprimer</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
