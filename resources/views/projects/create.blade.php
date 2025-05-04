@extends('layouts.app')

@section('title', 'Créer un projet')

@section('content')
    <h1>Créer un projet</h1>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        <label for="title">Titre du projet:</label>
        <input type="text" name="title" id="title" required>

        <br><br>

        <label for="description">Description:</label>
        <textarea name="description" id="description"></textarea>

        <br><br>

        <button type="submit">Créer</button>
    </form>

    <br>
    <a href="{{ route('projects.index') }}">⬅️ Retour à la liste</a>
@endsection
