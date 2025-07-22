<?php

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $project;
    public $token;

    public function __construct(Project $project, string $token)
    {
        $this->project = $project;
        $this->token = $token;
    }

    public function build()
    {
        $url = route('projects.invite.accept', ['token' => $this->token]);

        return $this->subject('Invitation à rejoindre un projet')
            ->view('emails.project_invitation')
            ->with([
                'project' => $this->project,
                'url' => $url,
            ]);
    }
}
