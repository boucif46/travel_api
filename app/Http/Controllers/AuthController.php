<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Models\User;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function _construct(){
        $this->middleware('auth:api',['except'=>['login','register']]);
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(),
        [
            'name'=>'required',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|string|confirmed|min:6'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
        
        $user = User::create(
            [
                'name' => $request->name,
             'email' => $request->email,
             'password' =>Hash::make($request->password),
             ]

        );
        //return $this->login($request);

        // $token = JWTAuth::fromUser($user);

        
        
        // $user->jwt_token_expiration = now()->addDays(6);
        // $user->save();

        // return response()->json([
        //     'message'=>'User successfully registered',
        //     'user'=>$user,
        //     'tokenis'=>compact('token')
        // ],200);

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        
        $user = Auth::user();

        // $user = JWTAuth::authenticate($token);
        
        // $user->jwt_token_expiration = now()->addDays(6);
        // $user->save();


         return response()->json([
                 
                 'user'=>$user,
                 'tokenis'=>$token
             ],200);

    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        
        $user = Auth::user();

        // $user = JWTAuth::authenticate($token);
        
        // $user->jwt_token_expiration = now()->addDays(6);
        // $user->save();


         return response()->json([
                 
                 'user'=>$user,
                 'tokenis'=>$token
             ],200);
    }

    

 

    public function profile(){

        return response()->json(auth()->user());
    }

    public function logout(Request $request)
     {
         // Invalidate the user's token
         $request->user()->tokens()->delete();

         // return a response indicating successful logout
         return response()->json(['message' => 'Logged out successfully']);
     }
}
