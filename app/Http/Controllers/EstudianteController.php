<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EstudianteController extends Controller
{
    public function index()
    {
        $estudiantes = Estudiante::get();
        return $estudiantes;
    }
    
    public function store(Request $req)
    {
        if($req->matricula != 0)
        {
            $e_user = Estudiante::find($req->matricula);
        }else{
            $e_user = new Estudiante();
            $e_user->matricula = $req->matricula;
        }
        $e_user->nombre = $req->nombre;
        $e_user->apellido_pat = $req->apellido_pat;
        $e_user->apellido_mat = $req->apellido_mat;
        $e_user->num_celular = $req->num_celular;
        $e_user->afili_seguro = $req->afili_seguro;    
        $e_user->grado = $req->grado;
        $e_user->sit_academica = $req->sit_academica;
        $e_user->email = $req->email;
        $e_user->password = Hash::make($req->password);
        $e_user->save();

        return 'Ok';
    }
}
