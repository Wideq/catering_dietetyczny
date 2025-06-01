<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        
        // Get all user IDs for reference
        $userIds = User::pluck('id')->toArray();
        
        // Get all orders that don't have transactions yet
        $orders = Order::whereNull('transaction_id')->get();
        
        foreach ($orders as $order) {
            // Create transaction with required user_id
            $transaction = Transaction::create([
                'user_id' => $order->user_id ?? $faker->randomElement($userIds), // Use order's user_id or random user
                'order_id' => $order->id,
                'amount' => $faker->randomFloat(2, 20, 200),
                'description' => $faker->sentence(),
                'status' => $faker->randomElement(['completed', 'failed', 'pending']),
                'payment_method' => $faker->randomElement(['credit_card', 'bank_transfer', 'paypal']),
                'payment_date' => $faker->dateTimeBetween('-1 month', 'now'),
            ]);
            
            // Update the order with the transaction ID
            $order->update(['transaction_id' => $transaction->id]);
        }
        
        // Create some standalone transactions not linked to specific orders
        for ($i = 0; $i < 10; $i++) {
            Transaction::create([
                'user_id' => $faker->randomElement($userIds),
                'amount' => $faker->randomFloat(2, 20, 200),
                'description' => $faker->sentence(),
                'status' => $faker->randomElement(['completed', 'failed', 'pending']),
                'payment_method' => $faker->randomElement(['credit_card', 'bank_transfer', 'paypal']),
                'payment_date' => $faker->dateTimeBetween('-1 month', 'now'),
            ]);
        }
    }
}