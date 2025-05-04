<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une tâche</title>
</head>
<body>
    <h1>Nouvelle tâche pour le projet #{{ $projectId }}</h1>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('tasks.store', ['project' => $projectId]) }}" method="POST">
        @csrf
        <label for="title">Titre de la tâche :</label>
        <input type="text" name="title" id="title" required>

        <br><br>

        <button type="submit">Créer</button>
    </form>

    <br>
    <a href="{{ route('projects.show', ['project' => $projectId]) }}">⬅️ Retour au projet</a>
</body>
</html>
