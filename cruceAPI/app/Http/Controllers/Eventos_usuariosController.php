<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class Eventos_usuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //cargar todos los proveedores con los productos que ofrecen
        $ImportarEventos = \App\Eventos_usuarios::all();

        if(count($ImportarEventos) == 0){
            return response()->json(['error'=>'No existen ImportarEventos.'], 404);          
        }else{
            return response()->json(['status'=>'ok', 'usuarios'=>$ImportarEventos], 200);
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
            $cc=new \App\Eventos_usuarios;

            if ( property_exists($data[$i], 'nombre')) {
                $cc->nombre=$data[$i]->nombre;
             }
             
             if ( property_exists($data[$i], 'dni')) {
                $cc->dni =$data[$i]->dni;
             }
             
             if ( property_exists($data[$i], 'telefono')) {
               $cc->telefono =$data[$i]->telefono;
             }
             
             if ( property_exists($data[$i], 'email')) {
                $cc->email =$data[$i]->email;
             }
             
             if ( property_exists($data[$i], 'usuario')) {
                $cc->usuario =$data[$i]->usuario;
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
        $proveedor = \App\Eventos_usuarios::find($id);

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
        $cc=\App\Eventos_usuarios::where('id',$id)->first();;
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
    public function destroy($id)
    {
        // Comprobamos si el proveedor que nos están pasando existe o no.
        $cc=\App\Eventos_usuarios::find($id);

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
