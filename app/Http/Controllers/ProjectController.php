<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(Request $request)
{
    $search = $request->input('search');
    $userId = auth()->id();

    $projects = \App\Models\Project::where(function ($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->orWhereHas('members', function ($q) use ($userId) {
                      $q->where('user_id', $userId);
                  });
        })
        ->when($search, function ($query, $search) {
            $query->where('title', 'like', "%{$search}%");
        })
        ->get();

    return view('projects.index', compact('projects'));
}


    public function create()
    {
        return view('projects.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        \App\Models\Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(), // ✅ lier le projet à l'utilisateur connecté
        ]);
    
        return redirect()->route('projects.index')->with('success', 'Projet créé avec succès.');
    }
    
    
public function show(Project $project, Request $request)
{
    $user = auth()->user();

  
    if (
        $project->user_id !== $user->id &&
        !$project->members->contains($user->id)
    ) {
        abort(403);
    }
    $project->load('tasks', 'members', 'creator');

    // Recherche (si une barre de recherche existe)
    $search = $request->input('search');

    $tasks = $project->tasks()
        ->with('creator') 
        ->when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%");
        })
        ->get();


    return view('projects.show', [
        'project' => $project,
        'tasks' => $tasks,
    ]);
}


    public function edit(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }
    
        return view('projects.edit', compact('project'));
    }
    
    
    public function update(Request $request, Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        $project->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);
    
        return redirect()->route('projects.index')->with('success', 'Projet mis à jour avec succès.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Projet supprimé avec succès.');
    }

public function kanban(Project $project)
{
    if ($project->user_id !== auth()->id()) {
    abort(403);
}

    $tasks = $project->tasks;

    $columns = [
        'à faire' => [],
        'en cours' => [],
        'fait' => [],
        'annulé' => [],
    ];

    foreach ($tasks as $task) {
        $cat = strtolower(trim($task->category ?? 'à faire'));
        $columns[$cat][] = $task;
    }

    return view('projects.kanban', compact('project', 'columns'));
}



public function calendar(Project $project)
{
    if ($project->user_id !== auth()->id()) {
    abort(403);
}

    $events = [];

    foreach ($project->tasks as $task) {
        if ($task->due_date) {
            $events[] = [
                'title' => $task->title,
                'start' => Carbon::parse($task->due_date)->format('Y-m-d\TH:i:s'),
                'color' => match($task->category) {
                    'fait' => '#28a745',
                    'en cours' => '#ffc107',
                    'annulé' => '#dc3545',
                    default => '#007bff',
                }
            ];
        }
    }

    return view('projects.calendar', [
        'project' => $project,
        'events' => $events,
    ]);
}



     

}