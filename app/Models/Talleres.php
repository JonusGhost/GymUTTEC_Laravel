<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talleres extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre_tall', 'descripcion', 'horario', 'num_alumnos', 'enlace_grupo', 'emp_docente'
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }
}
