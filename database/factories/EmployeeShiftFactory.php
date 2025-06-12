<?php

namespace Database\Factories;

use App\Models\Shift;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeShift>
 */
class EmployeeShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $shift = Shift::inRandomOrder()->first();

        if (!$shift) {
            $shift = Shift::factory()->create();
        }

        return [
            'shift_id' => $shift->shift_id,
            'start_time' => fake()->time('H:i:s'),
            'end_time' => fake()->time('H:i:s'),
        ];
    }
}
