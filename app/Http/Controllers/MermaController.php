<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MermaController extends Controller
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
        $articulosStock = DB::table('articulos_stock')->where('idArticulo', '=', $request['idArticulo'])->first();
        if($request['cantidad'] > $articulosStock->cantidad){
            return response()->json(['result' => 'La cantidad de articulos proporcionada es mayor contra la que se tiene en stock.']);
        }
        $merma = ['idArticulo' => $request['idArticulo'], 'cantidad' => $request['cantidad'], 'tipoMerma' => $request['tipoMerma'], 'tipoDano' => $request['tipoDano'], 'cambioProveedor' => $request['cambioProveedor'], 'idArticuloEntregado' => $request['idArticuloEntregado'], 'cantidadEntregado' => $request['cantidadEntregado'], 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];
        DB::table('mermas')->insert($merma);
        $articulosStock = DB::table('articulos_stock')->where('idArticulo', '=', $request['idArticulo'])->first();
        DB::table('articulos_stock')->where('idArticulo', '=', $request['idArticulo'])->update(['cantidad' => $articulosStock->cantidad - $request['cantidad']]);
        if ($request['tipoMerma'] == "Dañado en embajale" || $request['tipoMerma'] == "Dañado en sucursal" && $request['cambioProveedor'] == 'Si'){
            $articulosStockCambio = DB::table('articulos_stock')->where('idArticulo', '=', $request['idArticuloEntregado'])->first();
            DB::table('articulos_stock')->where('idArticulo', '=', $request['idArticuloEntregado'])->update(['cantidad' => $articulosStockCambio->cantidad + $request['cantidadEntregado']]);
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
