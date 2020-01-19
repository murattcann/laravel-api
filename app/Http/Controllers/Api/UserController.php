<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$products = Product::all();

        // for database search with paginate

        $q  = request()->query("q");

        $query = User::query();

        if(request()->has("q"))
            $query->where('name','like', '%'.$q.'%')->get();


        // for sorting

        if(request()->has("sortBy"))
            $query->orderBy(request()->query("sortBy"), request()->query('sort', 'DESC'));

        // for pagination

        $offset = \request()->has("offset") ? \request()->query("offset"): 0;
        $limit  = \request()->has("limit")  ? \request()->query("limit") : 10;

        $data = $query->offset($offset)->limit($limit)->get();
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $user = new User();

        $user ->name      = $data["name"];
        $user ->email = $data["email"];
        $user ->password  = Hash::make($data["password"]);
        $user->save();

        return response()->json([
            "user" => $user,
            "message" => "User created successfully"
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if(!$user)
            return response()->json(["message" => "User not found for $id ID."], 404);
        else
            return response()->json($user, 200);
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
        $data = $request->all();

        if($request->has("password"))
            $data["password"] = Hash::make($data["password"]);

        $user->update($data);

        return response()->json([
            "user" => $user,
            "message" => "User updated successfully"
        ]);
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

        return response()->json(["message" => "User deleted successfully"], 200);
    }

    public function customResource(){
        // for single record
         $user = User::find(1);
         // to remove data wrapper for single record
         UserResource::withoutWrapping();
         return new  UserResource($user);

        // for multiple record
        /*$users = User::all();

        return  UserResource::collection($users)->additional([
            "meta" => [
                "total_users" => $users->count(),
            ]
        ]);*/
         // or
        //return new UserCollection($users);
    }

}

