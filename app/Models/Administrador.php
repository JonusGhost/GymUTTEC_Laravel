<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    use HasFactory;
    protected $table = 'administradores';

    public function users()
    {
        return $this->belongsTo(User::class, 'matricula', 'matricula');
    }
}