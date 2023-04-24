<?php

namespace App\Http\Controllers;

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
        $promociones = DB::table('promociones')->get();
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
        $promociones = ["nombre" => $request['nombre'], "descripcion" => $request["descripcion"], "vigencia" => $request['vigencia']];
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
        $promociones = DB::table('promociones')->where('id', '=', $id)->first();
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
        $promociones = ["nombre" => $request['nombre'], "descripcion" => $request["descripcion"], "vigencia" => $request['vigencia']];
        DB::table('promociones')->where('id', '=', $id)->update($promociones);
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
        DB::table('promociones')->where('id', '=', $id)->delete();
        return response()->json(['result' => 'ok']);
    }
}
