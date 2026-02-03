<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['cat_name' => 'Makanan', 'description' => 'Various types of food'],
            ['cat_name' => 'Minuman', 'description' => 'Drinks and beverages'],
            ['cat_name' => 'Cemilan', 'description' => 'Light snacks and appetizers'],
            ['cat_name' => 'Hidangan Utama', 'description' => 'Hearty main dishes'],
        ];

        DB::table('categories')->insert($categories);
    }
}
