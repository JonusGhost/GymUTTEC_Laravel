<?php

namespace App\Http\Controllers;

use App\Models\InscripcionGim;
use App\Models\InscripcionTal;
use App\Models\Talleres;
use Illuminate\Http\Request;

class InscripionController extends Controller
{
    public function index()
    {
        $inscripcionesGim = InscripcionGim::all();
        $inscripcionesTal = InscripcionTal::all();
        return response()->json(['gimnasios' => $inscripcionesGim,'talleres' => $inscripcionesTal]);
    }

    public function esttaller($matricula)
    {
        $inscripciones = InscripcionTal::where('matricula', $matricula)->get();
        return response()->json($inscripciones);
    }

    public function estgimnasio($matricula)
    {
        $inscripciones = InscripcionGim::where('matricula', $matricula)->get();
        return response()->json($inscripciones);
    }
}
