<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Inscripcion;
use App\Models\Talleres;
use App\Models\Gimnasios;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EstudianteController extends Controller
{
    public function index()
    {
        $estudiantes = Estudiante::get();
        return $estudiantes;
    }

    public function estudent($matricula) {
        $estudiante = Estudiante::with('users')->where('matricula', $matricula)->first();
        return response()->json($estudiante);
    }
    
    public function talleresYGimnasios(Request $req)
    {
        $req->validate([
            'matricula' => 'required|string',
            'taller_id' => 'required|integer|exists:talleres,id'
        ]);
    
        $matricula = trim($req->matricula);
        $taller_id = $req->taller_id;
    
        $inscrito = Inscripcion::where('matricula', $matricula)
            ->where('taller_id', $taller_id)
            ->exists();
    
        return response()->json(['inscrito' => $inscrito]);
    }

    public function inscrip(Request $req)
    {
        $matricula = trim($req->matricula);
        $taller_id = $req->taller_id;

        $a_user = Estudiante::where('matricula', $matricula)->first();
        if (!$a_user){
            return 'Matricula inexistente';
        }
        $taller = Talleres::find($taller_id);
        if (!$taller){
            return 'Taller inexistente';
        }
        $inscritos = Inscripcion::where('taller_id',$taller_id)->count();
        if ($inscritos >= $taller->num_alumnos){
            return 'Taller alcanzó el cupo máximo de estudiantes';
        }
        $inscripcion = new Inscripcion();
        $inscripcion->matricula = $matricula;
        $inscripcion->taller_id = $taller_id;
        $inscripcion->save();
        return 'Ok';
    }

    public function anular(Request $req)
    {
        $matricula = trim($req->matricula);
        $taller_id = trim($req->taller_id);
        $inscripcion = Inscripcion::where('matricula', $matricula)->where('taller_id', $taller_id)->first();
        if ($inscripcion) {
            $inscripcion->delete();
            return 'Ok';
        } else {
            return 'Inscripción inexistente';
        }
    }

    public function destroy($matricula) {
        $user = User::find($matricula);
        if ($user){
            $estudiante = Estudiante::where('matricula',$matricula)->first();
            if ($estudiante){
                $estudiante->delete();
            }
            $user->delete();
            return 'Ok';
        }
        return 'Usuario no encontrado';
    }

    public function store(Request $req)
    {
        $matricula = trim($req->matricula);
        $e_user = Estudiante::where('matricula', $matricula)->first();

        if (!$e_user) {
            $e_user = new Estudiante();
            $e_user->matricula = $matricula;

            if (User::where('email', strtolower($req->email))->exists()) { 
                return response()->json(['mensaje' => 'El correo ya está en uso'], 400);
            }

            $user = new User();
            $user->matricula = $matricula;
            $user->rol = 'E';
            $user->email = $req->email;
            $user->password = Hash::make($req->password);
            $user->save();
        } else {
            $user = User::where('matricula', $matricula)->first();
            if ($req->filled('password')){
                $user->password = Hash::make($req->password);
                $user->save();
            }
        }

        $e_user->nombre = $req->nombre;
        $e_user->apellido_pat = $req->apellido_pat;
        $e_user->apellido_mat = $req->apellido_mat;
        $e_user->num_celular = $req->num_celular;
        $e_user->afili_seguro = $req->afili_seguro;    
        $e_user->grado = $req->grado;
        $e_user->sit_academica = $req->sit_academica;
        $e_user->save();

        return response()->json([
            'mensaje' => 'Estudiante guardado',
            'estudiante' => $e_user
        ], 201);
    }
}
