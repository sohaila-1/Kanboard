<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Créer un projet</title>
</head>
<body>
    <h1>Créer un projet</h1>

    @if(session('success'))
    <div style="color: green; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

    <form method="POST" action="{{ route('projects.store') }}">
        @csrf

        <div>
            <label for="title">Titre du projet:</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required>
        </div>

        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>
        </div>

        <div>
            <button type="submit">Créer</button>
        </div>
    </form>

    <a href="/projects">Retour à la liste</a>
</body>
</html>
