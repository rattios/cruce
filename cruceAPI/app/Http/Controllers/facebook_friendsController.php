<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class facebook_friendsController extends Controller
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
    public function createFriends(Request $request)
    {
        //usuario, email, facebook_id

        for ($i=0; $i < 100; $i++) { 
            
            $nuevoFacebook=new \App\Facebook_friends;
            $nuevoFacebook->usuario= 'prueba'+$i;
            $nuevoFacebook->email= 'prueba'+$i+'@indicadores.com';
            $nuevoFacebook->facebook_id= rand(0,10);

            if ($nuevoFacebook->save()) {
               return response()->json(['message'=>'Nuevo facebook registrado.',
                 'facebook'=>$nuevoFacebook], 200);
            }else{
                return response()->json(['error'=>'Error al registrar el nuevo facebook.'], 500);
            }
        }
    }
    public function store(Request $request)
    {
        
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
