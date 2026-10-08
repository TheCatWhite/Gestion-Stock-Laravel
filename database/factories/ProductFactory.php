<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $purchasePrice = fake()->randomFloat(2, 5, 40);

        return [
            'category_id' => Category::factory(),
            'supplier_id' => Supplier::factory(),
            'sku' => strtoupper(fake()->unique()->bothify('SKU-####??')),
            'name' => fake()->words(3, true),
            'description' => fake()->optional()->sentence(),
            'purchase_price' => $purchasePrice,
            'selling_price' => round($purchasePrice + fake()->randomFloat(2, 2, 20), 2),
            'stock_quantity' => 100,
            'alert_quantity' => 5,
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_active' => false,
        ]);
    }

    public function lowStock(): static
    {
        return $this->state(fn (array $attributes): array => [
            'stock_quantity' => 3,
            'alert_quantity' => 5,
        ]);
    }
}
