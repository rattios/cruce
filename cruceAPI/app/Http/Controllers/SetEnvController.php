<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;

class SetEnvController extends Controller
{

    public function setEnv(Request $request)
    {
        $data = $request->all();

        $rules = array(
            'DB_DATABASE' => 'required',
            'DB_USERNAME'=>'required',
            'DB_PASSWORD'=>'required'
            );

        $validator = Validator::make($data, $rules);

        if ($validator->fails())
        {

            return Redirect::back()->withErrors($validator->messages())->withInput();
        }

        $DB_DATABASE = $request->input('DB_DATABASE');
        $DB_USERNAME = $request->input('DB_USERNAME');
        $DB_PASSWORD = $request->input('DB_PASSWORD');

        //return response()->json(['DB_DATABASE'=>$DB_DATABASE, 'DB_USERNAME'=>$DB_USERNAME, 'DB_PASSWORD'=>$DB_PASSWORD ], 200);

        $app = app_path();
        $precadena=substr($app,0,strlen($app)-3);
        $envFile=$precadena.'.env';

        $str = file_get_contents($envFile);
        $oldValue_database = env('DB_DATABASE');
        $oldValue_username = env('DB_USERNAME');
        $oldValue_password = env('DB_PASSWORD');

        $str = str_replace("DB_DATABASE={$oldValue_database}", "DB_DATABASE=".$DB_DATABASE, $str);
        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);

        $str = str_replace("DB_USERNAME={$oldValue_username}", "DB_USERNAME=".$DB_USERNAME, $str);
        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);

        $str = str_replace("DB_PASSWORD={$oldValue_password}", "DB_PASSWORD=".$DB_PASSWORD, $str);
        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);

        return response()->json(['status'=>'ok'], 200);
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
        //
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
