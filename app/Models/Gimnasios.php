<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gimnasios extends Model
{
    use HasFactory;
    protected $table = 'gimnasios';
    protected $fillable = [
        'nombre_gim', 'descripcion', 'num_alumnos', 'enlace_grupo', 'emp_docente'
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'emp_docente', 'matricula');
    }
}