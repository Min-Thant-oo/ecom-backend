<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user_count = User::count(); 

        return [
            'user_id'       =>  rand(1, $user_count),
            'quantity'      =>  rand(5, 20),
            // both methods work.
            // 'total_amount'  =>  $this->faker->randomFloat(2, 500, 8000),
            'total_amount'   =>  rand(50000, 800000) / 100,
            'transaction_id' =>  Str::uuid()->toString(),
            'created_at'     => now(),
            'updated_at'     => now(),
        ];
    }
}
