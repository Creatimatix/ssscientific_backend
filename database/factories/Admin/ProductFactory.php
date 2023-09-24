<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;

    public function definition()
    {
        $statusOptions = [true,false];
        $isFeaturedOptions = [true, false];
        $isReusableOptions = [true, false];

        return [
            'id_category' => $this->faker->numberBetween(1, 2),
//            'id_vendor' => $this->faker->numberBetween(1, 5),
            'sku' => $this->faker->randomNumber(2),
            'name' => $this->faker->sentence(3),
            'slug' => $this->faker->slug(3),
            'short_description' => $this->faker->sentence(10),
            'description' => $this->faker->paragraphs(3, true),
            'features' => $this->faker->sentences(3, true),
            'sale_price' => $this->faker->numberBetween($min = 150, $max = 300),
            'status' => true,
            'is_featured' => $isFeaturedOptions[array_rand($isFeaturedOptions)],
            'is_reusable' => $isReusableOptions[array_rand($isReusableOptions)],
        ];
    }
}
