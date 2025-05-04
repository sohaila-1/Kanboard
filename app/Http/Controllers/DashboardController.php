<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $projects = Project::where('user_id', auth()->id())->get();
        $tasks = Task::where('user_id', auth()->id())->get();

        return view('dashboard', compact('projects', 'tasks'));
    }
}
