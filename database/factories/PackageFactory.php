<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class PackageFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->paragraph(1),
            'price' => fake()->randomElement([1000, 2000, 3000, 4000, 5000, 6000, 7000]),
            'discount' => fake()->randomElement([0,0,0,200,0,0,0,300]),
            'duration' => fake()->randomElement([30, 60, 120, 240, 360]),
            'status' => fake()->randomElement(['Active','Active','Active','Active','Active','Active','Inactive']),
        ];
    }
}
