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
        
        $userIds = User::pluck('id')->toArray();
        
        $orders = Order::whereNull('transaction_id')->get();
        
        foreach ($orders as $order) {
            $transaction = Transaction::create([
                'user_id' => $order->user_id ?? $faker->randomElement($userIds), 
                'order_id' => $order->id,
                'amount' => $faker->randomFloat(2, 20, 200),
                'description' => $faker->sentence(),
                'status' => $faker->randomElement(['completed', 'failed', 'pending']),
                'payment_method' => $faker->randomElement(['credit_card', 'bank_transfer', 'paypal']),
                'payment_date' => $faker->dateTimeBetween('-1 month', 'now'),
            ]);
            
            $order->update(['transaction_id' => $transaction->id]);
        }
        
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