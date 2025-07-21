@extends('layouts.app')

@section('title', 'Inviter un membre')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">👥 Inviter un membre au projet : {{ $project->title }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('projects.members.store', $project) }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">📧 Adresse email du membre</label>
            <input type="email" name="email" id="email"
                   class="form-control @error('email') is-invalid @enderror"
                   required value="{{ old('email') }}">

            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">✉️ Envoyer l’invitation</button>
    </form>

    <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-secondary mt-3">⬅️ Retour au projet</a>
</div>
@endsection
