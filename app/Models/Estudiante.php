<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;
    protected $table = 'estudiantes';

    public function users()
    {
        return $this->belongsTo(User::class, 'matricula', 'matricula');
    }
}