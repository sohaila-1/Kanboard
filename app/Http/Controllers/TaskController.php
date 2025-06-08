<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project; 
use App\Models\Task;

class TaskController extends Controller
{
    public function index() {}

    public function create(Project $project)
    {
        return view('tasks.create', compact('project'));
    }

    public function store(Request $request, $projectId)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $datetime = null;
        if (!empty($validated['due_date']) && $request->filled('due_time')) {
            $datetime = $validated['due_date'] . ' ' . $request->input('due_time') . ':00';
        } elseif (!empty($validated['due_date'])) {
            $datetime = $validated['due_date'] . ' 00:00:00';
        }

        Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'category' => strtolower(trim($validated['category'] ?? 'à faire')),
            'due_date' => $datetime,
            'project_id' => $projectId,
        ]);

        return redirect()->route('projects.show', $projectId)
            ->with('success', 'Tâche ajoutée avec succès.');
    }

    public function move(Request $request, Task $task)
    {
        $task->category = strtolower(trim($request->category));
        $task->save();

        return response()->json(['status' => 'ok']);
    }

    public function show(string $id) {}

    public function edit($projectId, Task $task)
    {
        return view('tasks.edit', [
            'task' => $task,
            'projectId' => $projectId,
        ]);
    }

    public function update(Request $request, $projectId, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $datetime = null;
        if (!empty($validated['due_date']) && $request->filled('due_time')) {
            $datetime = $validated['due_date'] . ' ' . $request->input('due_time') . ':00';
        } elseif (!empty($validated['due_date'])) {
            $datetime = $validated['due_date'] . ' 00:00:00';
        }

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'category' => strtolower(trim($validated['category'] ?? 'à faire')),
            'due_date' => $datetime,
        ]);

        return redirect()->route('projects.show', $projectId)
            ->with('success', 'Tâche mise à jour.');
    }

    public function destroy($projectId, Task $task)
    {
        $task->delete();

        return redirect()->route('projects.show', $projectId)->with('success', 'Tâche supprimée.');
    }

    public function list(Request $request, Project $project)
    {
        $query = $project->tasks();

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
