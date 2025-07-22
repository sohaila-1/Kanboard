<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mode hors-ligne</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8fafc;
            margin: 0;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
        }

        .offline-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #222;
        }

        p {
            max-width: 400px;
            margin-bottom: 2rem;
            color: #555;
            line-height: 1.6;
        }

        button {
            padding: 10px 20px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        button:hover {
            background-color: #1e40af;
        }

        .status {
            margin-top: 1.5rem;
            color: #666;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
<div class="offline-icon">📡</div>
<h1>Vous êtes hors ligne</h1>
<p>
    Il semble que vous ayez perdu la connexion Internet.<br>
    Certaines fonctionnalités sont temporairement désactivées, mais vos modifications locales seront synchronisées dès le retour du réseau.
</p>
<button onclick="retryConnection()">🔁 Réessayer</button>

<div id="connection-status" class="status">
    🔴 Aucune connexion détectée
</div>

<script>
    function retryConnection() {
        if (navigator.onLine) {
            window.location.href = '/';
        } else {
            updateStatus('Toujours hors ligne. Veuillez vérifier votre connexion.');
        }
    }

    function updateStatus(message) {
        const status = document.getElementById('connection-status');
        status.textContent = '🔴 ' + message;
    }

    window.addEventListener('online', () => {
        document.getElementById('connection-status').textContent = '🟢 Connexion restaurée. Redirection...';
        setTimeout(() => window.location.href = '/', 1500);
    });

    window.addEventListener('offline', () => {
        updateStatus('Connexion perdue');
    });

    if (navigator.onLine) {
        document.getElementById('connection-status').textContent = '🟢 Vous êtes en ligne';
    }
</script>
</body>
</html>
