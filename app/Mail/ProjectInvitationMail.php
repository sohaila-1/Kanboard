<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $project;
    public $token;

    public function __construct($project, $token)
    {
        $this->project = $project;
        $this->token = $token;
    }

    public function build()
    {
        $url = url("/projects/invite/accept/{$this->token}");

        return $this->subject("Invitation à rejoindre le projet {$this->project->title}")
                    ->view('emails.project_invitation')
                    ->with([
                        'url' => $url,
                        'project' => $this->project,
                    ]);
    }
}
