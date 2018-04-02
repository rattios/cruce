<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\DB;
use Hash;
use DB;
class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //cargar todos los usuarios
        $usuarios = \App\User::all();
        if(count($usuarios) == 0){
            return response()->json(['error'=>'No existen usuarios.'], 404);          
        }else{
            return response()->json(['status'=>'ok', 'usuarios'=>$usuarios], 200);
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
        // Primero comprobaremos si estamos recibiendo todos los campos.
        if ( !$request->input('user') || !$request->input('password') ||
             !$request->input('nombre'))
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['error'=>'Faltan datos necesarios para el proceso de alta.'],422);
        } 
        
        $aux = \App\User::where('user', $request->input('user'))->get();
        if(count($aux)!=0){
           // Devolvemos un código 409 Conflict. 
            return response()->json(['error'=>'Ya existe un usuario con esas credenciales.'], 409);
        }
        /*Primero creo una instancia en la tabla usuarios*/
        $usuario = new \App\User;
        $usuario->user = $request->input('user');
        $usuario->password = Hash::make($request->input('password'));
        $usuario->nombre = $request->input('nombre');
        if($usuario->save()){
           return response()->json(['status'=>'ok', 'usuario'=>$usuario], 200);
        }else{
            return response()->json(['error'=>'Error al crear el usuario.'], 500);
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
        //cargar un usuario
        $usuario = \App\User::find($id);
        if(count($usuario)==0){
            return response()->json(['error'=>'No existe el usuario con id '.$id], 404);          
        }else{
            return response()->json(['status'=>'ok', 'usuario'=>$usuario], 200);
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
        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Comprobamos si el usuario que nos están pasando existe o no.
        $usuario=\App\User::find($id);
        if (count($usuario)==0)
        {
            // Devolvemos error codigo http 404
            return response()->json(['error'=>'No existe el usuario con id '.$id], 404);
        }
        // Eliminamos el usuario.
        $usuario->delete();
        return response()->json(['status'=>'ok', 'message'=>'Se ha eliminado correctamente el usuario.'], 200);
    }
}