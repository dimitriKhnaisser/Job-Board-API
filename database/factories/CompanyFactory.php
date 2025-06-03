<?php

namespace Database\Factories;

use App\Models\Industry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'industry_id'=>Industry::inRandomOrder()->first()->id,
            'email'=>fake()->unique()->safeEmail(),
            'password'=>fake()->password(),
            'name'=>fake()->company(),
            'address'=>fake()->address()
        ];
    }
}
