<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Invitation à rejoindre le projet</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f6f6; padding: 2rem;">
    <div style="max-width: 600px; margin: auto; background-color: white; padding: 2rem; border-radius: 8px;">
        <h2 style="text-align: center; color: #333;">👋 Invitation à rejoindre un projet Kanboard</h2>

        <p>Bonjour,</p>

        <p>
            Vous avez été invité à rejoindre le projet <strong>{{ $project->title }}</strong> sur Kanboard.
        </p>

        <p style="text-align: center; margin: 2rem 0;">
            <a href="{{ $url }}" style="background-color: #0d6efd; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px;">
                Rejoindre le projet
            </a>
        </p>

        <p>
            Si vous ne possédez pas encore de compte, vous serez invité(e) à en créer un.  
            Ce lien expirera dans 48h.
        </p>

        <p style="font-size: 0.9rem; color: #666;">Merci,<br>L’équipe Kanboard</p>
    </div>
</body>
</html>
