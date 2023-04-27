<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticulosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articulos = DB::table('articulos')->get();
        return response()->json($articulos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $articulos=['nombre' => $request['nombre'], 'costoPieza' => $request['costoPieza'], 'numPiezaPaquete' => $request['numPiezaPaquete'], 'stockInicial' => $request['stockInicial'], 'clasificacion' => $request['clasificacion'], 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        DB::table('articulos')->insert($articulos);
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
        $articulo = DB::table('articulos')->where('id', '=', $id)->first();
        return response()->json($articulo);
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
        $articulos=['nombre' => $request['nombre'], 'costoPieza' => $request['costoPieza'], 'numPiezaPaquete' => $request['numPiezaPaquete'], 'stockInicial' => $request['stockInicial'], 'clasificacion' => $request['clasificacion']];
        DB::table('articulos')->where('id', '=', $id)->update($articulos);
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
        DB::table('articulos')->where('id', '=', $id)->delete();
        return response()->json(['result' => 'ok']);
    }

    public function buscador(Request $request)
    {
        $texto = $request['texto'];
        $articulos = DB::table('articulos')->where('nombre', 'like','%'.$texto.'%')->get();
        return response()->json($articulos);
    }
}
