<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectMemberController extends Controller
{
    public function store(Request $request, Project $project)
    {
        if (auth()->id() !== $project->user_id) {
            abort(403); // seul le créateur peut inviter
        }

        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Utilisateur introuvable.']);
        }

        if ($project->members->contains($user->id)) {
            return back()->withErrors(['email' => 'Cet utilisateur est déjà membre du projet.']);
        }

        $project->members()->attach($user->id);

        return back()->with('success', 'Utilisateur ajouté avec succès au projet.');
    }

    public function destroy(Project $project, User $user)
    {
        if (auth()->id() !== $project->user_id) {
            abort(403); // seul le créateur peut retirer
        }

        $project->members()->detach($user->id);

        return back()->with('success', 'Utilisateur retiré du projet.');
    }
}
