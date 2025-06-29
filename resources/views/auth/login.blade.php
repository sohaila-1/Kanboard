@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Connexion</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
        </div>


        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>
@endsection
