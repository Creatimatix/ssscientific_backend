<?php

namespace Database\Seeders;

use App\Models\Admin\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed products for category 1
        $category1Products = [
            [
                'sku' => 'P001',
                'name' => 'Product 1',
                'slug' => 'product-1',
                'short_description' => 'Short description for product 1',
                'description' => 'Long description for product 1',
                'features' => 'Feature 1, Feature 2, Feature 3',
                'status' => 'published',
                'is_featured' => true,
                'is_reusable' => false,
            ],
            [
                'sku' => 'P002',
                'name' => 'Product 2',
                'slug' => 'product-2',
                'short_description' => 'Short description for product 2',
                'description' => 'Long description for product 2',
                'features' => 'Feature 1, Feature 2, Feature 3',
                'status' => 'published',
                'is_featured' => false,
                'is_reusable' => true,
            ],
        ];

        foreach ($category1Products as $productData) {
            Product::create(array_merge($productData, ['id_category' => 1]));
        }

        // Seed products for category 2
        $category2Products = [
            [
                'sku' => 'P003',
                'name' => 'Product 3',
                'slug' => 'product-3',
                'short_description' => 'Short description for product 3',
                'description' => 'Long description for product 3',
                'features' => 'Feature 1, Feature 2, Feature 3',
                'status' => 'published',
                'is_featured' => false,
                'is_reusable' => true,
            ],
            [
                'sku' => 'P004',
                'name' => 'Product 4',
                'slug' => 'product-4',
                'short_description' => 'Short description for product 4',
                'description' => 'Long description for product 4',
                'features' => 'Feature 1, Feature 2, Feature 3',
                'status' => 'draft',
                'is_featured' => false,
                'is_reusable' => false,
            ],
        ];

        foreach ($category2Products as $productData) {
            Product::create(array_merge($productData, ['id_category' => 2]));
        }
    }
}
