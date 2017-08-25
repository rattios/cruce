<?php

namespace App\Http\Controllers;

use App\User;
use App\Tec_user;
use App\TecUserInsp;
use Illuminate\Http\Request;
//use Tymon\JWTAuth\JWTAuth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            $token = JWTAuth::attempt($credentials);

            if(!$token) {
                throw new AccessDeniedHttpException();
            }

        } catch (JWTException $e) {
            throw new HttpException(500);
        }

        return response()
            ->json([
                'status' => 'ok',
                'token' => $token
            ]);
    }

    public function userAuth(Request $request)
    {
        //$credentials = $request->only('user', 'password');
        $token = null;
        $user = null;

        try {
            $aux = md5($request->input('password'));

            $user = Tec_user::where('user', $request->input('user'))->first();
            if (empty($user)) {
                    return response()->json(['error' => 'invalid_credentials'], 401);
                }


            if($aux == $user->password){
                if (!$token = JWTAuth::fromUser($user)) {
                    return response()->json(['error' => 'invalid_credentials'], 401);
                }
            }
            else{
                return response()->json(['error' => 'invalid_credentials'], 401);
            }


            $user = JWTAuth::toUser($token);
        } catch (JWTException $ex) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token', 'user'));

        /*return response()
            ->json([
                'status' => 'ok',
                'token' => $token
            ]);*/
    }

    public function loginWeb(Request $request)
    {
        //$credentials = $request->only('user', 'password');
        $token = null;
        $user = null;
        $t_user=null;

        try {
            $aux = md5($request->input('password'));

            $user = Tec_user::where('user', $request->input('user'))->first();
            if (empty($user)) {
                    return response()->json(['error' => 'User inválido'], 401);
                }

            $t_user = TecUserInsp::where('uid', $user->uid)->first();
            if (empty($t_user)) {
                    return response()->json(['error' => 'Este usuario actualmente no tiene soporte.'], 401);
                }

            if($aux == $user->password){
                if ($user->tecuserinsp->tipo_user == 's' || $user->tecuserinsp->tipo_user == 'c') {
                    $token = JWTAuth::fromUser($user);
                }
                else{
                    return response()->json(['error' => 'Los operadores no pueden acceder al panel de administración.'], 401);
                }

            }
            else{
                return response()->json(['error' => 'Password inválido'], 401);
            }

            $user = JWTAuth::toUser($token);

        } catch (JWTException $ex) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        //return response()->json(compact('token', 'user'));

        return response()
            ->json([
                'token' => $token,
                'user' => $user,
                'info' => $t_user
            ]);
    }

    public function loginApp(Request $request)
    {
        //$credentials = $request->only('user', 'password');
        $token = null;
        $user = null;
        $t_user=null;

        try {
            $aux = md5($request->input('password'));

            $user = Tec_user::where('user', $request->input('user'))->first();
            if (empty($user)) {
                    return response()->json(['error' => 'User inválido'], 401);
                }

            $t_user = TecUserInsp::where('uid', $user->uid)->first();
            if (empty($t_user)) {
                    return response()->json(['error' => 'Este usuario actualmente no tiene soporte.'], 401);
                }

            if($aux == $user->password){
                if ($user->tecuserinsp->tipo_user == 'o') {
                        $token = JWTAuth::fromUser($user);               
                }
                else{
                    return response()->json(['error' => 'Para poder iniciar sesión debes estar registrado con el perfil de operador en Excalibur Inspecciones.'], 401);
                }

            }
            else{
                return response()->json(['error' => 'Password inválido'], 401);
            }

            $user = JWTAuth::toUser($token);

        } catch (JWTException $ex) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        //return response()->json(compact('token', 'user'));

        return response()
            ->json([
                'token' => $token,
                'user' => $user,
                'info' => $t_user
            ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        //return view('welcome');
        $input = $request->all();
        $user = JWTAuth::toUser($input['token']);
        return response()->json(['result' => $user]);
    }

    public function test2($id)
    {
    //-------------------------------
    //Prueba de relacion de TecMarcaExtintor con TecExtintor
    $tecextintores = \App\TecMarcaExtintor::find($id)->tecextintores;
    return response()->json(['result' => $tecextintores]);
    }

    public function test3($id)
    {
    //Prueba de relacion inversa
    $tecmarcaextintor = \App\TecExtintor::find($id)->tecmarcaextintor;
    return response()->json(['result' => $tecmarcaextintor]);
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
