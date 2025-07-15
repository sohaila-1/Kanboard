<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $userId = auth()->id();

        // Projets de l'utilisateur avec le nombre de tâches
        $projects = Project::withCount('tasks')
                    ->where('user_id', $userId)
                    ->get();

        // Tâches avec date limite proche
        $tasks = Task::where('user_id', $userId)
                    ->whereNotNull('due_date')
                    ->orderBy('due_date')
                    ->take(5)
                    ->get();

        // Totaux si besoin plus tard
        $projects_count = $projects->count();
        $tasks_count = Task::where('user_id', $userId)->count();

        return view('dashboard', compact('projects', 'tasks', 'projects_count', 'tasks_count'));
    }
}
