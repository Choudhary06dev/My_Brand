<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompanyInfo>
 */
class CompanyInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_name' => $this->faker->company(),
            'tagline' => $this->faker->catchPhrase(),
            'about' => $this->faker->paragraphs(3, true),
            'mission' => $this->faker->paragraph(),
            'vision' => $this->faker->paragraph(),
            'history' => $this->faker->paragraphs(2, true),
            'logo' => null, // Or a placeholder image path
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->companyEmail(),
            'address' => $this->faker->address(),
        ];
    }
}
