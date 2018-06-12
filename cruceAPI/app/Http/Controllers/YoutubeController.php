<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Twitter;
use File;

class YoutubeController extends Controller
{   
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function seguidores($token)
    {
        $chSeguidores = curl_init();

        curl_setopt($chSeguidores, CURLOPT_URL,"https://www.googleapis.com/youtube/v3/subscriptions?part=id%2C+snippet%2C+contentDetails&mySubscribers=true&key=AIzaSyCOmV5A4CuZQDsCmE5vKUIjkC0cbG5JHw0");
        
        curl_setopt($chSeguidores, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chSeguidores, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer '.$token
            ));

        $salidaSeguidores = curl_exec($chSeguidores);
        //return $salidaComentario;
        $salidaSeguidores = json_decode($salidaSeguidores);
        $s=$salidaSeguidores->items;
        $salida=[];
        for ($i=0; $i < count($s); $i++) { 
            array_push($salida,array(
                'channel_id'=>$s[$i]->snippet->channelId,
                'seguidor'=>$this->info_canal($s[$i]->snippet->channelId,$token),
            ));
            //return $c[$i]->snippet->topLevelComment->snippet->textDisplay;
        }
        return $salida;
    }

    public function info_canal($id,$token)
    {
        $chSeguidores = curl_init();

        curl_setopt($chSeguidores, CURLOPT_URL,"https://www.googleapis.com/youtube/v3/channels?part=id%2C+snippet%2C+brandingSettings%2C+contentDetails%2C+invideoPromotion%2C+statistics%2C+topicDetails&id=".$id."&key=AIzaSyCOmV5A4CuZQDsCmE5vKUIjkC0cbG5JHw0");
        
        curl_setopt($chSeguidores, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chSeguidores, CURLOPT_HTTPHEADER, array(
            //'Authorization: Bearer '.$token
            ));

        $salidaSeguidores = curl_exec($chSeguidores);
        //return $salidaComentario;
        $salidaSeguidores = json_decode($salidaSeguidores);
        $customUrl='';
        if ( property_exists($salidaSeguidores->items[0]->snippet, 'customUrl')) {
                $customUrl=$salidaSeguidores->items[0]->snippet->customUrl;
        }
        $s=array(
            'nombre' => $salidaSeguidores->items[0]->snippet->title,
            'usuario' => $customUrl
        );
        
        return $s;
    }

    public function get_comentarios($id,$token)
    {
        //return $token;
        $chComentarios = curl_init();

            curl_setopt($chComentarios, CURLOPT_URL,"https://www.googleapis.com/youtube/v3/commentThreads?part=snippet&maxResults=50&textFormat=plainText&videoId=".$id."&key=AIzaSyCOmV5A4CuZQDsCmE5vKUIjkC0cbG5JHw0");
            
            curl_setopt($chComentarios, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chComentarios, CURLOPT_HTTPHEADER, array(
                //'Authorization: Bearer '.$token
                ));

            $salidaComentario = curl_exec($chComentarios);
            //return $salidaComentario;
            $salidaComentario = json_decode($salidaComentario);
            $c=$salidaComentario->items;
            $comentarios=[];
            for ($i=0; $i < count($c); $i++) { 
                array_push($comentarios,array(
                    'channel_id'=>$c[$i]->snippet->topLevelComment->snippet->authorChannelId->value,
                    'autor'=>$c[$i]->snippet->topLevelComment->snippet->authorDisplayName,
                    'img'=>$c[$i]->snippet->topLevelComment->snippet->authorProfileImageUrl,
                    'created_at'=>$c[$i]->snippet->topLevelComment->snippet->publishedAt,
                    'texto'=>$c[$i]->snippet->topLevelComment->snippet->textOriginal
                ));
                //return $c[$i]->snippet->topLevelComment->snippet->textDisplay;
            }
            return $comentarios;
    }

    public function index(Request $request)
    {
        set_time_limit(300);
        $chChannel = curl_init();

        $token=$request->token;
        //return $token;
        curl_setopt($chChannel, CURLOPT_URL,"https://www.googleapis.com/youtube/v3/channels?part=id%2C+snippet%2C+brandingSettings%2C+contentDetails%2C+invideoPromotion%2C+statistics%2C+topicDetails&mine=true&key=AIzaSyCOmV5A4CuZQDsCmE5vKUIjkC0cbG5JHw0");
        
        curl_setopt($chChannel, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chChannel, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer '.$token
            ));

        $server_output = curl_exec ($chChannel);
        //return response()->json(['twitter'=>$server_output], 200);
        $server_output = json_decode($server_output);
        
        $uploads=$server_output->items[0]->contentDetails->relatedPlaylists->uploads;

        $chLista = curl_init();

        curl_setopt($chLista, CURLOPT_URL,"https://www.googleapis.com/youtube/v3/playlistItems?part=id%2Csnippet%2Cstatus&maxResults=50&playlistId=".$uploads."&key=AIzaSyCOmV5A4CuZQDsCmE5vKUIjkC0cbG5JHw0");
        
        curl_setopt($chLista, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chLista, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer '.$token
            ));

        $server_output = curl_exec($chLista);
        $server_output = json_decode($server_output);
        $salida_lista=$server_output->items;

        $videos=[];
        $idsVideos=[];
        for ($i=0; $i < count($salida_lista); $i++) { 

            $chVideo = curl_init();

            curl_setopt($chVideo, CURLOPT_URL,"https://www.googleapis.com/youtube/v3/videos?part=id%2C+snippet%2C+contentDetails%2C+fileDetails%2C+player%2C+processingDetails%2C+recordingDetails%2C+statistics%2C+status%2C+suggestions%2C+topicDetails&id=".$salida_lista[$i]->snippet->resourceId->videoId."&key=AIzaSyCOmV5A4CuZQDsCmE5vKUIjkC0cbG5JHw0");
            
            curl_setopt($chVideo, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chVideo, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$token
                ));

            $salidaVideo = curl_exec($chVideo);
            $salidaVideo = json_decode($salidaVideo);
            
            array_push($videos,array(
                'id'=>$salida_lista[$i]->snippet->resourceId->videoId,
                'url'=>'https://www.youtube.com/watch?v='.$salida_lista[$i]->snippet->resourceId->videoId,
                'created_at'=>$salida_lista[$i]->snippet->publishedAt,
                'thumbnails'=>$salida_lista[$i]->snippet->thumbnails->default->url,
                'likes'=>$salidaVideo->items[0]->statistics->likeCount,
                'ncomentarios'=>$salidaVideo->items[0]->statistics->commentCount,
                'vistas'=>$salidaVideo->items[0]->statistics->viewCount,
                'comentarios'=>$this->get_comentarios($salida_lista[$i]->snippet->resourceId->videoId,$token),
            ));
        }

        $subscritores=$this->seguidores($token);
       
        return response()->json([
            'videos'=>$videos,
            'subscritores'=>$subscritores
        ], 200);
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
