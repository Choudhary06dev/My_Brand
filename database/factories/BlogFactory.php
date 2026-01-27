<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence();
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'summary' => $this->faker->paragraph(),
            'content' => $this->faker->paragraphs(5, true),
            'thumbnail' => null,
            'banner_image' => null,
            'author_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'status' => $this->faker->numberBetween(0, 1),
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
