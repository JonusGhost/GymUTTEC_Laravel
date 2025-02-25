<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::get();
        return $docentes;
    }

    public function store(Request $req)
    {
        if($req->num_empleado != 0)
        {
            $d_user = Docente::find($req->num_empleado);
        }else{
            $d_user = new Docente();
            $d_user->num_empleado = $req->num_empleado;
        }
        $d_user->nombre = $req->nombre;
        $d_user->apellido_pat = $req->apellido_pat;
        $d_user->apellido_mat = $req->apellido_mat;
        $d_user->num_celular = $req->num_celular;
        $d_user->afili_seguro = $req->afili_seguro;    
        $d_user->especialidad = $req->especialidad;
        $d_user->taller_asignado = $req->taller_asignado;
        $d_user->email = $req->email;
        $d_user->password = Hash::make($req->password);

        $d_user->save();

        return 'Ok';
    }
}
