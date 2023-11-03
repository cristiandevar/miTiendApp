<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $supplier = Supplier::inRAndomOrder()->first();
        $category = Category::inRAndomOrder()->first();
        return [
            'name' => $this->faker->sentence(),
            'code' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2,200,100000),
            'stock' => $this->faker->randomNumber(4,true),
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'active' => 1,
            'image' => $this->faker->imageUrl(640, 480),
            'description' => $this->faker->paragraph(),
        ];
    }
}
