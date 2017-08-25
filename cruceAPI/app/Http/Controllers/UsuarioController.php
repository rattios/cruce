<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*Retorna todos los usuarios menos el admin*/
    public function index()
    {
        //$usuarios = \App\TecUserInsp::where('tipo_user', '!=', 'c')->get();
        $usuarios = \App\TecUserInsp::where('uid', '!=', 1)->get();

        $users = DB::select(
            "SELECT uid, user, password FROM tecprecinc_user_insp WHERE uid = ANY 
            (SELECT uid FROM tec_user_insp 
                WHERE uid <> 1 )"
            );

        for ($i=0; $i <count($usuarios) ; $i++) { 
            for ($j=0; $j <count($users) ; $j++) { 
                if($usuarios[$i]->uid == $users[$j]->uid){
                    $usuarios[$i]->user = $users[$j]->user;
                    //$usuarios[$i]->password = $users[$j]->password;
                }
            }
        }

        return response()->json(['status' => 'ok',
                                'usuarios'=> $usuarios], 200);
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
        // Listado de campos recibidos teóricamente.
        $user=$request->input('user'); //requerido
        $password=md5($request->input('password')); //requerido
        $tipo_user=$request->input('tipo_user'); //requerido
        $nombre=$request->input('nombre');
        $telefono=$request->input('telefono');
        $correo=$request->input('correo');
        $firma=$request->input('firma');
        
        /*Primero creo una instancia en la tabla tecprecinc_user_insp*/
        $tec_user = new \App\Tec_user;
        $tec_user->user = $user;
        $tec_user->password = $password;

        if($tec_user->save()){
           $uid = $tec_user->uid;

           /*Creo la instancia para la tabla tec_user_insp*/
           $tec_user_insp = new \App\TecUserInsp;
           $tec_user_insp->uid = $uid;
           $tec_user_insp->tipo_user = $tipo_user;

           if ($nombre) {
               $tec_user_insp->nombre = $nombre;
           }
           if ($telefono) {
               $tec_user_insp->telefono = $telefono;
           }
           if ($correo) {
               $tec_user_insp->correo = $correo;
           }
           if ($firma) {
               $tec_user_insp->firma = $firma;
           }
           
           
           if ($tec_user_insp->save()) {
               return response()->json(['status'=>'ok'], 200);
           }else{
                return response()->json(['error'=>'No se pudo crear el usuario en la tabla tec_user_insp.'], 500);
           }

        }else{
            return response()->json(['error'=>'No se pudo crear el usuario en la tabla tecprecinc_user_insp.'], 500);
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
    public function edit(Request $request, $uid)
    {
        $tec_user = \App\Tec_user::find($uid);

        if (empty($tec_user)) {
            return response()->json(['error'=>'No se encuntra un usuario con ese codigo en la tabla tecprecinc_user_insp.',
                'uid' => $uid],404);
        }

        $tec_user_insp = \App\TecUserInsp::find($uid);

        if (empty($tec_user_insp)) {
            return response()->json(['error'=>'No se encuntra un usuario con ese codigo en la tabla tec_user_insp.',
                'uid' => $uid],404);
        }


        //return $request->input('nombre');
        // Listado de campos recibidos teóricamente.
        $user=$request->input('user');
        $password=$request->input('password');
        $tipo_user=$request->input('tipo_user');
        $nombre=$request->input('nombre');
        $telefono=$request->input('telefono');
        $correo=$request->input('correo');
        $firma=$request->input('firma');

        if ($password) {
            $password = md5($password);
        }

        
        if($user || $password){
            if($user){
                $tec_user->user=$user;
            }
            if ($password) {
                $tec_user->password=$password;
            }

            if($tec_user->save()){
               if(!$tipo_user && !$nombre && !$telefono && !$correo && !$firma){
                    return response()->json(['status'=>'ok-1'], 200);
               }

            }else{
                return response()->json(['error'=>'No se pudo actualizar el usuario en la tabla tecprecinc_user_insp.'], 500);
            } 
        }

       $tec_user_insp->tipo_user = $tipo_user;
       $tec_user_insp->nombre = $nombre;
       $tec_user_insp->telefono = $telefono;
       $tec_user_insp->correo = $correo;
       $tec_user_insp->firma = $firma;

       if ($tec_user_insp->save()) {
           return response()->json(['status'=>'ok-2'], 200);
       }else{
            return response()->json(['error'=>'No se pudo actualizar el usuario en la tabla tec_user_insp.'], 500);
       }



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
    public function destroy($uid)
    {
        $tec_user = \App\Tec_user::find($uid);

        if (empty($tec_user)) {
            return response()->json(['error'=>'No se encuntra un usuario con ese codigo en la tabla tecprecinc_user_insp.',
                'uid' => $uid],404);
        }

        $tec_user_insp = \App\TecUserInsp::find($uid);

        if (empty($tec_user_insp)) {
            return response()->json(['error'=>'No se encuntra un usuario con ese codigo en la tabla tec_user_insp.',
                'uid' => $uid],404);
        }

        if ($tec_user->delete()) {
            if ($tec_user_insp->delete()) {
                return response()->json(['status'=>'ok'], 200);
            }
            else{
               return response()->json(['error'=>'No se pudo eliminar el usuario en la tabla tec_user_insp.'], 500); 
            }
        }
        else{
            return response()->json(['error'=>'No se pudo eliminar el usuario en la tabla tecprecinc_user_insp.'], 500);
        }
    }
}
