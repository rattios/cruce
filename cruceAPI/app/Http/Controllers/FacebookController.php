<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FacebookController extends Controller
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

    public function storeFacebookPosts(Request $request)
    {
        set_time_limit(1000);

        $posts = $request->input('posts'); 

        $posts = json_decode($posts);


        for ($i=0; $i < count($posts); $i++) { 

            if (!$this->checkPostsExist($posts[$i]->id)) {

                if (property_exists($posts[$i], 'message')) {
                     $aux = $posts[$i]->message;
                 }else{
                    $aux = '';
                 } 

                $nuevoPost=\App\Facebook_post::create([
                    'usuario' => json_encode($posts[$i]->from),
                    'texto' => $aux,
                    'post_id' => $posts[$i]->id
                ]);

                if (property_exists($posts[$i], 'comments')) {
                    
                    $data = $posts[$i]->comments->data;

                    for ($j=0; $j < count($data) ; $j++) { 
                        if (property_exists($data[$j], 'id')) {
                            $nuevoComment=\App\Facebook_comments::create([
                                'message' => $data[$j]->message,
                                'usuario' => json_encode($data[$j]->from),
                                'comments_id' => $data[$j]->id,
                                'facebook_post_id' => $posts[$i]->id
                            ]);
                        }
                        
                    }
                }

                if (property_exists($posts[$i], 'likes')) {
                    
                    $data = $posts[$i]->likes->data;

                    for ($k=0; $k < count($data) ; $k++) { 
                        if (property_exists($data[$k], 'id')) {
                            $nuevoLike=\App\Facebook_likes::create([
                                'data' => $data[$k]->name,
                                'like_id' => $data[$k]->id,
                                'facebook_post_id' => $posts[$i]->id
                            ]);
                        }
                        
                    }
                }

            }else{

                if (property_exists($posts[$i], 'comments')) {
                    
                    $data = $posts[$i]->comments->data;

                    for ($j=0; $j < count($data) ; $j++) {

                        if (property_exists($data[$j], 'id')) {

                            if (!$this->checkCommentsExist($data[$j]->id, $posts[$i]->id)) {
                                $nuevoComment=\App\Facebook_comments::create([
                                    'message' => $data[$j]->message,
                                    'usuario' => json_encode($data[$j]->from),
                                    'comments_id' => $data[$j]->id,
                                    'facebook_post_id' => $posts[$i]->id
                                ]);
                            }

                        }
                    }
                }

                if (property_exists($posts[$i], 'likes')) {
                    
                    $data = $posts[$i]->likes->data;

                    for ($k=0; $k < count($data) ; $k++) { 

                        if (property_exists($data[$k], 'id')) {
                            if (!$this->checkLikesExist($data[$k]->id, $posts[$i]->id)) {
                                $nuevoLike=\App\Facebook_likes::create([
                                    'data' => $data[$k]->name,
                                    'like_id' => $data[$k]->id,
                                    'facebook_post_id' => $posts[$i]->id
                                ]);
                            }
                        }
                    }
                }


            }


            
        }
        

        return response()->json(['count'=>count($posts)], 200);
    }

    public function checkPostsExist($post_id)
    {
        $post = \App\Facebook_post::where('post_id', $post_id)->get();

        if (count($post)==0)
        {
            return false;
        }else{
            return true;
        }
    }

    public function checkCommentsExist($comments_id, $facebook_post_id)
    {
        $comment = \App\Facebook_comments::where('comments_id', $comments_id)
            ->where('facebook_post_id', $facebook_post_id)->get();

        if (count($comment)==0)
        {
            return false;
        }else{
            return true;
        }
    }

    public function checkLikesExist($like_id, $facebook_post_id)
    {
        $like = \App\Facebook_likes::where('like_id', $like_id)
            ->where('facebook_post_id', $facebook_post_id)->get();

        if (count($like)==0)
        {
            return false;
        }else{
            return true;
        }
    }

    public function storeFacebookClientes(Request $request)
    {
        set_time_limit(1000);

        $usuarios = $request->input('usuarios'); 

        $usuarios = json_decode($usuarios);

        for ($i=0; $i < count($usuarios); $i++) { 
            if (!$this->checkUsuariosExist($usuarios[$i]->facebook_id)) {
                $nuevoCliente=\App\Facebook_friends::create([
                    'usuario' => $usuarios[$i]->usuario,
                    'email' => '',
                    'img' => '',
                    'facebook_id' => $usuarios[$i]->facebook_id 
                ]);
            }
        }
        

        return response()->json(['count'=>count($usuarios)], 200);
    }

    public function checkUsuariosExist($facebook_id)
    {
        $usuario = \App\Facebook_friends::where('facebook_id', $facebook_id)->get();

        if (count($usuario)==0)
        {
            return false;
        }else{
            return true;
        }
    }

}
