<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\ProjectInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectInvitationMail;
use Illuminate\Support\Str;

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

        // ✅ 2. Sinon → créer une invitation
        $token = Str::uuid();

        ProjectInvitation::create([
            'project_id' => $project->id,
            'email' => $email,
            'token' => $token,
        ]);

        // Envoie de l'invitation
        Mail::to($email)->send(new ProjectInvitationMail($project, $token));

        return back()->with('success', 'Invitation envoyée à ' . $email);
    }

    public function acceptInvitation($token)
{
    $invitation = ProjectInvitation::with('project.members')->where('token', $token)->first();

    if (!$invitation || !$invitation->project) {
        abort(404, 'Projet introuvable ou invitation invalide.');
    }

    if (!auth()->check()) {
        session(['invitation_token' => $token]);
        return redirect()->route('login')->with('info', 'Connectez-vous pour accepter l’invitation.');
    }

    $user = auth()->user();
    $project = $invitation->project;

    if ($project->members->contains($user->id)) {
        $invitation->delete();
        return redirect()->route('projects.show', $project->id)
            ->with('info', 'Vous êtes déjà membre de ce projet.');
    }

    $project->members()->attach($user->id);
    $invitation->delete();

    return view('projects.invitation_accepted', ['project' => $project]);

}
}
