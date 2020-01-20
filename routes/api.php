<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get("categories/pluck", "Api\CategoryController@pluck")->middleware("api-token");
Route::get("products/pluck", "Api\ProductController@pluck");
Route::get("categories/map", "Api\CategoryController@map");
Route::get("products/map", "Api\ProductController@map");

Route::get("categories/join", "Api\CategoryController@join");
Route::get("products/join", "Api\ProductController@join");

Route::get("users/custom-resource", "Api\UserController@customResource");
Route::get("products/custom-resource-paginated", "Api\ProductController@paginatedData");

Route::get("products/custom-resource-relations", "Api\ProductController@productsWithRelation");

Route::apiResource("users", "Api\UserController");
Route::apiResource("products", "Api\ProductController");
Route::apiResource("categories", "Api\CategoryController");


Route::post("auth/login", "Api\AuthController@login");

Route::post("upload", "Api\UploadController@upload");

Route::middleware("api-token")->group(function (){
    Route::get("/auth/token",function (Request $request){
        $user = $request->user();

        return response()->json([

            "name" => $user->first_name,
            "access_token" => $user->api_token,
            "time"  => time()
        ]);
    });

});
