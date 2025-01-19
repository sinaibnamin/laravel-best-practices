<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ExpenseType;

class ExpenseFactory extends Factory
{

    public function definition()
    {
        $total_expenseType = ExpenseType::count();
        return [
            'date' => fake()->dateTimeBetween('-6 months', 'now'),
            'expense_type_id' => fake()->numberBetween(1, $total_expenseType),
            'amount' => fake()->numberBetween(100, 5000),
            'description' => fake()->paragraph(1),
        ];
    }
}
