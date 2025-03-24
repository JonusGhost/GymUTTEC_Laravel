<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscripcionTal extends Model
{
    use HasFactory;
    protected $table = 'inscripciones_tal';
    protected $fillable = ['matricula', 'taller_id'];
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'matricula', 'matricula');
    }
    public function taller()
    {
        return $this->belongsTo(Talleres::class, 'taller_id');
    }
}
