<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>User::inRandomOrder()->first()->id,
            'job_id'=>Job::inRandomOrder()->first()->id,
            'resume'=>fake()->name().'.pdf',
            'cover_letter'=>fake()->paragraph()
        ];
    }
    public function configure()
    {
        return $this->afterMaking(function ($application) {
            // Check if the combination already exists and regenerate if needed
            while (Application::where('user_id', $application->user_id)->where('job_id', $application->job_id)->exists()) {
                // Regenerate the user_id and job_id if the combination exists
                $user = User::inRandomOrder()->first();
                $job = Job::inRandomOrder()->first();

                $application->user_id = $user->id;
                $application->job_id = $job->id;
            }
        });
    }
}
