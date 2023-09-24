<?php

namespace Database\Seeders;

use App\Models\Admin\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'category_name' => 'Category 1',
            'status' => 1,
        ]);

        Category::create([
            'category_name' => 'Category 2',
            'status' => 1,
        ]);
    }
}
