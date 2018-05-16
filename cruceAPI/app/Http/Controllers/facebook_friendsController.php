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
    public function createFriends()
    {
        //usuario, email, facebook_id

        for ($i=1; $i < 101; $i++) { 
            
            $nuevoFacebook=new \App\Facebook_friends;
            $nuevoFacebook->usuario= 'usuario'.strval($i);
            $nuevoFacebook->email= 'usuario'.strval($i).'@correo.com';
            $nuevoFacebook->img= 'http://vivomedia.com.ar/assets/'.rand(1,7).'.png';
            $nuevoFacebook->facebook_id= rand(0,1000000000);

            if ($nuevoFacebook->save()) {
               
            }else{
                return response()->json(['error'=>'Error al registrar el nuevo facebook.'], 500);
            }
        }

        return response()->json(['message'=>'Nuevo facebook registrado.',
                 'facebook'=>$nuevoFacebook], 200);
    }

    public function facebookFriends(Request $request)
    {
        $nuevoFacebook= \App\Facebook_friends::all();

        return response()->json(['facebook'=>$nuevoFacebook], 200);
    }

    public function facebookPosts(Request $request)
    {
        $usuarios= \App\Facebook_friends::all();

        for ($i=0; $i < 20; $i++) { 
            $Facebook_friends=new \App\Facebook_post;
            $aux=rand(0,99);
            $from='{"name": "'.$usuarios[$aux]->usuario.'", "id": "'.rand(0,1000000000).'"}';
            $Facebook_friends->usuario=$from;
            $Facebook_friends->texto= 'Lorem Ipsum es un post en facebook de relleno '.strval($i);
            $Facebook_friends->post_id= rand(0,1000000000);

            if ($Facebook_friends->save()) {
               
            }else{
                return response()->json(['error'=>'Error al registrar el nuevo facebook.'], 500);
            }
        }
        return \App\Facebook_post::all();
    }

    public function facebook_comments(Request $request)
    {
        $post=\App\Facebook_post::all();
        for ($i=0; $i < count($post); $i++) { 
            $post[$i]->from=json_decode($post[$i]->usuario);
            $post[$i]->message=$post[$i]->texto;
        }
        //message usuario comments_id facebook_post_id Facebook_comments
        for ($i=0; $i < count($post); $i++) { 
            $count=rand(0,15);
            for ($j=0; $j < $count; $j++) {
                $nuevoFacebook= \App\Facebook_friends::all(); 
                $aux=rand(0,99);
                $Facebook_comments=new \App\Facebook_comments;
                $Facebook_comments->message='comentario '.$j.' Lorem Ipsum de prueba. ';
                $from='{"name": "'.$nuevoFacebook[$aux]->usuario.'", "id": "'.$nuevoFacebook[$aux]->facebook_id.'"}';
                $Facebook_comments->usuario=$from;
                $Facebook_comments->comments_id=rand(0,1000000000);
                $Facebook_comments->facebook_post_id=$post[$i]->post_id;

                if ($Facebook_comments->save()) {
               
            }else{
                return response()->json(['error'=>'Error al registrar el nuevo facebook.'], 500);
            }
            }
        }
        return 1;
    }
    
    public function facebook_likes(Request $request)
    {
        // data    like_id facebook_post_id Facebook_likes
        $post=\App\Facebook_post::all();
        for ($i=0; $i < count($post); $i++) { 
            $count=rand(0,15);
            for ($j=0; $j < $count; $j++) {
                $nuevoFacebook= \App\Facebook_friends::all(); 
                $aux=rand(0,99);
                $Facebook_likes=new \App\Facebook_likes;
                $Facebook_likes->data=$nuevoFacebook[$aux]->usuario;
                $Facebook_likes->like_id=rand(0,1000000000);
                $Facebook_likes->facebook_post_id=$post[$i]->post_id;

                if ($Facebook_likes->save()) {
               
                }else{
                    return response()->json(['error'=>'Error al registrar el nuevo facebook.'], 500);
                }
            }
        }
        return 1;
    }
    public function posts(Request $request)
    {
        $post=\App\Facebook_post::all();
        $Facebook_comments= \App\Facebook_comments::all();
        $Facebook_likes= \App\Facebook_likes::all();

        for ($i=0; $i < count($post); $i++) { 
            $post[$i]->from=json_decode($post[$i]->usuario);
            $post[$i]->message=$post[$i]->texto;
        }

        for ($i=0; $i < count($Facebook_comments); $i++) { 
            $Facebook_comments[$i]->from=json_decode($Facebook_comments[$i]->usuario);
        }

        for ($i=0; $i < count($Facebook_likes); $i++) { 
            $Facebook_likes[$i]->name=$Facebook_likes[$i]->data;
        }

        $likes=[];
        
        for ($i=0; $i < count($post); $i++) { 
            for ($j=0; $j < count($Facebook_likes); $j++) { 
                if ($post[$i]->post_id==$Facebook_likes[$j]->facebook_post_id) {
                    array_push($likes,$Facebook_likes[$j]);
                }
            }
            $post[$i]->likes=array('data' => $likes);
            $likes=[];
        }
        
        $comments=[];

        for ($i=0; $i < count($post); $i++) { 
            for ($j=0; $j < count($Facebook_comments); $j++) { 
                if ($post[$i]->post_id==$Facebook_comments[$j]->facebook_post_id) {
                    array_push($comments,$Facebook_comments[$j]);
                }
            }
            $post[$i]->comments=array('data' => $comments);
            $comments=[];
        }

        $Facebook_friends= \App\Facebook_friends::all();

        $final= array('data' => $post);
        return response()->json(['posts'=>$final,'Facebook_friends'=>$Facebook_friends], 200);
    }

    public function twitter_followers(Request $request)
    {
        //screen_name name    location    email   twitter_id twitter_followers
        for ($i=1; $i < 51; $i++) { 
            
            $Twitter_followers=new \App\Twitter_followers;
            $Twitter_followers->screen_name= '@usuario'.strval($i);
            $Twitter_followers->name= 'usuario '.strval($i);
            $Twitter_followers->location= 'Dirección de prueba '.strval($i);
            $Twitter_followers->email= 'usuario'.strval($i).'@correo.com';
            $Twitter_followers->img= 'http://vivomedia.com.ar/assets/'.rand(1,7).'.png';
            $Twitter_followers->twitter_id= rand(0,1000000000);

            if ($Twitter_followers->save()) {
               
            }else{
                return response()->json(['error'=>'Error al registrar el nuevo twitter.'], 500);
            }
        }

        return response()->json(['message'=>'Nuevo facebook registrado.',
                 'facebook'=>$Twitter_followers], 200);
    }

    public function twitter_tweets(Request $request)
    {
        //entities  favorite_count  retweet_count   text    tweet_id hashtags urls user_mentions
        //$count=rand(0,15);
        $count=15;
        for ($i=0; $i < $count; $i++) {
            
            $Twitter_tweets=new \App\Twitter_tweets;
            $hashtags=[];//{text: "14May", indices: Array(2)}
            $countHashtags=rand(0,2);
            for ($j=0; $j < count($countHashtags); $j++) { 
                $arrayName = array('text' => 'hashtags'.rand(0,1));
                array_push($hashtags,$arrayName);
            }
            $urls=[]; //{url: "https://t.co/JH4AKngzox", expanded_url: "http://www.rattios.com", display_url: "rattios.com", indices: Array(2)}
            $counturls=rand(0,1);
            for ($k=0; $k < count($counturls); $k++) { 
                $arrayName = array('url' => 'url '.strval(rand(0,1)).'.com');
                array_push($urls,$arrayName);
            }
            $user_mentions=[];//{screen_name: "erangeld", name: "Edrangel", id: 429501180, id_str: "429501180", indices: Array(2)}
            $countUser_mentions=rand(0,5);
            for ($q=0; $q < count($countUser_mentions); $q++) { 
                $nUser=rand(1,50);
                $arrayName = array('screen_name' => 'usuario '.$nUser,'screen_name' => 'name '.$nUser);
                array_push($user_mentions,$arrayName);
            }
            $entities='{
                "hashtags":'.json_encode($hashtags).',
                "urls":'.json_encode($urls).',
                "user_mentions":'.json_encode($user_mentions).'
            }';

            $Twitter_tweets->entities= $entities;
            $Twitter_tweets->favorite_count= rand(0,15);
            $Twitter_tweets->retweet_count= rand(0,10);
            $Twitter_tweets->text= 'Tweet Lorem Ipsum de prueba'.strval($i);
            $Twitter_tweets->tweet_id= rand(0,1000000000);

            if ($Twitter_tweets->save()) {
               
            }else{
                return response()->json(['error'=>'Error al registrar el nuevo facebook.'], 500);
            }
        }

        return response()->json(['message'=>'Nuevo facebook registrado.',
                 'twitter'=>1], 200);
    }

    public function twitter_tweets_other(Request $request)
    {
        //entities  favorite_count  retweet_count   text    tweet_id hashtags urls user_mentions
        //$count=rand(0,15);
        $count=15;
        for ($i=0; $i < $count; $i++) {
            
            $Twitter_tweets=new \App\twitter_tweets_other;
            $hashtags=[];//{text: "14May", indices: Array(2)}
            $countHashtags=rand(0,2);
            for ($j=0; $j < count($countHashtags); $j++) { 
                $arrayName = array('text' => 'hashtags'.rand(0,1));
                array_push($hashtags,$arrayName);
            }
            $urls=[]; //{url: "https://t.co/JH4AKngzox", expanded_url: "http://www.rattios.com", display_url: "rattios.com", indices: Array(2)}
            $counturls=rand(0,1);
            for ($k=0; $k < count($counturls); $k++) { 
                $arrayName = array('url' => 'url '.strval(rand(0,1)).'.com');
                array_push($urls,$arrayName);
            }
            $user_mentions=[];//{screen_name: "erangeld", name: "Edrangel", id: 429501180, id_str: "429501180", indices: Array(2)}
            $countUser_mentions=rand(0,5);
            for ($q=0; $q < count($countUser_mentions); $q++) { 
                $nUser=rand(1,50);
                $arrayName = array('screen_name' => 'usuario '.$nUser,'screen_name' => 'name '.$nUser);
                array_push($user_mentions,$arrayName);
            }
            $entities='{
                "hashtags":'.json_encode($hashtags).',
                "urls":'.json_encode($urls).',
                "user_mentions":'.json_encode($user_mentions).'
            }';

            $Twitter_tweets->entities= $entities;
            $Twitter_tweets->favorite_count= rand(0,15);
            $Twitter_tweets->retweet_count= rand(0,10);
            $Twitter_tweets->text= 'Tweet Lorem Ipsum de prueba'.strval($i);
            $Twitter_tweets->tweet_id= rand(0,1000000000);

            if ($Twitter_tweets->save()) {
               
            }else{
                return response()->json(['error'=>'Error al registrar el nuevo facebook.'], 500);
            }
        }

        return response()->json(['message'=>'Nuevo facebook registrado.',
                 'twitter'=>1], 200);
    }

    public function getTeewts(Request $request)
    {
        $Twitter_followers= \App\Twitter_followers::all();
        for ($i=0; $i < count($Twitter_followers); $i++) { 
            $Twitter_followers[$i]->profile_image_url=$Twitter_followers[$i]->img;
        }

        $getTeewts= \App\Twitter_tweets::all();
        for ($i=0; $i < count($getTeewts); $i++) { 
            $getTeewts[$i]->entities=json_decode($getTeewts[$i]->entities);
            $getTeewts[$i]->user=$Twitter_followers[rand(0,49)];
        }
        $timeline= \App\Twitter_tweets_other::all();
        for ($i=0; $i < count($timeline); $i++) { 
            $timeline[$i]->entities=json_decode($timeline[$i]->entities);
            $timeline[$i]->user=$Twitter_followers[rand(0,49)];
        }
        $mentions= array('mentions' => $getTeewts);//mentions timeline
        $timeline= array('timeline' => $timeline);
        $users= array('users' => $Twitter_followers);
        return response()->json(['mentions'=>$mentions,'timeline' => $timeline,'data' => $users], 200);
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
