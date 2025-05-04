<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;



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
    public function create($projectId)
    {
        return view('tasks.create', ['projectId' => $projectId]);
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

}
