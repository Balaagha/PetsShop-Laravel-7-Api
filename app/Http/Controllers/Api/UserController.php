<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::query();
        if($request->has('q'))
            $query->where('name','like','%'.$request->query('q').'%');
        if($request->has('sortBy'))
            $query->orderBy($request->query('sortBy','DESC'), $request->query('sort'));
        return  response($query->paginate(1),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserStoreRequest $request)
    {
//        $validator = Validator::make($request->all(),[
//            'email'=> 'required|email|unique:users','name'=> 'required|string|max:50','password' => 'required',
//        ]);
//        if($validator->fails()){return $this->apiResponse(ResultType::Error,$validator->errors(),'Validation error!',422);}

        $user = new User;
        $user->name  = $request->name;
        $user->email  = $request->email;
        $user->email_verified_at = now(); $user->remembertoken = Str::random(10);
        $user->password = bcrypt($request->password);
        $user->save();
        return $this->apiResponse(ResultType::Success,$user,"User Created",201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->name  = $request->name;
        $user->email  = $request->email;
        $user->save();

        return response([
            'data' => $user,'message' => 'User Update.'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response(['message' => 'User Delete.'],200);
    }
    public function custom1(){

        $user1 = User::find(1);// return $user1->toJson(); // sade gosterme varyanti
//        UserResource::withoutWrapping(); //data nin icinde tek burda vermemesi ucun
//        return new UserResource($user1); // UserResource ile teklini gosterme varyanti

        $users = User::all();
        //return UserResource::collection($users); // UserResource ile birden fazla verini  gosterme varyanti
        //return new UserCollection($users);

        return UserResource::collection($users)->additional([
            'meta'=>['total_user'=>$users->count(),'user1'=>$user1]
        ]);
    }
}
