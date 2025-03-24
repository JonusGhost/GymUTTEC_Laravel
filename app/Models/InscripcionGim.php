<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscripcionGim extends Model
{
    use HasFactory;
    protected $table = 'inscripciones_gim';
    protected $fillable = ['matricula', 'gimnasio_id'];
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'matricula', 'matricula');
    }
    public function taller()
    {
        return $this->belongsTo(Talleres::class, 'gimnasio_id');
    }
}
