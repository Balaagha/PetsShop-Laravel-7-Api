<?php

namespace App\Http\Controllers\Api;

use App\ChildCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChildCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->apiResponse(ResultType::Success,ChildCategory::All(),'Categories Fetched1',200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $category = new ChildCategory();
        $category->name  = $request->name;
        $category->slug  = Str::slug($request->name);
        $category->image  = $request->image;
        $category->category_id  = $request->category_id;
        $category->save();
        return $this->apiResponse(ResultType::Success,$category,'Child Category Created.',201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ChildCategory  $childCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $childCategory = ChildCategory::find($id);
        if($childCategory){
            return $this->apiResponse(ResultType::Success,$childCategory,"Child Category fetched",200);
        }
        else{
            return $this->apiResponse(ResultType::Error,null,"Child Category not found",404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChildCategory  $childCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ChildCategory $childCategory)
    {
        $childCategory->name  = $request->name;
        $childCategory->slug  = Str::slug($request->name);
        $childCategory->image  = $request->image;
        $childCategory->category_id  = $request->category_id;
        $childCategory->save();
        return $this->apiResponse(ResultType::Success,$childCategory,'Child Category update.',200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChildCategory  $childCategory
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $childCategory = ChildCategory::find($id);
        $childCategory->delete();
        return $this->apiResponse(ResultType::Success,$id, 'Category deleted',200);
    }
}
