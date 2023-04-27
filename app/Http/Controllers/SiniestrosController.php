<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SiniestrosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ministro = Str::uuid()->toString().'.jpg';
        $supervisor = Str::uuid()->toString().'.jpg';
        Storage::disk('public')->put($ministro, base64_decode($request['hoja_ministro']));
        Storage::disk('public')->put($supervisor, base64_decode($request['hora_supervisor']));
        $info=['fecha' => $request['fecha'], 'hora' => $request['hora'], 'tipo' => $request['tipo'], 'descripcion' => $request['descripcion'], 'hoja_ministro' => $ministro, 'hoja_supervisor' => $supervisor, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $id = DB::table('siniestros')->insertGetId($info);
        $articulos = json_decode($request['articulos']);
        foreach ($articulos as $articulo){
            $a = ['idSiniestro' => $id, 'idArticulo' => $articulo->id, 'cantidad' => $articulo->cantidad];
            DB::table('articulos_siniestros')->insert($a);
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
