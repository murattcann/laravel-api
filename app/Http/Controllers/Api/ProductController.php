<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductWithCategoriesResource;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends ApiController
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

        $query = Product::query()->with("categories");

        if(request()->has("q"))
            $query->where('title','like', '%'.$q.'%')->get();


        // for sorting

        if(request()->has("sortBy"))
            $query->orderBy(request()->query("sortBy"), request()->query('sort', 'DESC'));

        // for pagination

        $offset = \request()->has("offset") ? \request()->query("offset"): 0;
        $limit  = \request()->has("limit")  ? \request()->query("limit") : 10;

        $data = $query->offset($offset)->limit($limit)->get();
        $data->makeHidden('slug');

        return $this->apiResponse($data, "Products Fetched.", 200);
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

       $product = new Product();

       $product->title      = $data["title"];
       $product->slug       = Str::slug($data["title"]);
       $product->description = $data["description"];
       $product->price      = $data["price"];

       $product->save();

       return $this->apiResponse($product, "Product created successfully", 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if(!$product)
            return $this->apiResponse(null,"Product not found for $id ID.", 404);
        else
            return $this->apiResponse($product,"Product found.", 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->all();
        $data["slug"] = Str::slug($data["title"]);


        $product->update($data);

        return $this->apiResponse($product,"Product updated successfully", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     *
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return $this->apiResponse(null,"Product deleted successfully", 200);
    }

    public function pluck(){
        return Product::pluck("title", "id");
    }

    public function map(){
        $products = Product::orderBy("id", "DESC")->get();

        $mapped = $products->map(function ($product){
            return[
                '_id' => $product->id,
                'product_title' => $product->title,
                'original_price' => $product->price,
                'modified_price' => $product->price * 1.03,

            ];
        });

        return $mapped->all();
    }

    // for resource paginated data
    public function paginatedData(){
        $products = Product::paginate(10);

        return ProductResource::collection($products);
    }

    public function productsWithRelation(){
        $products = Product::all();

        return ProductWithCategoriesResource::collection($products);
    }
}
