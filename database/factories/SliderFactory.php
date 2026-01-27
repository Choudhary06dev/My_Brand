<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slider>
 */
class SliderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'subtitle' => $this->faker->sentence(),
            'image' => null,
            'button_text' => 'Learn More',
            'button_link' => '#',
            'sequence' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->boolean(80),
        ];
    }
}
