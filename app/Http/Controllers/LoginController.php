<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt(['matricula' => $request->matricula, 'password' => $request->password]))
        {
            $user = Auth::user();
            $token = $user->createToken('app')->plainTextToken;
            $arr = array('acceso' => "Ok", 'error' => "", 'token' => $token, 'idUsuario' => $user->matricula, 'rolUsuario'=> $user->rol);
            return json_encode($arr);
        }else{
            $arr = array('acceso' => "", 'error' => "No existe el usuario o contraseña", 'idUsuario' => 0);
            return json_encode($arr);
        }
    }
}
