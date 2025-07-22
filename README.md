# 📌 Kanboard – Application de Gestion de Projets

Kanboard est une application Web collaborative inspirée de la méthode Kanban, conçue pour aider les équipes à planifier, suivre et gérer efficacement leurs projets via des tableaux interactifs, des vues personnalisables, et des fonctionnalités avancées.

## 🚀 Fonctionnalités principales

### 🧑‍💼 Authentification & Sécurité
- Inscription avec email de confirmation (via Resend)
- Connexion sécurisée avec mot de passe
- Réinitialisation de mot de passe avec lien temporaire (expiration après 5 minutes)

### 📁 Gestion de Projets
- Création de projets par les utilisateurs
- Invitation de membres par email
- Attribution des rôles (créateur, membres)

### ✅ Gestion des Tâches
- Création de tâches avec :
  - Titre (obligatoire)
  - Description, catégorie, priorité (optionnels)
  - Dates : création, échéance, complétion
- Attribution des tâches à un ou plusieurs membres

### 🖼️ Vues dynamiques
- Vue **Kanban** avec glisser-déposer
- Vue **Liste** pour recherche/filtrage
- Vue **Calendrier** avec affichage journalier, 3 jours, semaine, mois

### 🌐 Interface moderne & responsive
- Adaptée aux mobiles
- Prise en compte du thème système (clair / sombre)

### 🛠️ Technologies utilisées
- **Frontend** : HTML, CSS, JavaScript
- **Backend** : PHP (Laravel)
- **Base de données** : MySQL
- **Temps réel** : Laravel Echo + Pusher
- **Conteneurisation** : Docker & Docker Compose

### 📉 Statistiques (Bonus)
- Moyenne des tâches par membre
- Temps moyen de complétion
- Répartition par catégories

### 🔁 Synchronisation & Offline (Bonus)
- Fonctionnalité **hors-ligne** : tâches temporaires stockées localement
- Synchronisation automatique dès reconnection
- Export des tâches au format **iCal** compatible Google/Microsoft Calendar

---

## ⚙️ Installation locale

### 1. Cloner le projet
```bash
git clone https://github.com/<votre-utilisateur>/kanboard.git
cd kanboard
