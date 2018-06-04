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
    public function index()
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://www.googleapis.com/youtube/v3/channels?part=id%2C+snippet%2C+brandingSettings%2C+contentDetails%2C+invideoPromotion%2C+statistics%2C+topicDetails&mine=true&key=AIzaSyCOmV5A4CuZQDsCmE5vKUIjkC0cbG5JHw0");
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ya29.GlvQBZxlzc8P_nyoz4guFT1-7QJ3Mm_yH01ScrdIyKOBwdPgSzfGxSk7wXNOAAYb3gZrmyA1NT2uZQ_r5I5lNfabjc2j6SlI23ht4XwQuKm5G3JiqgERC4Jcb2Ec'
            ));

        $server_output = curl_exec ($ch);
        $server_output = json_decode($server_output);

        return response()->json(['twitter'=>$server_output], 200);
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
