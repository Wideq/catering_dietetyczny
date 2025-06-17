<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DietPlan;
use App\Models\Menu;

class DietPlanSeeder extends Seeder
{
    public function run()
    {
        $dietPlans = [
            [
                'name' => 'Dieta Standard',
                'description' => 'Zbilansowana dieta dostarczająca wszystkich niezbędnych składników odżywczych. Idealna dla osób dbających o zdrowe odżywianie bez specjalnych wymagań dietetycznych.',
                'price_per_day' => 29.90, 
                'icon' => 'fa-utensils',
                'is_active' => true,
                'categories' => ['śniadanie', 'drugie śniadanie', 'obiad', 'podwieczorek', 'kolacja']
            ],
            [
                'name' => 'Dieta Vegetarian',
                'description' => 'Dieta wegetariańska bogata w warzywa, owoce, produkty pełnoziarniste i roślinne źródła białka. Odpowiednia dla osób wykluczających mięso z jadłospisu.',
                'price_per_day' => 34.90, 
                'icon' => 'fa-leaf',
                'is_active' => true,
                'categories' => ['śniadanie', 'drugie śniadanie', 'obiad', 'kolacja']
            ],
            [
                'name' => 'Dieta Low Carb',
                'description' => 'Dieta niskowęglowodanowa ukierunkowana na redukcję tkanki tłuszczowej. Opiera się na zwiększonej ilości białka i tłuszczów, przy ograniczeniu węglowodanów.',
                'price_per_day' => 39.90, 
                'icon' => 'fa-drumstick-bite',
                'is_active' => true,
                'categories' => ['śniadanie', 'obiad', 'kolacja']
            ],
            [
                'name' => 'Dieta Sport',
                'description' => 'Dieta dla osób aktywnych fizycznie, zawierająca zwiększoną ilość białka i węglowodanów złożonych. Wspomaga budowę masy mięśniowej i regenerację.',
                'price_per_day' => 44.90, 
                'icon' => 'fa-dumbbell',
                'is_active' => true,
                'categories' => ['śniadanie', 'drugie śniadanie', 'obiad', 'podwieczorek', 'kolacja']
            ],
            [
                'name' => 'Dieta Ketogeniczna',
                'description' => 'Dieta bardzo niskowęglowodanowa z wysoką zawartością tłuszczów. Prowadzi do ketozy, w której organizm czerpie energię głównie z ketonu zamiast glukozy.',
                'price_per_day' => 49.90, 
                'icon' => 'fa-bacon',
                'is_active' => true,
                'categories' => ['śniadanie', 'obiad', 'kolacja']
            ],
        ];

        foreach ($dietPlans as $planData) {
            $categories = $planData['categories'];
            unset($planData['categories']);
            
            $dietPlan = DietPlan::create($planData);
            
            $menuItems = collect();
            
            foreach ($categories as $category) {
                $categoryItems = Menu::where('category', $category)
                    ->inRandomOrder()
                    ->limit(rand(1, 2)) 
                    ->get();
                    
                $menuItems = $menuItems->merge($categoryItems);
            }
            
            if ($menuItems->count() > 0) {
                $dietPlan->menuItems()->attach($menuItems->pluck('id')->toArray());
                
                $totalMealsPrice = $menuItems->sum('price');
                $count = $menuItems->count();
                
                
                $markup = 0.20; 
                $additionalCost = $totalMealsPrice * $markup;
                
                $discount = 0;
                if ($count >= 4 && $count < 7) {
                    $discount = $additionalCost * 0.15; 
                } else if ($count >= 7) {
                    $discount = $additionalCost * 0.25; 
                }
                
                $finalPrice = $planData['price_per_day'] + $additionalCost - $discount;
                
                $finalPrice = floor($finalPrice) + 0.90;
                
                $dietPlan->update(['price_per_day' => $finalPrice]);
                
                $totalCalories = $menuItems->sum('calories');
                $totalProtein = $menuItems->sum('protein');
                $totalCarbs = $menuItems->sum('carbs');
                $totalFat = $menuItems->sum('fat');
                $totalFiber = $menuItems->sum('fiber');
                
                $this->command->info("✅ Dieta '{$dietPlan->name}' utworzona:");
                $this->command->info("   📊 {$count} dań | 💰 {$finalPrice} zł/dzień");
                $this->command->info("   🔥 {$totalCalories} kcal | 🥩 {$totalProtein}g białka | 🍞 {$totalCarbs}g węgl. | 🥑 {$totalFat}g tłuszcze");
            } else {
                $this->command->warning("⚠️ Brak dań dla diety '{$dietPlan->name}'");
            }
        }
        
        $this->command->info('🎉 Plany dietetyczne utworzone z realistycznymi cenami i wartościami odżywczymi!');
    }
}