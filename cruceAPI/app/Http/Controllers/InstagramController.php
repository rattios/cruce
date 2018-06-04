<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InstagramController extends Controller
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
    public function store(Request $request)
    {
                
        // Primero comprobaremos si estamos recibiendo todos los campos.
        if ( !$request->input('id_facebook') ||
            !$request->input('email'))
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['error'=>'Faltan datos necesarios para el proceso de alta.'],422);
        }

        //Comprobamos si existe un registro con las credenciales id_facebook y email
        $facebook = \App\Facebook::where('email', $request->input('email'))->first();
        //return $facebook;
        if(count($facebook)!=0){
           $facebook->access_token = $request->input('access_token');
           $facebook->data = $request->input('data');
           //return $facebook;
           if ($facebook->save()) {
                return response()->json(['message'=>'Facebook actualizado con éxito.',
                    'facebook'=>$facebook], 200);
            }else{
                return response()->json(['error'=>'Error al actualizar el facebook.'], 500);
            }
        }
        //return $request->all();
        $nuevoFacebook=new \App\Facebook;
        $nuevoFacebook->access_token= $request->input('access_token');
        $nuevoFacebook->id_facebook= $request->input('id_facebook');
        $nuevoFacebook->email= $request->input('email');
        $nuevoFacebook->data= 'a';
        $nuevoFacebook->nombre= $request->input('nombre');
        /*$nuevoFacebook=new \App\Facebook;
        $nuevoFacebook->access_token= 'asdasd';
        $nuevoFacebook->id_facebook= 'asd';
        $nuevoFacebook->email= 'as';
        $nuevoFacebook->data= 'a';
        $nuevoFacebook->nombre= 'asdads';*/
        //return $nuevoFacebook;
        if ($nuevoFacebook->save()) {
           return response()->json(['message'=>'Nuevo facebook registrado.',
             'facebook'=>$nuevoFacebook], 200);
        }else{
            return response()->json(['error'=>'Error al registrar el nuevo facebook.'], 500);
        }
        
        /*
        if($nuevoFacebook=\App\Facebook::create($request->all())){
           return response()->json(['message'=>'Nuevo facebook registrado.',
             'facebook'=>$nuevoFacebook], 200);
        }else{
            return response()->json(['error'=>'Error al registrar el nuevo facebook.'], 500);
        }*/
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = \App\Instagram::where('id',$id)->first();

       $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://api.instagram.com/oauth/access_token");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                    "client_id=876f8d74735b4399ab0b7ece2e08262f&client_secret=c05895490ef04fef928cf39126e814ac&grant_type=authorization_code&redirect_uri=http://vivomedia.com.ar/indicadores/instagram&code=".$book->code);


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);






        $server_output = curl_exec ($ch);
        $server_output = json_decode($server_output);
        //return $server_output->access_token;
        $newtoken= $server_output->access_token;

        $book->access_token=$newtoken;

        if($book->save()){
            return $book;
        }else{
            return $this->response->error('could_not_update_instagram_code', 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
       //$currentUser = JWTAuth::parseToken()->authenticate();

        //if($currentUser){
            $book = \App\Instagram::all();
        //}
        
        if(!$book)
            throw new NotFoundHttpException;
        for ($i=0; $i < count($book); $i++) { 
            $book[$i]->fill($request->all());

            if($book[$i]->save()){
                //return $book;
            }else{
                return $this->response->error('could_not_update_instagram_code', 500);
            }
        }
        return $book;
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
       //$currentUser = JWTAuth::parseToken()->authenticate();

        //if($currentUser){
            $book = \App\Instagram::where('id',$id)->first();
        //}
        //$book = $currentUser->destinos()->find($id);
        if(!$book)
            throw new NotFoundHttpException;

        $book->fill($request->all());

        if($book->save())
            return $book;
        else
            return $this->response->error('could_not_update_book', 500);
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
