<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ProductCategory;

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
        $name = $this->faker->unique()->words(3, true);
        return [
            'product_name' => ucfirst($name),
            'slug' => Str::slug($name),
            'category_id' => ProductCategory::inRandomOrder()->first()->id ?? ProductCategory::factory(),
            'description' => $this->faker->paragraphs(3, true),
            'client' => $this->faker->company(),
            'location' => $this->faker->city(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->optional()->date(),
            'main_image' => null,
            'status' => $this->faker->numberBetween(0, 1),
        ];
    }
}
