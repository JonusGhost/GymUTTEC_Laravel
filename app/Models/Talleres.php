<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talleres extends Model
{
    use HasFactory;
    protected $table = 'talleres';
    protected $fillable = [
        'nombre_tall', 'descripcion', 'num_alumnos', 'enlace_grupo', 'emp_docente'
    ];

    protected $casts = [
        'horario' => 'array',
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'emp_docente', 'matricula');
    }
}
