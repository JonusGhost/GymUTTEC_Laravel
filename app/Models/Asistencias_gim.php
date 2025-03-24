<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencias_gim extends Model
{
    use HasFactory;
    protected $table = 'asistencia_gimnasios';
    protected $fillable = ['fecha_asistencia', 'horas_asignadas', 'gimnasio_id', 'matricula', 'estado'];
    public function taller()
    {
        return $this->belongsTo(Gimnasios::class, 'gimnasio_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'matricula', 'matricula');
    }
}
