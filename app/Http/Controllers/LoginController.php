<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginT(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $user = Auth::user();
            $token = $user->createToken('app')->plainTextToken;
            $arr = array('acceso' => "Ok", 'error' => "", 'token' => $token, 'idUsuario' => $user->num_empleado, 'nombreUsuario' => $user->nombre);
            return json_encode($arr);
        }else{
            $arr = array('acceso' => "", 'error' => "No existe el usuario o contraseña", 'idUsuario' => 0, 'nombreUsuario' => '');
            return json_encode($arr);
        }
    }

    public function loginE(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $user = Auth::user();
            $token = $user->createToken('app')->plainTextToken;
            $arr = array('acceso' => "Ok", 'error' => "", 'token' => $token, 'idUsuario' => $user->matricula, 'nombreUsuario' => $user->nombre);
            return json_encode($arr);
        }else{
            $arr = array('acceso' => "", 'error' => "No existe el usuario o contraseña", 'idUsuario' => 0, 'nombreUsuario' => '');
            return json_encode($arr);
        }
    }
}
