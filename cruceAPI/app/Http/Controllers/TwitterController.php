<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use OAuth;

class TwitterController extends Controller
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

    public function datos()
    {

        $code = 'JOoRgm6L3h5gUNPOeVnS9MYuO4I6I0MIhxAKstXGVeevW3XHRi';
        $oauth_verifier = 'JOoRgm6L3h5gUNPOeVnS9MYuO4I6I0MIhxAKstXGVeevW3XHRi';

        $twitterService = OAuth::consumer( 'Twitter' );
        if (true)
        {
            $token = $twitterService->getStorage()->retrieveAccessToken('Twitter');
            $twitterService->requestAccessToken( $code, $oauth_verifier, $token->getRequestTokenSecret() );
            $result = json_decode( $twitterService->request( 'account/verify_credentials.json') );
            
            response()->json(['result'=>$result], 200);
        } else
        {
            $token = $twitterService->requestRequestToken();
            $url = $twitterService->getAuthorizationUri(['oauth_token' => $token->getRequestToken()]);
            return Redirect::to((string)$url);
        }
       /* $twitterService = OAuth::consumer('twitter');
        $twitterService = OAuth::consumer('ZTgriirRyWh7A59DCbRxzTybW', 'JOoRgm6L3h5gUNPOeVnS9MYuO4I6I0MIhxAKstXGVeevW3XHRi', '429501180-mBNefCsdCKcUvpWgAbYz60eGZmhgPGPKWQTyjStB');
        return response()->json(['twitter'=>$twitterService], 200);
        $token = $twitterService->getStorage()->retrieveAccessToken('twitter');
        return response()->json(['twitter'=>$twitterService,'token'=>$token], 200);
        $twitterService->requestAccessToken(
            \Input::get('oauth_token'),
            \Input::get('oauth_verifier'),
            $token->getRequestTokenSecret()
        );
        $result = json_decode($twitterService->request('account/verify_credentials.json'));
        return $twitterService;*/
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
        //return $request->all();
        // Primero comprobaremos si estamos recibiendo todos los campos.
       
        //Comprobamos si existe un registro con las credenciales id_facebook y email
        $facebook = \App\Twitter::where('email', $request->input('email'))->first();
        //return $facebook;
        if(count($facebook)!=0){
           $facebook->access_token = $request->input('access_token');
           $facebook->secret = $request->input('secret');
           //return $facebook;
           if ($facebook->save()) {
                return response()->json(['message'=>'twitter actualizado con éxito.',
                    'facebook'=>$facebook], 200);
            }else{
                return response()->json(['error'=>'Error al actualizar el twitter.'], 500);
            }
        }
        //return $request->all();
        //'id_twitter', 'email', 'display_name', 'access_token', 'secret'
        $nuevoFacebook=new \App\Twitter;
        $nuevoFacebook->access_token= $request->input('access_token');
        $nuevoFacebook->id_twitter= $request->input('id_twitter');
        $nuevoFacebook->email= $request->input('email');
        $nuevoFacebook->secret= $request->input('secret');
        $nuevoFacebook->display_name= $request->input('display_name');
        //return $nuevoFacebook;
        /*$nuevoFacebook=new \App\Facebook;
        $nuevoFacebook->access_token= 'asdasd';
        $nuevoFacebook->id_facebook= 'asd';
        $nuevoFacebook->email= 'as';
        $nuevoFacebook->data= 'a';
        $nuevoFacebook->nombre= 'asdads';*/
        //return $nuevoFacebook;
        if ($nuevoFacebook->save()) {
           return response()->json(['message'=>'Nuevo twitter registrado.',
             'twitter'=>$nuevoFacebook], 200);
        }else{
            return response()->json(['error'=>'Error al registrar el nuevo twitter.'], 500);
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
}
