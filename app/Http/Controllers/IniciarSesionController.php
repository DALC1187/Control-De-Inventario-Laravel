<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IniciarSesionController extends Controller
{
    public function iniciar(Request $request){
        $USUARIO = ["email" => $request["email"], "password" => $request["password"]];
        $TOKEN = auth()->attempt($USUARIO);
        if ($TOKEN == null) {
            return response()->json('Información incorrecta', 500);
        }
        $USER = Auth::user();
        $RETURN = ["user" => $USER, "token" => $TOKEN];
        return response()->json($RETURN);
    }
}
