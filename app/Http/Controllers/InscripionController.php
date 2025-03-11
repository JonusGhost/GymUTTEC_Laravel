<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Talleres;
use Illuminate\Http\Request;

class InscripionController extends Controller
{
    public function index()
    {
        $inscripciones = Inscripcion::get();
        return $inscripciones;
    }

    public function esttaller($matricula)
    {
        $inscripciones = Inscripcion::where('matricula',$matricula)->get();
        return $inscripciones;
    }
}
