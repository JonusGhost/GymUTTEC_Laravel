<?php

namespace App\Http\Controllers;

use App\Models\Administradore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdministradorController extends Controller
{
    public function index()
    {
        $administradores = Administradore::get();
        return $administradores;
    }

    public function store(Request $req)
    {
        if($req->num_empleado != 0)
        {
            $a_user = Administradore::find($req->num_empleado);
        }else{
            $a_user = new Administradore();
        }
        $a_user->nombre = $req->nombre;
        $a_user->apellido_pat = $req->apellido_pat;
        $a_user->apellido_mat = $req->apellido_mat;
        $a_user->num_celular = $req->num_celular;
        $a_user->afili_seguro = $req->afili_seguro;    
        $a_user->email = $req->email;
        $a_user->password = Hash::make($req->password);

        $a_user->save();

        return 'Ok';
    }
}
