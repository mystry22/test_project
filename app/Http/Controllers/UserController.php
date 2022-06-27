<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Auth;


class UserController extends Controller
{

    
    protected function returnToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl')
        ]);
    }

    public function get_user_id(){
        $user = auth()->user()->id;
        return response()->json($user);
    }
    
    public function create_user(Request $request){
        //Assume user data validation has been validated

        //get user request body
        $email = $request['email'];
        $password = $request['password'];
        $full_name = $request['full_name'];

        //get user details
        $user = User::create([
            'full_name'=> $full_name,
            'email'=>$email,
            'password'=>bcrypt($password)
        ]);

        if(!$user){
            return response()->json(['msg'=>'Error Creating user'],400);

        }
            //log user in and generate a token
        $cred = ['email'=>$email, 'password'=>$password];
        $token = auth()->attempt($cred);
        if(!$token){
            return response()->json(['msg'=>'Error Creating user'],400);

        }

        return response()->json(['msg'=>'New User Created',
                                'token'=> $token],200);

    }

    public function login(Request $request){
        //assume validated

        $cred = ['email'=>$request['email'],
                 'password'=> $request['password']];
        $token = auth()->attempt($cred);

        if(!$token){
            return response()->json(['msg'=>'Invalid User'],400);
        }

        return response()->json(['token'=> $token],200);
        
    }


}
