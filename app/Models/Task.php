<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\User;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'priority',
        'due_date',
        'project_id',
        'user_id',
    ];

    /**
     * Projet auquel appartient la tâche
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Utilisateur créateur de la tâche
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Utilisateurs assignés à cette tâche (prévu pour plus tard)
     */
    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }
}
