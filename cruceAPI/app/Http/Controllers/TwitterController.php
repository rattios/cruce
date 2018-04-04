<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Twitter;
use File;

class TwitterController extends Controller
{   
    public function twitterUserTimeLine(Request $request)
    {   
        $datos = \App\Twitter::where('display_name', $request->input('display_name'))->first();
        
        $request_token = [
            'token'  => $datos->access_token,
            'secret' => $datos->secret,
        ];

        Twitter::reconfig($request_token);

        $data = Twitter::getUserTimeline(['count' => 10, 'format' => 'array']);
        return response()->json(['twitter'=>compact('data')], 200);
       // return view('twitter',compact('data'));
    }

    public function twitterFollowers(Request $request)
    {   
        $datos = \App\Twitter::where('display_name', $request->input('display_name'))->first();
        
        $request_token = [
            'token'  => $datos->access_token,
            'secret' => $datos->secret,
        ];

        Twitter::reconfig($request_token);

        $data = Twitter::getFriends(['count' => 10, 'format' => 'array']);
        return response()->json(['twitter'=>compact('data')], 200);
       // return view('twitter',compact('data'));
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function tweet(Request $request)
    {
        $this->validate($request, [
                'tweet' => 'required'
            ]);

        $newTwitte = ['status' => $request->tweet];

        
        if(!empty($request->images)){
            foreach ($request->images as $key => $value) {
                $uploaded_media = Twitter::uploadMedia(['media' => File::get($value->getRealPath())]);
                if(!empty($uploaded_media)){
                    $newTwitte['media_ids'][$uploaded_media->media_id_string] = $uploaded_media->media_id_string;
                }
            }
        }

        $twitter = Twitter::postTweet($newTwitte);

        
        return back();
    }
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
        //return $request->all();
        // Primero comprobaremos si estamos recibiendo todos los campos.
       
        //Comprobamos si existe un registro con las credenciales id_facebook y email
        $facebook = \App\Twitter::where('display_name', $request->input('display_name'))->first();
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
