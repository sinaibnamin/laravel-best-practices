<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentTypeFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => fake()->name(),
            'description' => fake()->paragraph(1),
            'amount' => 450,
            'due_date' => fake()->dateTimeBetween('2024-01-20')->format('Y-m-d'),
            'status' => fake()->randomElement(['Active','Active','Active','Inactive']),
        ];
    }
}
