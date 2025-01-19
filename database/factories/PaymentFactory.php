<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Package;

class PaymentFactory extends Factory
{
    public function definition()
    {
        $total_member = env('SEED_MEMBER');
        $package = Package::inRandomOrder()->first();

        return [
            'package_id' => $package->id,
            'package_name' => $package->name,
            'package_price' => $package->price,
            'package_duration' => $package->duration,
            'member_id' => fake()->numberBetween(1, $total_member),
            'paid' => $package->price,
            'pay_by' => 'Cash',
            'due' => 0,
            'discount' => $package->discount,
            'comments' => 'payment full',
            'status' => 'Success',
            'date' => fake()->dateTimeBetween('-6 months', 'now'),
            'validity' => fake()->dateTimeBetween('now', '+2 years')->format('Y-m-d'),
        ];
    }
}
