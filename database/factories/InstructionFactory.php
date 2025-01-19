<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instruction>
 */
class InstructionFactory extends Factory
{
   
    public function definition()
    {
        $total_member = env('SEED_MEMBER');
        $total_trainer = env('SEED_TRAINER');

        return [
            'member_id' => fake()->numberBetween(1, $total_member),
            'trainer_id' => fake()->numberBetween(1, $total_trainer),
            'description' => fake()->paragraph(8),
        ];

    }
}
