<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        try {
            $this->command->info('🧹 Czyszczenie starych danych testowych...');
            
            $deletedOrderItems = OrderItem::whereHas('order', function($query) {
                $query->where('created_at', '>', Carbon::now()->subYear());
            })->count();
            
            OrderItem::whereHas('order', function($query) {
                $query->where('created_at', '>', Carbon::now()->subYear());
            })->delete();
            
            $this->command->info("   ❌ Usunięto {$deletedOrderItems} pozycji zamówień");
            
            $ordersToUpdate = Order::where('created_at', '>', Carbon::now()->subYear())
                                   ->whereNotNull('transaction_id')
                                   ->count();
            
            Order::where('created_at', '>', Carbon::now()->subYear())
                 ->update(['transaction_id' => null]);
            
            $this->command->info("   🔗 Usunięto powiązania z {$ordersToUpdate} zamówieniami");
            
            $deletedTransactions = Transaction::where('description', 'like', 'Zamówienie%')
                                             ->where('created_at', '>', Carbon::now()->subYear())
                                             ->count();
            
            Transaction::where('description', 'like', 'Zamówienie%')
                      ->where('created_at', '>', Carbon::now()->subYear())
                      ->delete();
            
            $this->command->info("   💳 Usunięto {$deletedTransactions} transakcji");
            
            $deletedOrders = Order::where('created_at', '>', Carbon::now()->subYear())->count();
            Order::where('created_at', '>', Carbon::now()->subYear())->delete();
            
            $this->command->info("   📦 Usunięto {$deletedOrders} zamówień");
            
            $this->command->info('🎯 Rozpoczynam tworzenie nowych danych testowych...');

            $this->command->info('📅 Tworzenie zamówień z ostatniego tygodnia...');
            Order::factory(15)
                ->recent()
                ->completed()
                ->create();

            $this->command->info('📅 Tworzenie zamówień z ostatniego miesiąca...');
            Order::factory(25)
                ->singleDish()
                ->create();

            $this->command->info('🥗 Tworzenie zamówień diet...');
            Order::factory(10)
                ->dietPlan()
                ->completed()
                ->create();

            $this->command->info('🏖️ Tworzenie zamówień weekendowych...');
            Order::factory(8)
                ->weekend()
                ->highValue()
                ->create();

            $this->command->info('❌ Tworzenie anulowanych zamówień...');
            Order::factory(5)
                ->cancelled()
                ->create();

            $this->command->info('⚙️ Tworzenie zamówień w realizacji...');
            Order::factory(12)
                ->state([
                    'status' => 'in_progress',
                    'order_date' => Carbon::now()->subDays(rand(1, 3)),
                    'created_at' => Carbon::now()->subDays(rand(1, 3)),
                    'updated_at' => Carbon::now()->subDays(rand(0, 2)),
                ])
                ->create();

            $this->command->info('🆕 Tworzenie nowych zamówień...');
            Order::factory(8)
                ->state([
                    'status' => 'new',
                    'order_date' => Carbon::now()->subHours(rand(1, 48)),
                    'created_at' => Carbon::now()->subHours(rand(1, 48)),
                    'updated_at' => Carbon::now()->subHours(rand(1, 24)),
                ])
                ->create();

            $this->command->info('📚 Tworzenie historycznych zamówień...');
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

            $this->command->info('📊 Tworzenie danych dla wykresów...');
            for ($i = 0; $i < 6; $i++) {
                $monthAgo = Carbon::now()->subMonths($i);
                $ordersCount = max(5, 20 - ($i * 3)); 
                
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

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $this->command->info('🎉 Utworzono zamówienia testowe z różnorodnymi danymi dla wykresów!');
            $this->command->info('📊 Statystyki końcowe:');
            $this->command->info('   📦 Łączna liczba zamówień: ' . Order::count());
            $this->command->info('   💳 Łączna liczba transakcji: ' . Transaction::count());
            $this->command->info('   📋 Łączna liczba pozycji zamówień: ' . OrderItem::count());
            
        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            throw $e;
        }
    }
}