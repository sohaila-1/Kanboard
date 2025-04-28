<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Project;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'project_id',
        'user_id',
    ];

    /**
     * Relation avec Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Relation avec User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
