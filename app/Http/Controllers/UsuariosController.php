<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $usuarios = DB::table('users')->get();

return response()->json($usuarios);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    $usuario=['email' => $request['email'], 'nombre' => $request['nombre'], 'apellido_paterno' => $request['apellido_paterno'], 'apellido_materno' => $request['apellido_materno'], 'tipo_usuario' => $request['tipo_usuario'], 'password' => bcrypt($request['password'])];
DB::table('users')->insert($usuario);
    return response()->json(['result' => 'ok']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
$usuario = DB::table('users')->where('id', '=', $id)->first();
return response()->json($usuario);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
$usuario=['email' => $request['email'], 'nombre' => $request['nombre'], 'apellido_paterno' => $request['apellido_paterno'], 'apellido_materno' => $request['apellido_materno'], 'tipo_usuario' => $request['tipo_usuario'], 'password' => bcrypt($request['password'])];
DB::table('users')->where('id', '=', $id)->update($usuario);

return response()->json(['result' => 'ok']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    DB::table('users')->where('id', '=', $id)->delete();
return response()->json(['result' => 'ok']);
    }
}
