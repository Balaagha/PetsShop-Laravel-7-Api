<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class AuthController extends ApiController
{
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
           'email'    => 'required|email',
           'password' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['message'=>$validator->messages()]);
        }
        $user = User::where('email',$request->input('email'))->first();
        if($user){
            if(Hash::check($request->input('password'),$user->password)){
                $newToken=Str::random(60);
                $user->update(['api_token'=>hash('sha256', $newToken)]);
                $adres = $user->getadress()->get();
                $order = $user->getorders()->get();
                return response()->json([
                    'name'=>$user->name,
                    'access_token'=>$user->api_token,
                    'data'=>$user,
                    'time'=>time(),
                    'adres'=>$adres,
                    'orders'=>$order
                ],200);
            }
            return response()->json(['message'=>'Invalid Password'],404);
        }
        return response()->json(['message'=>'User not found'],404);

    }
    public function singUp(UserStoreRequest $request){
        $user = new User;
        $user->name  = $request->name;
        $user->email  = $request->email;
        $user->email_verified_at = now();
        $user->password = bcrypt($request->password);
        $user->save();
        return $this->apiResponse(ResultType::Success,$user,"User Created",201);
    }
}
