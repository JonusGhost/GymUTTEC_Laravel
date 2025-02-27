<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencias extends Model
{
    use HasFactory;
    protected $table = 'asistencia_talleres';
    protected $fillable = ['fecha_asistencia', 'horas_asignadas', 'taller_id', 'matricula', 'estado'];
    public function taller()
    {
        return $this->belongsTo(Talleres::class, 'taller_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'matricula', 'matricula');
    }
}
