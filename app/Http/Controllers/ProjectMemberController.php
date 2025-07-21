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
        abort(403);
    }

    $request->validate([
        'email' => 'required|email',
    ]);

    $email = $request->email;
    $user = User::where('email', $email)->first();

    // ✅ 1. Si l'utilisateur existe déjà
    if ($user) {
        if ($project->members->contains($user->id)) {
            return back()->withErrors(['email' => 'Cet utilisateur est déjà membre du projet.']);
        }

        $project->members()->attach($user->id);
        return back()->with('success', 'Utilisateur ajouté avec succès au projet.');
    }

    // ✅ 2. S'il n'existe pas encore → envoyer une invitation
    $token = Str::uuid();

    ProjectInvitation::create([
        'project_id' => $project->id,
        'email' => $email,
        'token' => $token,
    ]);

    Mail::to($email)->send(new ProjectInvitationMail($project, $token));

    return back()->with('success', 'Invitation envoyée à ' . $email);
}
}
