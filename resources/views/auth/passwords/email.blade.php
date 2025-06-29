@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mot de passe oublié</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label for="email">Adresse email</label>
            <input id="email" type="email" class="form-control" name="email" required autofocus>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Envoyer le lien de réinitialisation</button>
    </form>
</div>
@endsection
