<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdministradorController extends Controller
{
    public function index()
    {
        $administradores = Administrador::get();
        return $administradores;
    }

    public function admin($matricula) {
        $administrador = Administrador::where('matricula',$matricula)->first();
        return $administrador;
    }

    public function destroy($matricula) {
        $user = User::find($matricula);
        if ($user){
            $admin = Administrador::where('matricula',$matricula)->first();
            if ($admin){
                $admin->delete();
            }
            $user->delete();
            return 'Ok';
        }
        return 'Usuario no encontrado';
    }

    public function store(Request $req)
    {
        $matricula = trim($req->matricula);
        $a_user = Administrador::where('matricula', $matricula)->first();

        if (!$a_user) {
            $a_user = new Administrador();
            $a_user->matricula = $matricula;

            $user = new User();
            $user->matricula = $matricula;
            $user->rol = 'A';
            $user->email = $req->email;

            if (User::where('email', $req->email)->exists()) {
                return 'El correo ya está en uso';
            }

            $user->password = Hash::make($req->password);
            $user->save();
        }

        $a_user->nombre = $req->nombre;
        $a_user->apellido_pat = $req->apellido_pat;
        $a_user->apellido_mat = $req->apellido_mat;
        $a_user->num_celular = $req->num_celular;
        $a_user->afili_seguro = $req->afili_seguro;
        $a_user->save();

        return 'Ok';
    }
}
