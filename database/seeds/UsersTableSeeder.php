<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        $data = [
            "first_name" => "Murat",
            "last_name" => "CAN",
            "email" => "muratcan.php@gmail.com",
            "password" => \Illuminate\Support\Facades\Hash::make("123"),
        ];

        DB::table("users")->insert($data);

        for($i = 1; $i<=50; $i++){
            $users = [
                "first_name" => $faker->firstName,
                "last_name" => $faker->lastName,
                "email" => $faker->companyEmail,
                "password" => \Illuminate\Support\Facades\Hash::make("123")
            ];

            DB::table("users")->insert($users);
        }
    }
}
