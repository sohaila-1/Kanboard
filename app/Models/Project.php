<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Task;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    /**
     * Relation avec User (propriétaire du projet)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec Tasks (tâches du projet)
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function members()
{
    return $this->belongsToMany(User::class, 'project_user');
}
public function creator()
{
    return $this->belongsTo(User::class, 'user_id');
}

}
