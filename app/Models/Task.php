<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'status',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }
}
