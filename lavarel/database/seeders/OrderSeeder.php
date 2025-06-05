<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Wyczyść istniejące dane testowe (zachowaj prawdziwe dane użytkowników)
        OrderItem::whereHas('order', function($query) {
            $query->where('created_at', '>', Carbon::now()->subYear());
        })->delete();
        
        Transaction::where('description', 'like', 'Zamówienie%')
                  ->where('created_at', '>', Carbon::now()->subYear())
                  ->delete();
        
        Order::where('created_at', '>', Carbon::now()->subYear())->delete();

        // 1. Zamówienia z ostatniego tygodnia (najnowsze)
        Order::factory(15)
            ->recent()
            ->completed()
            ->create();

        // 2. Zamówienia z ostatniego miesiąca - różne statusy
        Order::factory(25)
            ->singleDish()
            ->create();

        // 3. Zamówienia diet (catering) - mniejsza ilość ale wyższe wartości
        Order::factory(10)
            ->dietPlan()
            ->completed()
            ->create();

        // 4. Zamówienia weekendowe (wyższe wartości)
        Order::factory(8)
            ->weekend()
            ->highValue()
            ->create();

        // 5. Anulowane zamówienia
        Order::factory(5)
            ->cancelled()
            ->create();

        // 6. Zamówienia w realizacji
        Order::factory(12)
            ->state([
                'status' => 'in_progress',
                'order_date' => Carbon::now()->subDays(rand(1, 3)),
                'created_at' => Carbon::now()->subDays(rand(1, 3)),
                'updated_at' => Carbon::now()->subDays(rand(0, 2)),
            ])
            ->create();

        // 7. Nowe zamówienia
        Order::factory(8)
            ->state([
                'status' => 'new',
                'order_date' => Carbon::now()->subHours(rand(1, 48)),
                'created_at' => Carbon::now()->subHours(rand(1, 48)),
                'updated_at' => Carbon::now()->subHours(rand(1, 24)),
            ])
            ->create();

        // 8. Historyczne zamówienia (2-6 miesięcy temu)
        Order::factory(30)
            ->state(function () {
                $date = Carbon::now()->subDays(rand(60, 180));
                return [
                    'order_date' => $date,
                    'created_at' => $date,
                    'updated_at' => $date->copy()->addDays(rand(1, 5)),
                    'status' => 'completed',
                ];
            })
            ->create();

        // 9. Zamówienia z różnych okresów dla lepszej wizualizacji trendów
        for ($i = 0; $i < 6; $i++) {
            $monthAgo = Carbon::now()->subMonths($i);
            $ordersCount = max(5, 20 - ($i * 3)); // Mniej zamówień w starszych miesiącach
            
            Order::factory($ordersCount)
                ->state(function () use ($monthAgo) {
                    $date = $monthAgo->copy()->addDays(rand(0, 30));
                    return [
                        'order_date' => $date,
                        'created_at' => $date,
                        'updated_at' => $date->copy()->addHours(rand(1, 72)),
                        'status' => collect(['completed', 'completed', 'completed', 'cancelled'])->random(),
                    ];
                })
                ->create();
        }

        $this->command->info('Utworzono zamówienia testowe z różnorodnymi danymi dla wykresów!');
        $this->command->info('Łączna liczba zamówień: ' . Order::count());
        $this->command->info('Łączna liczba transakcji: ' . Transaction::count());
    }
}