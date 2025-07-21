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
    'due_date', // ← ce champ est obligatoire ici
    'project_id',
];

public function creator()
{
    return $this->belongsTo(\App\Models\User::class, 'user_id');
}



}