<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = \App\Models\Project::all(); // PAS de where('user_id') si pas d’auth
    
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
        ]);
    
        return redirect()->route('projects.index')->with('success', 'Projet créé avec succès.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = \App\Models\Project::with('tasks')->findOrFail($id);
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }
    
    public function update(Request $request, Project $project)
    {
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
        $project->load('tasks');
        return view('projects.kanban', compact('project'));
    }

    public function calendar(Project $project)
{
    $tasks = $project->tasks()
        ->select('title', 'due_date')
        ->whereNotNull('due_date')
        ->get();

    $events = $tasks->map(function ($task) {
        return [
            'title' => $task->title,
            'start' => $task->due_date
        ];
    });

    return view('projects.calendar', compact('project', 'events'));
}

     

}