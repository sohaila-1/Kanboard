<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project; 
use App\Models\Task;



class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        return view('tasks.create', compact('project'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
    
        \App\Models\Task::create([
            'title' => $request->title,
            'project_id' => $projectId,
        ]);
    
        return redirect()->route('projects.show', $projectId)->with('success', 'Tâche ajoutée avec succès.');
    }
    public function move(Request $request, Task $task)
    {
        $task->category = ucfirst($request->category);
        $task->save();
    
        return response()->json(['status' => 'ok']);
    } 

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($projectId, Task $task)
{
    return view('tasks.edit', [
        'task' => $task,
        'projectId' => $projectId,
    ]);
}

public function update(Request $request, $projectId, Task $task)
{
    $request->validate([
        'title' => 'required|string|max:255',
    ]);

    $task->update([
        'title' => $request->title,
    ]);

    return redirect()->route('projects.show', $projectId)->with('success', 'Tâche mise à jour.');
}

public function destroy($projectId, Task $task)
{
    $task->delete();

    return redirect()->route('projects.show', $projectId)->with('success', 'Tâche supprimée.');
}


public function list(Request $request, Project $project)
{
    $query = $project->tasks();

    // Filtres possibles
    if ($request->filled('title')) {
        $query->where('title', 'like', '%' . $request->title . '%');
    }

    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    if ($request->filled('description')) {
        $query->where('description', 'like', '%' . $request->description . '%');
    }

    $tasks = $query->get();

    return view('tasks.list', compact('project', 'tasks'));
}

}