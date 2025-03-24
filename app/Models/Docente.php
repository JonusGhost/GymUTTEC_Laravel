<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;
    protected $table = 'docentes';
    protected $primaryKey = 'matricula';
    public $incrementing = false;
    protected $fillable = ['matricula', 'nombre', 'apellido_pat', 'apellido_mat', 'num_celular', 'afili_seguro', 'especialidad'];

    public function taller()
    {
        return $this->hasOne(Talleres::class, 'emp_docente', 'matricula');
    }

    public function gimnasio()
    {
        return $this->hasOne(Gimnasios::class, 'emp_docente', 'matricula');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'matricula', 'matricula');
    }
}