<?php

namespace App\Http\Controllers;

use App\Models\Administradores;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    public function index()
    {
        $administradores = Administradores::get();
        return $administradores;
    }
}
