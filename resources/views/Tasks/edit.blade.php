<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier la tâche</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            padding: 2rem;
        }
        form {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-width: 500px;
        }
        label {
            display: block;
            margin-top: 1rem;
        }
        input[type="text"] {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.5rem;
            box-sizing: border-box;
        }
        button {
            margin-top: 1.5rem;
            padding: 0.5rem 1rem;
        }
        a {
            display: inline-block;
            margin-top: 1rem;
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>
    <h1>✏️ Modifier la tâche</h1>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('tasks.update', ['project' => $projectId, 'task' => $task->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="title">Titre de la tâche :</label>
        <input type="text" name="title" id="title" value="{{ $task->title }}" required>

        <button type="submit">💾 Sauvegarder</button>
    </form>

    <a href="{{ route('projects.show', $projectId) }}">⬅️ Retour au projet</a>
</body>
</html>
