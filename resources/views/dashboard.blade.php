@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
    <h1>👋 Bienvenue {{ Auth::user()->name }}</h1>

    <p>Voici un aperçu de votre activité :</p>

    <ul>
        <li>📁 <strong>{{ $projects->count() }}</strong> projet(s) créé(s)</li>
        <li>✅ <strong>{{ $tasks->count() }}</strong> tâche(s) au total</li>
    </ul>

    <a href="{{ route('projects.index') }}">📂 Voir mes projets</a>
@endsection
