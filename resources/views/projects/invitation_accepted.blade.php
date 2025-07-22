@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h1 class="text-success">✅ Invitation acceptée !</h1>
    <p class="lead">Bienvenue dans le projet <strong>{{ $project->title }}</strong>.</p>
    <p>Vous avez été ajouté avec succès au projet.</p>
    <a href="{{ route('projects.show', $project->id) }}" class="btn btn-primary mt-3">Accéder au projet</a>
</div>
@endsection
