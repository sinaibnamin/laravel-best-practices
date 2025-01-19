<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Announcement>
 */
class AnnouncementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'headline' => fake()->paragraph(1),
            'description' => fake()->paragraph(10),
            'type' => fake()->randomElement(['danger','info','success','success','success','warning']),
            'priority' => fake()->randomElement(['1','2','3','4','5','6']),
            'status' => fake()->randomElement(['Active','Active','Active','Inactive']),
        ];
    }
}

