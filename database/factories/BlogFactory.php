<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
   
    public function definition()
    {
        return [
            'title' => fake()->paragraph(1),
            'thumb' => null,
            'images' => null,
            'status' => fake()->randomElement([0,1,2,1,1,1,1,3]),
            'blog_html' => '<p>hello</p>',
            'blog_css' => '.menu{}',
        ];
    }
}
