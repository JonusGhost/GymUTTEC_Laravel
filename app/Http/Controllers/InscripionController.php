<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use Illuminate\Http\Request;

class InscripionController extends Controller
{
    public function index()
    {
        $inscripciones = Inscripcion::get();
        return $inscripciones;
    }
}
