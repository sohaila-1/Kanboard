@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Vérification de l'email</h2>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <p>Avant de continuer, veuillez vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer.</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Renvoyer le lien de vérification</button>
    </form>
</div>
@endsection
