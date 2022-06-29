<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //Get Auth ID
    private function get_user_id(){
        $user = Auth::id();
      
        return response()->json($user);
    }
    // Create new user route
    public function create_user(Request $request){
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|min:2|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

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
        $mail = ['email'=>$email];
        $token = $user->createToken('usertoken')->plainTextToken;
        $response = [
            'user'=> $mail,
            'token' => $token
        ];

        return response()->json($response , 201);
       

    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $cred = ['email'=>$request['email'],
                 'password'=> $request['password']];
        $user = User::where('email', $cred['email'])->first();

        if(!$user || !Hash::check($cred['password'], $user->password)){
            return response()->json(['msg'=> 'No user found'],401);
        }

        
        $email = ['email'=>$request['email']];
        $token = $user->createToken('usertoken')->plainTextToken;
        $response = [
            'user'=> $email,
            'token' => $token
        ];

        return response()->json($response , 201);
        
    }

    public function logout(Request $request){
        $user_id = self::get_user_id();
        $id = $user_id->original;
        $user->tokens()->where('id', $id)->delete();
        return response()->json(['msg' => 'Logged Out']);
    }

   


}
