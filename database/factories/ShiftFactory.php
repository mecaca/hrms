<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shift>
 */
class ShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $shifts = [
            ['name' => 'Regular', 'start' => '06:00:00', 'end' => '22:00:00'],
            ['name' => 'Night Differential', 'start' => '22:00:00', 'end' => '06:00:00'],
        ];

        $shift = fake()->randomElement($shifts);

        return [
            'shift_name' => $shift['name'],
            'start_time' => $shift['start'],
            'end_time' => $shift['end'],
        ];
    }
}
