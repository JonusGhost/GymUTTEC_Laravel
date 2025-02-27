<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;
    protected $table = 'docentes';

    public function taller()
    {
        return $this->hasOne(Talleres::class);
    }

    public function gimnasios()
    {
        return $this->belongsToMany(Gimnasios::class, 'gimnasios_docentes', 'docente_id', 'gimnasio_id');
    }
}