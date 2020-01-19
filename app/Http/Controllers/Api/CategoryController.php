<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json($categories, 200);

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

        $category = new Category();

        $category->title      = $data["title"];
        $category->slug       = Str::slug($data["title"]);

        $category->save();

        return response()->json([
            "category" => $category,
            "message" => "Category created successfully"
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if( !$category )
            return response()->json(["message" => "Category not found for $id ID."], 404);
        else
            return response()->json($category, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
       $title = $request->title;

       $category->title = $title;
       $category->slug = Str::slug($title);
       $category->save();

        return response()->json([
            "category" => $category,
            "message" => "Category updated successfully"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(["message" => "Category deleted successfully"], 200);
    }

    public function pluck(){
        return Category::pluck("title", "id");
    }

    public function join(){
        return DB::table("category_product as cp")
            ->selectRaw('c.title, COUNT(*) as total')
            ->join('categories as c', 'c.id', '=', 'cp.category_id')
            ->join('products as p', 'p.id', '=', 'cp.product_id')
            ->groupBy('c.title')
            ->orderByRaw('COUNT(*) DESC')
            ->get();
    }
}
