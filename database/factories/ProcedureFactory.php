<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Procedure>
 */
class ProcedureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->text(),
            'type_id' => rand(1, 4),
            'state_id' => rand(1, 3),
            'ended_at' => now()->addDays(rand(5, 10)),
            'is_featured' => fake()->boolean()
        ];
    }
}
