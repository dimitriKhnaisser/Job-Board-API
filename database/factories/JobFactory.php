<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id'=>Company::inRandomOrder()->first()->id,
            'type_id'=>Type::inRandomOrder()->first()->id,
            'title'=>fake()->jobTitle(),
            'salary'=>fake()->numberBetween(700,5000),
            'description'=>fake()->paragraph()
        ];
    }
}
