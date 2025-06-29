<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectMemberController extends Controller
{
    public function create(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        return view('projects.members.add', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($project->members->contains($user->id)) {
            return redirect()->back()->with('error', 'Cet utilisateur est déjà membre.');
        }

        $project->members()->attach($user->id);

        return redirect()->route('projects.show', $project)->with('success', 'Membre ajouté avec succès.');
    }
    public function destroy($projectId, $memberId)
{
    // On supprime le membre du projet
    DB::table('project_members')
        ->where('project_id', $projectId)
        ->where('user_id', $memberId)
        ->delete();

    return redirect()->route('projects.show', $projectId)
                     ->with('success', 'Membre retiré avec succès.');
}

}

