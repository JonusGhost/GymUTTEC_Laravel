<?php

namespace App\Http\Controllers;

use App\Models\A_User;
use App\Models\D_User;
use App\Models\E_User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function a_register(Request $req)
    {
        if($req->num_empleado != 0)
        {
            $a_user = A_User::find($req->num_empleado);
        }else{
            $a_user = new A_User();
            $a_user->num_empleado = $req->num_empleado;
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
    
    public function d_register(Request $req)
    {
        if($req->num_empleado != 0)
        {
            $d_user = D_User::find($req->num_empleado);
        }else{
            $d_user = new D_User();
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
    
    public function e_register(Request $req)
    {
        if($req->matricula != 0)
        {
            $e_user = E_User::find($req->matricula);
        }else{
            $e_user = new E_User();
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
