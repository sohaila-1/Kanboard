<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectInvitation extends Model
{
    protected $fillable = ['project_id', 'email', 'token']; // ✅ Ajoute les colonnes ici
}
