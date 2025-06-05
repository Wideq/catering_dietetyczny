<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Menu;
use App\Models\DietPlan;
use App\Models\Transaction;
use Carbon\Carbon;

class OrderFactory extends Factory
{
    public function definition()
    {
        // Generuj datę na podstawie prawdopodobieństwa
        $randomWeight = rand(1, 100);
        $orderDate = Carbon::now()->subDays(rand(1, 180));
        
        if ($randomWeight <= 40) {
            // Ostatni miesiąc - 40% zamówień
            $orderDate = Carbon::now()->subDays(rand(1, 30));
        } elseif ($randomWeight <= 70) {
            // Przedostatni miesiąc - 30% zamówień
            $orderDate = Carbon::now()->subDays(rand(31, 60));
        } elseif ($randomWeight <= 90) {
            // 3 miesiące temu - 20% zamówień
            $orderDate = Carbon::now()->subDays(rand(61, 90));
        } else {
            // Starsze zamówienia - 10%
            $orderDate = Carbon::now()->subDays(rand(91, 180));
        }

        // Różne statusy z realistycznymi proporcjami
        $randomStatus = rand(1, 100);
        if ($randomStatus <= 60) {
            $status = 'completed';
        } elseif ($randomStatus <= 80) {
            $status = 'new';
        } elseif ($randomStatus <= 95) {
            $status = 'in_progress';
        } else {
            $status = 'cancelled';
        }

        // Losowa suma zamówienia (realistyczne wartości)
        $totalAmount = $this->faker->randomFloat(2, 25.00, 500.00);

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'menu_id' => null, // Będzie ustawiane w afterCreating
            'quantity' => $this->faker->numberBetween(1, 3),
            'order_date' => $orderDate,
            'status' => $status,
            'created_at' => $orderDate,
            'updated_at' => $orderDate->copy()->addHours(rand(1, 48)),
            'total_amount' => $totalAmount,
        ];
    }

    /**
     * Konfiguracja dla zamówień pojedynczych dań
     */
    public function singleDish()
    {
        return $this->state(function (array $attributes) {
            return [
                'menu_id' => Menu::inRandomOrder()->first()?->id ?? Menu::factory(),
                'quantity' => $this->faker->numberBetween(1, 5),
                'total_amount' => $this->faker->randomFloat(2, 15.00, 150.00),
            ];
        });
    }

    /**
     * Konfiguracja dla zamówień diet (catering)
     */
    public function dietPlan()
    {
        return $this->state(function (array $attributes) {
            return [
                'menu_id' => null,
                'quantity' => 1,
                'total_amount' => $this->faker->randomFloat(2, 200.00, 2000.00), // Diety są droższe
            ];
        });
    }

    /**
     * Zamówienia z ostatniego tygodnia
     */
    public function recent()
    {
        return $this->state(function (array $attributes) {
            $recentDate = Carbon::now()->subDays(rand(1, 7));
            return [
                'order_date' => $recentDate,
                'created_at' => $recentDate,
                'updated_at' => $recentDate->copy()->addHours(rand(1, 24)),
            ];
        });
    }

    /**
     * Zamówienia zakończone
     */
    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'completed',
            ];
        });
    }

    /**
     * Zamówienia anulowane
     */
    public function cancelled()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'cancelled',
                'total_amount' => 0, // Anulowane zamówienia nie generują przychodu
            ];
        });
    }

    /**
     * Zamówienia z wysoką wartością
     */
    public function highValue()
    {
        return $this->state(function (array $attributes) {
            return [
                'total_amount' => $this->faker->randomFloat(2, 300.00, 1500.00),
                'quantity' => $this->faker->numberBetween(3, 10),
            ];
        });
    }

    /**
     * Zamówienia sezonowe (więcej w weekendy)
     */
    public function weekend()
    {
        return $this->state(function (array $attributes) {
            // Znajdź ostatni weekend
            $date = Carbon::now();
            while (!in_array($date->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
                $date->subDay();
            }
            
            // Wybierz losowy weekend z ostatnich 4 tygodni
            $weekendsAgo = rand(0, 3);
            $weekendDate = $date->copy()->subWeeks($weekendsAgo);
            
            return [
                'order_date' => $weekendDate,
                'created_at' => $weekendDate,
                'updated_at' => $weekendDate->copy()->addHours(rand(1, 48)),
                'total_amount' => $this->faker->randomFloat(2, 80.00, 400.00), // Weekendy = wyższe kwoty
            ];
        });
    }

    /**
     * Po utworzeniu zamówienia
     */
    public function configure()
    {
        return $this->afterCreating(function ($order) {
            // Twórz transakcję dla każdego zamówienia
            if ($order->total_amount > 0) {
                Transaction::create([
                    'user_id' => $order->user_id,
                    'amount' => $order->total_amount,
                    'status' => $order->status === 'completed' ? 'completed' : 
                              ($order->status === 'cancelled' ? 'failed' : 'pending'),
                    'description' => 'Zamówienie #' . $order->id,
                    'payment_method' => $this->faker->randomElement(['online', 'card', 'transfer']),
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at,
                ]);
            }

            // Twórz pozycje zamówienia (OrderItems)
            $itemsCount = rand(1, 4); // 1-4 pozycje w zamówieniu
            
            for ($i = 0; $i < $itemsCount; $i++) {
                $isDietPlan = rand(1, 100) <= 30; // 30% szans na dietę
                
                if ($isDietPlan && DietPlan::count() > 0) {
                    // Pozycja z dietą
                    $dietPlan = DietPlan::inRandomOrder()->first();
                    $duration = $this->faker->randomElement([5, 7, 14, 28]);
                    $price = $dietPlan->price_per_day * $duration;
                    
                    \App\Models\OrderItem::create([
                        'order_id' => $order->id,
                        'menu_id' => null,
                        'diet_plan_id' => $dietPlan->id,
                        'quantity' => 1,
                        'price' => $price,
                        'item_type' => 'diet_plan',
                        'duration' => $duration,
                        'start_date' => Carbon::now()->addDays(rand(1, 14)),
                        'notes' => $this->faker->optional(0.3)->sentence(),
                    ]);
                } else {
                    // Pozycja z menu
                    $menu = Menu::inRandomOrder()->first();
                    if ($menu) {
                        $quantity = rand(1, 3);
                        \App\Models\OrderItem::create([
                            'order_id' => $order->id,
                            'menu_id' => $menu->id,
                            'diet_plan_id' => null,
                            'quantity' => $quantity,
                            'price' => $menu->price,
                            'item_type' => 'menu',
                        ]);
                    }
                }
            }
        });
    }
}