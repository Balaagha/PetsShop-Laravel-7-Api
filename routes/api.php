<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('api-token')->group(function (){
    Route::get('/auth/token', function (Request $request) {
        $user = $request->user();
        return response()->json(['data'=>$user,'time'=>time()],200);
    });
});

Route::get('categories/productandcategories','Api\CategoryController@productCategoryRelationshipTable');
Route::post('categories/productandcategories','Api\CategoryController@productCategoryRelationshipTableCreate');
Route::get('categories/categorieswithlist','Api\CategoryController@CategoriesWithList');//Resource relotion data
Route::get('products/listwithcategories','Api\ProductController@listWithCategories');//Resource relotion data


Route::get('categories/custom1','Api\CategoryController@custom1');
Route::get('products/custom1','Api\ProductController@custom1');
Route::get('products/custom2','Api\ProductController@custom2');
Route::get('categories/report1','Api\CategoryController@report1');
Route::get('users/custom1','Api\UserController@custom1');//resource
Route::get('products/custom3','Api\ProductController@custom3');//pagination


//Route::middleware('auth:api')->get Route::middleware('api-token')->get
//esaslar
Route::post('auth/login','Api\AuthController@login');
Route::post('auth/singup','Api\AuthController@singUp');

Route::get('products/getnewproducts','Api\ProductController@getNewProducts');//New Poducts
Route::get('products/getdiscountproducts','Api\ProductController@getDiscountProducts');//New Poducts
Route::get('products/getproductsbychildcategory/{id}','Api\ProductController@getProductsByChildCategory');//New Poducts

Route::middleware('auth:api')->group(function () {
    Route::apiResources([
        'users' => 'Api\UserController',
        'products' => 'Api\ProductController',
        'categories' => 'Api\CategoryController',
        'childcategories'=>'Api\ChildCategoryController',
        'adress'=>'Api\AdresController',
        'orders'=>'Api\OrderController',
    ]);
});
