<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ImportarEventosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //cargar todos los proveedores con los productos que ofrecen
        $ImportarEventos = \App\ImportarEventos::all();

        if(count($ImportarEventos) == 0){
            return response()->json(['error'=>'No existen ImportarEventos.'], 404);          
        }else{
            return response()->json(['status'=>'ok', 'ImportarEventos'=>$ImportarEventos], 200);
        }
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
        

        $data=json_decode($request->input('data'));
        for ($i=0; $i < count($data); $i++) { 
            $cc=new \App\ImportarEventos;

            if ( property_exists($data[$i], 'evento')) {
                $cc->evento=$data[$i]->evento;
             }
             
             if ( property_exists($data[$i], 'tipo_del_evento')) {
                $cc->tipo_del_evento =$data[$i]->tipo_del_evento;
             }
             
             if ( property_exists($data[$i], 'datos_del_envento')) {
               $cc->datos_del_envento =$data[$i]->datos_del_envento;
             }
             
             if ( property_exists($data[$i], 'observaciones')) {
                $cc->observaciones =$data[$i]->observaciones;
             }
             
             if ( property_exists($data[$i], 'id_usuario')) {
                $cc->id_usuario =$data[$i]->id_usuario;
             }
             
             if ( property_exists($data[$i], 'usuario')) {
                $cc->usuario =$data[$i]->usuario; 
             }
             
             if ( property_exists($data[$i], 'nombre')) {
                $cc->nombre =$data[$i]->nombre; 
             }
             
             if ( property_exists($data[$i], 'telefono')) {
                $cc->telefono =$data[$i]->telefono;
             }
             
             if ( property_exists($data[$i], 'dni')) {
                $cc->dni =$data[$i]->dni;
             }
             
             if ( property_exists($data[$i], 'email')) {
                $cc->email =$data[$i]->email;
             }
             
             if ( property_exists($data[$i], 'ciudad')) {
                $cc->ciudad =$data[$i]->ciudad;
             }
             
             if ( property_exists($data[$i], 'pais')) {
                $cc->pais =$data[$i]->pais;
             }
             
             if ( property_exists($data[$i], 'url')) {
                $cc->url =$data[$i]->url;
             }
             
             if ( property_exists($data[$i], 'comentarios')) {
                $cc->comentarios =$data[$i]->comentarios;
             }
             
             if ( property_exists($data[$i], 'me_gusta')) {
                $cc->me_gusta =$data[$i]->me_gusta;
             }
             
             if ( property_exists($data[$i], 'fecha')) {
                $cc->fecha =$data[$i]->fecha;
             }
             
             if ( property_exists($data[$i], 'evento_id')) {
                $cc->evento_id =$data[$i]->evento_id;
             }
             
             if ( property_exists($data[$i], 'n_importacion')) {
                $cc->n_importacion=$data[$i]->n_importacion;
             }
             
             if ( property_exists($data[$i], 'ganador')) {
                $cc->ganador=$data[$i]->ganador;
             }
             
            if($cc->save()){

            }else{
                return response()->json(['error'=>'No se pudo crear registro','registro'=>$data[0]], 404);  
            }
        }

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //cargar un proveedor
        $proveedor = \App\ImportarEventos::find($id);

        if(count($proveedor)==0){
            return response()->json(['error'=>'No existe el proveedor con id '.$id], 404);          
        }else{

            //$proveedor->productos = $proveedor->productos;
            return response()->json(['status'=>'ok', 'proveedor'=>$proveedor], 200);
        }
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
        //cargar un proveedor
        $cc=\App\ImportarEventos::where('id',$id)->first();
        $cc->fill($request->all());

        if($cc->save())
            return response()->json(['status'=>'ok', 'CentroCostos'=>$cc], 200);
        else
            return response()->json(['error'=>'No se pudo crear cc'], 404); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // Comprobamos si el proveedor que nos están pasando existe o no.
        $cc=\App\ImportarEventos::where('evento_id',$id)->where('n_importacion',$request->input('importacion'));

        if (count($cc)==0)
        {
            // Devolvemos error codigo http 404
            return response()->json(['error'=>'No existe el proveedor con id '.$id], 404);
        } 
       
        //Eliminar las relaciones(productos) en la tabla pivote
        $cc->delete();

        return response()->json(['status'=>'ok', 'message'=>'Se ha eliminado correctamente el cc.'], 200);
    }

}
