<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromocionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promociones = DB::table('promociones')
            ->select('promociones.id', 'promociones.nombre', 'promociones.descripcion', 'promociones.vigenciaInicial', 'promociones.vigenciaFinal', 'promociones.idArticulo', 'promociones.cantidad', 'promociones.costo', 'articulos.nombre as articulo')
            ->where('promociones.eliminado', '=', 0)
            ->join('articulos', 'promociones.idArticulo', '=','articulos.id')
            ->get();
        return response()->json($promociones);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $promociones = ["nombre" => $request['nombre'], "descripcion" => $request["descripcion"], "vigenciaInicial" => $request['vigenciaInicial'], "vigenciaFinal" => $request['vigenciaFinal'], 'idArticulo' => $request['idArticulo'], 'cantidad' => $request['cantidad'], 'costo' => $request['costo'], 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        DB::table('promociones')->insert($promociones);
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
        $promociones = DB::table('promociones')->where('id', '=', $id)->where('eliminado', '=', 0)->first();
        return response()->json($promociones);
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
        $promociones = ["nombre" => $request['nombre'], "descripcion" => $request["descripcion"], "vigenciaInicial" => $request['vigenciaInicial'], "vigenciaFinal" => $request['vigenciaFinal'], 'idArticulo' => $request['idArticulo'], 'cantidad' => $request['cantidad'], 'costo' => $request['costo']];
        DB::table('promociones')->where('id', '=', $id)->where('eliminado', '=', 0)->update($promociones);
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
        DB::table('promociones')->where('id', '=', $id)->update(['eliminado' => 1]);
        return response()->json(['result' => 'ok']);
    }
}
