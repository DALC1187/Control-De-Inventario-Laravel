<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
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
        $articulos = json_decode($request['articulos']);
        $general=$request->input('general');
        foreach ($articulos as $articulo){
            $articulosStock = DB::table('articulos_stock')->where('idArticulo', '=', $articulo->id)->first();
            if($articulo->cantidad > $articulosStock->cantidad){
                return response()->json(['result' => 'La cantidad proporcionada de algunos de los articulos es mayor contra la que se tiene en stock.']);
            }
        }
        $inventario = DB::table('inventarios')->insertGetId(['fechaInventario' => Carbon::now(), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'general' => $general]);
        $articulos = json_decode($request['articulos']);
        $subtotalVentaGeneral=0;
        $totalVentaGeneral=0;
        foreach ($articulos as $articulo){
            $articulosStock = DB::table('articulos_stock')->where('idArticulo', '=', $articulo->id)->first();
            $art = DB::table('articulos')->where('id', '=', $articulo->id)->first();
            $idPromocion=null;
            $cantidadPromocion=null;
            $costoPromocion=null;
            $cantidadVenta=$articulosStock->cantidad - $articulo->cantidad;
            $totalVenta=0;
            DB::table('mermas')->where('idArticulo', '=', $articulo->id)->where('idInventario', '=', null)->update(['idInventario' => $inventario]);
            DB::table('articulos_siniestros')->where('idArticulo', '=', $articulo->id)->where('idInventario', '=', null)->update(['idInventario' => $inventario]);
            $promocion = DB::table('promociones')->where('idArticulo', '=', $articulo->id)->where('eliminado', '=', 0)->whereRaw("DATE(NOW()) BETWEEN `vigenciaInicial` AND `vigenciaFinal`")->first();
            if($promocion){
                $idPromocion=$promocion->id;
                $cantidadPromocion=$promocion->cantidad;
                $costoPromocion=$promocion->costo;
                $res=$cantidadVenta % $promocion->cantidad;
                if($res==0){
                    $totalVenta=($cantidadVenta/$promocion->cantidad)*$promocion->costo;
                }else{
                    $t =(($cantidadVenta-$res)/$promocion->cantidad)*$promocion->costo;
                    $totalVenta=($res*$art->costoPieza)+$t;
                }
            }else{
                $totalVenta=$cantidadVenta*$art->costoPieza;
            }
            DB::table('inventarios_articulos')->insert([
                'idInventario'=>$inventario,
                'idArticulo'=>$articulo->id,
                'cantidadStock'=>$articulosStock->cantidad,
                'cantidad'=>$articulo->cantidad,
                'costoUnitario'=>$art->costoPieza,
                'idPromocion'=>$idPromocion,
                'cantidadPromocion'=>$cantidadPromocion,
                'costoPromocion'=>$costoPromocion,
                'cantidadVenta'=>$cantidadVenta,
                'subtotalVenta'=>$cantidadVenta * $art->costoPieza,
                'totalVenta'=>$totalVenta,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            DB::table('articulos_stock')->where('idArticulo', '=', $articulo->id)->update(['cantidad' => $articulo->cantidad]);
            $subtotalVentaGeneral+=$cantidadVenta * $art->costoPieza;
            $totalVentaGeneral+=$totalVenta;
        }
        DB::table('inventarios')->where('id', '=', $inventario)->update(['subtotalVenta'=>$subtotalVentaGeneral, 'totalVenta'=>$totalVentaGeneral]);
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
