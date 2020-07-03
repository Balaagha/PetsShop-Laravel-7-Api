<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductWithCategoriesResource;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $query = Products::query();
        if($request->has('q'))
            $query->where('name','like','%'.$request->query('q').'%');
        if($request->has('sortBy'))
            $query->orderBy($request->query('sortBy','DESC'), $request->query('sort'));
        return  response($query->paginate(10),200);
    }
    public function getProductsByChildCategory($id=0,Request $request){
        $query = Products::query()->where('child_category_id', $id);
        if($request->has('q'))
            $query->where('name','like','%'.$request->query('q').'%');
        if($request->has('sortBy'))
            $query->orderBy($request->query('sortBy','DESC'), $request->query('sort'));
        return  response($query->paginate(10),200);
    }
    public function getNewProducts(Request $request){
        $query = Products::query()->where('is_new', '1');
        if($request->has('q'))
            $query->where('name','like','%'.$request->query('q').'%');
        if($request->has('sortBy'))
            $query->orderBy($request->query('sortBy','DESC'), $request->query('sort'));
        return  response($query->paginate(2),200);
    }
    public function getDiscountProducts(Request $request){
        $query = Products::query()->where('discount', '>','0');
        if($request->has('q'))
            $query->where('name','like','%'.$request->query('q').'%');
        if($request->has('sortBy'))
            $query->orderBy($request->query('sortBy','DESC'), $request->query('sort'));
        return  response($query->paginate(10),200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Products;
        $product->name  = $request->name;
        $product->slug  = Str::slug($request->name);
        $product->price = $request->price;
        $product->description = $request->description;
        $product->size = $request->size;
        $product->color = $request->color;
        $product->is_new = $request->is_new;
        $product->discount = $request->discount;
        $product->category_id = $request->category_id;
        $product->child_category_id = $request->child_category_id;
        $product->image1 = $request->image1;
        $product->image2 = $request->image2;
        $product->image3 = $request->image3;
        $product->image4 = $request->image4;
        $product->save();
        return response([
            'data' => $product,
            'message' => 'Product Created.'
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Products  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id){
        $product = Products::find($id);
        if($product){
            return $this->apiResponse(ResultType::Success,$product,"Product fetched",200);
        }
        else{
            return $this->apiResponse(ResultType::Error,null,"Product not found",404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $product)
    {
        $product->name  = $request->name;
        $product->slug  = Str::slug($request->name);
        $product->price = $request->price;
        $product->description = $request->description;
        $product->size = $request->size;
        $product->color = $request->color;
        $product->is_new = $request->is_new;
        $product->discount = $request->discount;
        $product->category_id = $request->category_id;
        $product->child_category_id = $request->child_category_id;
        $product->image1 = $request->image1;
        $product->image2 = $request->image2;
        $product->image3 = $request->image3;
        $product->image4 = $request->image4;
        $product->save();
        return response([ 'data' => $product,'message' => 'Product update.'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $product)
    {
        $product->delete();
        return response([ 'message' => 'Product delete.'],200);
    }
    public function custom1(){
        //return Products::select('id','name')->orderBy('created_at','desc')->take(10)->get();// categorilerin id deyerini  dizi kimi verir,diziye anahtar kimi adi verir
        return Products::selectRaw('id as product_id, name as product_name')->orderBy('created_at','desc')->take(10)->get();
    }
    public function custom2(){
        $products = Products::orderBy('created_at','desc')->take(10)->get();
        $mapped = $products->map(function ($product){
            return [ '_id'=>$product['id'],'product_name'=>$product['name'],'product_price'=>$product['price'],];
        });
        return $mapped->all();
    }
    public function custom3(){
        $products = Products::paginate(10);
        return ProductResource::collection($products);
    }
    public function listWithCategories (){
        //$products = Products::paginate(10);
        $products = Products::with('categories')->paginate(10);// with ile categprileri de cekir resourcenin icindeki collectionin icindeki $this->whenLoaded funksiyasina esasen isleyir
        return ProductWithCategoriesResource::collection($products);
    }



}

