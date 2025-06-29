<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    public function create(Project $project)
    {
        return view('tasks.create', compact('project'));
    }

    public function store(Request $request, Project $project)
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
        }

        Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'category' => strtolower(trim($validated['category'] ?? 'à faire')),
            'due_date' => $datetime,
            'project_id' => $project->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Tâche ajoutée avec succès.');
    }

    public function edit(Project $project, Task $task)
    {
        return view('tasks.edit', compact('project', 'task'));
    }

    public function update(Request $request, Project $project, Task $task)
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
        }

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'category' => strtolower(trim($validated['category'] ?? 'à faire')),
            'due_date' => $datetime,
        ]);

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Tâche modifiée avec succès.');
    }

    public function destroy(Project $project, Task $task)
    {
        $task->delete();

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Tâche supprimée avec succès.');
    }

    public function move(Request $request, Task $task)
    {
        $task->category = strtolower(trim($request->category));
        $task->save();

        return response()->json(['success' => true]);
    }
}
