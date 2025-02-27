<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gimnasios extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre_gim', 'descripcion', 'horario', 'num_alumnos', 'enlace_grupo', 'emp_docente_1' , 'emp_docente_2', 'emp_docente_3'
    ];

    public function docente1()
    {
        return $this->belongsTo(Docente::class, 'emp_docente_1');
    }

    public function docente2()
    {
        return $this->belongsTo(Docente::class, 'emp_docente_2');
    }

    public function docente3()
    {
        return $this->belongsTo(Docente::class, 'emp_docente_3');
    }
}