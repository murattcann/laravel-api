<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET FOREIGN_KEY_CHECKS=0");

        Category::truncate();

       for($i = 1; $i <= 30; $i++)
       {
            $data = [
                "title" => "Category $i",
                "slug"  => "category-$i"
            ];

            DB::table("categories")->insert($data);
       }

       DB::table("category_product")->insert(['product_id' => 1, 'category_id' => 1]);
       DB::table("category_product")->insert(['product_id' => 1, 'category_id' => 2]);
       DB::table("category_product")->insert(['product_id' => 2, 'category_id' => 1]);
       DB::table("category_product")->insert(['product_id' => 2, 'category_id' => 2]);
       DB::table("category_product")->insert(['product_id' => 2, 'category_id' => 3]);

       DB::statement("SET FOREIGN_KEY_CHECKS=1");
    }
}
