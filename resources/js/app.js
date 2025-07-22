import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// ✅ Enregistrement du Service Worker pour PWA
if ('serviceWorker' in navigator && !import.meta.env.DEV) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/build/sw.js')
            .then((registration) => {
                console.log('✅ Service Worker enregistré :', registration);
            })
            .catch((error) => {
                console.error('❌ Échec de l’enregistrement du Service Worker :', error);
            });
    });
}

// ✅ Gestion des tâches hors-ligne
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('task-form');
    const syncStatus = document.getElementById('sync-status');
    const OFFLINE_KEY = 'offline_tasks';

    if (form) {
        form.addEventListener('submit', function (e) {
            if (!navigator.onLine) {
                e.preventDefault(); // ❌ Pas d'envoi serveur

                const task = {
                    project_id: document.getElementById('project-id')?.value || null,
                    title: document.getElementById('title')?.value,
                    description: document.getElementById('description')?.value,
                    category: document.getElementById('category')?.value,
                    priority: document.getElementById('priority')?.value,
                    due_date: document.getElementById('due_date')?.value,
                    due_time: document.getElementById('due_time')?.value,
                    created_at: new Date().toISOString(),
                    synced: false
                };

                let tasks = JSON.parse(localStorage.getItem(OFFLINE_KEY)) || [];
                tasks.push(task);
                localStorage.setItem(OFFLINE_KEY, JSON.stringify(tasks));

                form.reset();
                if (syncStatus) {
                    syncStatus.textContent = '📡 Tâche enregistrée localement. Elle sera synchronisée à la reconnexion.';
                }
            }
        });
    }

    // ✅ Fonction de synchronisation automatique
    async function syncTasks() {
        let tasks = JSON.parse(localStorage.getItem(OFFLINE_KEY)) || [];
        if (tasks.length === 0) return;

        let syncedCount = 0;

        for (let task of tasks) {
            if (!task.synced && task.project_id) {
                try {
                    const response = await fetch(`/api/projects/${task.project_id}/tasks`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(task)
                    });

                    if (response.ok) {
                        task.synced = true;
                        syncedCount++;
                    }
                } catch (err) {
                    console.error('❌ Erreur de sync tâche :', err);
                }
            }
        }

        // Nettoyage
        tasks = tasks.filter(t => !t.synced);
        localStorage.setItem(OFFLINE_KEY, JSON.stringify(tasks));

        if (syncedCount > 0 && syncStatus) {
            syncStatus.textContent = `✅ ${syncedCount} tâche(s) synchronisée(s).`;
        }
    }

    // 🔁 Sync automatique dès qu'on revient en ligne
    window.addEventListener('online', () => {
        console.log('🟢 Connexion détectée, synchronisation des tâches...');
        syncTasks();
    });

    // 🔁 Sync immédiate si déjà connecté
    if (navigator.onLine) {
        syncTasks();
    }
});


