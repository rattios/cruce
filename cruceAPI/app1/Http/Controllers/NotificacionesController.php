<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NotificacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tokens = \App\InspTokenNotificaciones::get();

        //return response()->json(['tokens'=>$tokens], 200);

        return $tokens;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $tokenNotificaciones = $request->input('tokenNotificaciones');

        $aux = \App\InspTokenNotificaciones::where('token', $tokenNotificaciones)->get();

        if(count($aux) != 0){
            return response()->json(['status'=>'ok ya existe'], 200);
        }

        $notificaciones = new \App\InspTokenNotificaciones;

        $notificaciones->token = $tokenNotificaciones;

        // Almacenamos en la base de datos el registro.
        if($notificaciones->save()){
            return response()->json(['status'=>'ok'], 200);
        }else{
            return response()->json(['error'=>'No se pudo guardar el token para las nitificaciones.'], 304);
        }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
