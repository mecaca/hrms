<?php

namespace Database\Factories;

use App\Models\JobTitle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobVacancy>
 */
class JobVacancyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jobTitle = JobTitle::inRandomOrder()->first();

        if (!$jobTitle) {
            // If no JobTitle exists, create one with factory
            $jobTitle = JobTitle::factory()->create();
        }

        return [
            'job_title_id' => $jobTitle->job_title_id,
            'vacancy_count' => fake()->numberBetween(0, 10),
            'application_deadline_at' => fake()->optional()->dateTimeBetween('now', '+1 year'),
        ];
    }
}
