<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'branch_id' => function () {
                return \App\Models\Branch::inRandomOrder()->first()->id;
            },
            'employee_name' => fake()->name,
            'employee_type' => fake()->randomElement(['Engineer', 'Staff']),
        ];
    }
}
