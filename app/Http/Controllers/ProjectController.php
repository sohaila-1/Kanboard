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

    $projects = \App\Models\Project::where('user_id', auth()->id())
        ->when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%");
        })
        ->get();

    return view('projects.index', compact('projects'));
}

    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }
    

    /**
     * Store a newly created resource in storage.
     */
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
    
    

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Request $request)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403); // 🔒 Bloque l'accès si ce n'est pas le propriétaire
        }

        $search = $request->input('search');

        $tasks = $project->tasks()
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%");
            })
            ->get();

        return view('projects.show', [
            'project' => $project,
            'tasks' => $tasks
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
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
        $project->delete();
    
        return redirect()->route('projects.index')->with('success', 'Projet supprimé avec succès.');
    }

public function kanban(Project $project)
{
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