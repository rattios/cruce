<?php
namespace App\Http\Controllers;
use Hash;
use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Redirect;

class LoginController extends Controller
{
    public function loginLaravel(Request $request)
    {

        $data = $request->all();

        $rules = array(
            'user' => 'required',
            'password'=>'required'
            );

        $validator = Validator::make($data, $rules);

        if ($validator->fails())
        {

            return Redirect::back()->withErrors($validator->messages())->withInput();
        }


        $user = $request->input('user');
        $password = $request->input('password');

        if ($user == 'indicadores' && $password == 'indicadores2018') {
            return view('variables');
        }else{
            return view('welcome');
        }
    }

    public function loginWeb(Request $request)
    {
        $credentials = $request->only('user', 'password');
        $token = null;
        $user = null;
        try {
            $user = User::where('user', $request->input('user'))->first();
            if (empty($user)) {
                return response()->json(['error' => 'User inválido'], 401);
            }
            if (!$token = JWTAuth::attempt($credentials)) {
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
                'user' => $user
            ]);
    }
}