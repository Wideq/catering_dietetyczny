<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;

class TransactionFactory extends Factory
{
    public function definition()
    {
        return [
            'order_id' => Order::factory(), 
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
            'payment_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}