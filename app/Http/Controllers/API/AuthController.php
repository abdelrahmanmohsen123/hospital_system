<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function createUser(StoreUserRequest $request){
        try{
        $request['password'] = Hash::make($request->password);
        $request['type'] = 'user';

        $user = User::create($request->all());
        if($user){
            return response()->json([
                'success'=>'true',
                'message'=>'User Created Successfully',
                'token'=>$user->createToken("API TOKEN")->plainTextToken
            ],200);
        }

        }catch(\Throwable $th){
            return response()->json([
                'success'=>'false',
                'message'=>$th->getMessage()
            ],500);
        }

    }

    public function loginUser(LoginUserRequest $request){
        try{


            if(!Auth::attempt($request->validated())){
                return response()->json([
                    'success'=>'false',
                    'message'=>'Email & Password does not match with our record'
                ],401);
            }
            $user = User::where('email',$request->email)->first();


            if($user){
                return response()->json([
                    'success'=>'true',
                    'message'=>'User Logged In Successfully',
                    'token'=>$user->createToken("API TOKEN")->plainTextToken
                ],200);
            }

            }catch(\Throwable $th){
                return response()->json([
                    'success'=>'false',
                    'message'=>$th->getMessage()
                ],500);
            }
    }

    public function logout(Request $request){
       $logoutUser =  auth()->user()->tokens()->delete();
       if($logoutUser==true){
        return response()->json([
            'success'=>'true',
            'message'=>'User Logout  Successfully',

        ],200);
       }

    }
}
