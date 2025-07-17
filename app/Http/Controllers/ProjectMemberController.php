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
    $project->load('members');
    return view('projects.members.add', compact('project'));
}


    public function store(Request $request, Project $project)
{
    $request->validate(['email' => 'required|email']);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'Utilisateur introuvable.']);
    }

    if ($project->members->contains($user->id)) {
        return back()->withErrors(['email' => 'Cet utilisateur est déjà membre.']);
    }

    $project->members()->attach($user->id);

    return back()->with('success', 'Membre ajouté avec succès.');
}

    public function destroy(Project $project, \App\Models\User $member)
{
    $project->members()->detach($member->id);
    return back()->with('success', 'Membre retiré.');
}


}

