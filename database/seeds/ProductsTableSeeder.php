<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {

        for($i = 1; $i<=50; $i++){
            $data = [
                "title" => $faker->name,
                "slug" => $faker->slug,
                "description" => $faker->text(150),
                "price" => $faker->randomFloat(5,1,5)
            ];
            DB::table("products")->insert($data);
        }
    }
}
