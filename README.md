# 📌 Kanboard — Gestion de projets en ligne

> Une application web de gestion de projets avec vue Kanban, liste, calendrier et système d'utilisateurs.

---

## 🧰 Technologies utilisées

- PHP 8.2 / Laravel 10+
- MySQL
- Bootstrap 5
- FullCalendar.js
- Git / GitHub

---

## ⚙️ Fonctionnalités principales

- ✅ Authentification (inscription, connexion, déconnexion)
- ✅ Création, édition et suppression de projets
- ✅ Vue Kanban dynamique avec glisser-déposer
- ✅ Vue calendrier (FullCalendar) des tâches à échéance
- ✅ Gestion des tâches avec titre, description, priorité, date limite, catégorie
- ✅ Interface responsive et stylisée

---

## 🚀 Installation locale du projet

Voici les étapes pour cloner et faire fonctionner le projet Kanboard sur votre machine locale.

---

### 1️⃣ Cloner le projet

```bash
git clone https://github.com/votre-utilisateur/kanboard.git
cd kanboard
2️⃣ Installer les dépendances PHP avec Composer
Assurez-vous d’avoir Composer installé sur votre machine.

bash
Copy
Edit
composer install
3️⃣ Copier le fichier .env et générer la clé Laravel
bash
Copy
Edit
cp .env.example .env
php artisan key:generate
4️⃣ Configurer la base de données
Dans le fichier .env, modifiez les lignes suivantes selon votre configuration MySQL :

env
Copy
Edit
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kanboard
DB_USERNAME=root
DB_PASSWORD=secret
💡 Pensez à créer manuellement la base kanboard dans votre outil de gestion MySQL.

5️⃣ Lancer les migrations de la base
bash
Copy
Edit
php artisan migrate
6️⃣ Démarrer le serveur Laravel
bash
Copy
Edit
php artisan serve
Ensuite, ouvrez votre navigateur sur :

http://localhost:8000