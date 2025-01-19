<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'news_id' => fake()->numberBetween($min = 1, $max = 200),
            'description' => fake()->paragraph(1),
            'reporter_name' => fake()->name(),
            'reporter_phone' => '016789254698',
        ];
    }
}


// $table->integer('news_id')->nullable();
// $table->text('description')->nullable();
// $table->string('reporter_name')->nullable();
// $table->string('reporter_phone')->nullable();