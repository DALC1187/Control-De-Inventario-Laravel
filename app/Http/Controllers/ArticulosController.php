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
        $articulos = DB::table('articulos')->where('eliminado', '=', 0)->orderBy('nombre', 'ASC')->get();
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
        $articulos=['nombre' => $request['nombre'], 'costoPieza' => $request['costoPieza'], 'numPiezaPaquete' => $request['numPiezaPaquete'], 'clasificacion' => $request['clasificacion'], 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        $id = DB::table('articulos')->insertGetId($articulos);
        $articulosStock = ['idArticulo' => $id, 'cantidad' => $request['stockInicial'] * $request['numPiezaPaquete'], 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        DB::table('articulos_stock')->insert($articulosStock);
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
        $articulo = DB::table('articulos')->where('id', '=', $id)->where('eliminado', '=', 0)->first();
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
        $articulos=['nombre' => $request['nombre'], 'costoPieza' => $request['costoPieza'], 'numPiezaPaquete' => $request['numPiezaPaquete'], 'clasificacion' => $request['clasificacion']];
        DB::table('articulos')->where('id', '=', $id)->where('eliminado', '=', 0)->update($articulos);
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
        DB::table('articulos')->where('id', '=', $id)->update(['eliminado' => 1]);
        return response()->json(['result' => 'ok']);
    }

    public function buscador(Request $request)
    {
        $texto = $request['texto'];
        $articulos = DB::table('articulos')->where('nombre', 'like','%'.$texto.'%')->where('eliminado', '=', 0)->orderBy('nombre', 'ASC')->get();
        return response()->json($articulos);
    }

    public function entrantes(Request $request)
    {
        $articulosStock = DB::table('articulos_stock')->where('idArticulo', '=', $request['idArticulo'])->first();
        DB::table('articulos_stock')->where('idArticulo', '=', $request['idArticulo'])->update(['cantidad' => $articulosStock->cantidad + $request['cantidad']]);
        return response()->json(['result' => 'ok']);
    }

    public function masVendido()
    {
        $articulos = DB::table('articulos')->where('eliminado', '=', 0)->where('clasificacion', '=', 'Mas vendido')->orderBy('nombre', 'ASC')->get();
        return response()->json($articulos);
    }
}
