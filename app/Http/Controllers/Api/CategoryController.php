<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\ProductCategories;

use App\Http\Resources\CategoriesWithProductResource;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $discountProduct = Products::where('discount','>', 0)->take(10)->get();
        $newProduct = Products::where('is_new', "1")->take(10)->get();
        return CategoryResource::collection(Category::All())->additional([
            'newProduct'=>ProductResource::collection($newProduct),
            'discountProduct'=>ProductResource::collection($discountProduct),
        ]);
//        return $this->apiResponse(ResultType::Success,Category::All(),'Categories Fetched',200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->name  = $request->name;
        $category->slug  = Str::slug($request->name);
        $category->image  = $request->image;
        $category->color  = $request->color;
        $category->save();
        return $this->apiResponse(ResultType::Success,$category,'Category Created.',201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $CategoryWithChildCategories = Category::query()->with('childcategories')->find($id);
        $mapped = $CategoryWithChildCategories['childcategories']->map(function ($childcategory){
            $products= Products::where('child_category_id', $childcategory['id'])->take(10)->get();
            $childcategory['products']=ProductResource::collection($products);
            return $childcategory;
        });
        $CategoryWithChildCategories['childcategories'] = $mapped;
        return $this->apiResponse(ResultType::Success,$CategoryWithChildCategories,'Single Category Fetched',200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $category)
    {
        $category->name  = $request->name;
        $category->slug  = Str::slug($request->name);
        $category->image  = $request->image;
        $category->color  = $request->color;
        $category->save();
        return $this->apiResponse(ResultType::Success,$category,'Category update.',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
 * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->apiResponse(ResultType::Success,null, 'Category deleted',200);
    }






    public function custom1(){
//        return Category::pluck('id');//sadece categorilerin id deyerini dizi kimi verir
        return Category::pluck('id','name');// categorilerin id deyerini  dizi kimi verir,diziye anahtar kimi adi verir
    }
    public function report1(){
        return DB::table('product_categories as pc')
            ->selectRaw('c.name, COUNT(*) as total')
            ->join('categories as c','c.id','=','pc.category_id')
            ->join('products as p','p.id','=','pc.products_id')
            ->groupBy('c.name')
            ->orderByRaw('COUNT(*) DESC')
            ->get();
    }

    public function productCategoryRelationshipTable(){return ProductCategories::All();} //Category Product RelationShip index

    public function productCategoryRelationshipTableCreate(Request $request){
        $productCategory = new ProductCategories();
        $productCategory->products_id  = $request->products_id;
        $productCategory->category_id  = $request->category_id;
        $productCategory->save();
        return response([
            'data' => $productCategory,
            'message' => 'Category Product relationship is complate.'
        ],201);
    }//Category Product RelationShip post
    public function CategoriesWithList (){
        $products = Category::with('childcategories')->paginate(10);
//        $childcategories = Category::query()->with('childcategories')->find(1);
//        return response(['data' => $childcategories,],201);
        return CategoriesWithProductResource::collection($products);
    }
}
