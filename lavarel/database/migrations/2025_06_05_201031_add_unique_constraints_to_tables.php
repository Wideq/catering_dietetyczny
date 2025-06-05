<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // KROK 1: Usuń duplikaty z tabeli menus
        $this->removeDuplicateMenus();
        
        // KROK 2: Usuń duplikaty z tabeli diet_plans
        $this->removeDuplicateDietPlans();
        
        // KROK 3: Usuń duplikaty z tabeli users (jeśli są)
        $this->removeDuplicateUsers();

        // KROK 4: Dodaj ograniczenia unique
        Schema::table('menus', function (Blueprint $table) {
            $table->unique('name', 'menus_name_unique');
        });

        Schema::table('diet_plans', function (Blueprint $table) {
            $table->unique('name', 'diet_plans_name_unique');
        });

        // Sprawdź czy email już nie ma unique constraint
        $indexes = DB::select("SHOW INDEX FROM users WHERE Column_name = 'email'");
        $hasUniqueEmail = collect($indexes)->where('Non_unique', 0)->isNotEmpty();
        
        if (!$hasUniqueEmail) {
            Schema::table('users', function (Blueprint $table) {
                $table->unique('email', 'users_email_unique');
            });
        }
    }

    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropUnique('menus_name_unique');
        });

        Schema::table('diet_plans', function (Blueprint $table) {
            $table->dropUnique('diet_plans_name_unique');
        });

        // Sprawdź czy constraint istnieje przed usunięciem
        $indexes = DB::select("SHOW INDEX FROM users WHERE Key_name = 'users_email_unique'");
        if (!empty($indexes)) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique('users_email_unique');
            });
        }
    }

    /**
     * Usuń duplikaty z tabeli menus
     */
    private function removeDuplicateMenus()
    {
        // Znajdź duplikaty
        $duplicates = DB::select("
            SELECT name, COUNT(*) as count 
            FROM menus 
            GROUP BY name 
            HAVING count > 1
        ");

        foreach ($duplicates as $duplicate) {
            echo "Znaleziono duplikat menu: {$duplicate->name} ({$duplicate->count} wystąpień)\n";
            
            // Pobierz wszystkie duplikaty
            $menuDuplicates = DB::table('menus')
                ->where('name', $duplicate->name)
                ->orderBy('id')
                ->get();

            // Zostaw pierwszy, pozostałe przemianuj lub usuń
            foreach ($menuDuplicates->skip(1) as $index => $menu) {
                $newName = $menu->name . ' #' . ($index + 2);
                
                DB::table('menus')
                    ->where('id', $menu->id)
                    ->update(['name' => $newName]);
                    
                echo "Przemianowano '{$menu->name}' na '{$newName}'\n";
            }
        }
    }

    /**
     * Usuń duplikaty z tabeli diet_plans
     */
    private function removeDuplicateDietPlans()
    {
        // Sprawdź czy tabela diet_plans istnieje
        if (!Schema::hasTable('diet_plans')) {
            return;
        }

        $duplicates = DB::select("
            SELECT name, COUNT(*) as count 
            FROM diet_plans 
            GROUP BY name 
            HAVING count > 1
        ");

        foreach ($duplicates as $duplicate) {
            echo "Znaleziono duplikat diet plan: {$duplicate->name} ({$duplicate->count} wystąpień)\n";
            
            $dietPlanDuplicates = DB::table('diet_plans')
                ->where('name', $duplicate->name)
                ->orderBy('id')
                ->get();

            foreach ($dietPlanDuplicates->skip(1) as $index => $dietPlan) {
                $newName = $dietPlan->name . ' #' . ($index + 2);
                
                DB::table('diet_plans')
                    ->where('id', $dietPlan->id)
                    ->update(['name' => $newName]);
                    
                echo "Przemianowano '{$dietPlan->name}' na '{$newName}'\n";
            }
        }
    }

    /**
     * Usuń duplikaty z tabeli users
     */
    private function removeDuplicateUsers()
    {
        $duplicates = DB::select("
            SELECT email, COUNT(*) as count 
            FROM users 
            GROUP BY email 
            HAVING count > 1
        ");

        foreach ($duplicates as $duplicate) {
            echo "Znaleziono duplikat email: {$duplicate->email} ({$duplicate->count} wystąpień)\n";
            
            $userDuplicates = DB::table('users')
                ->where('email', $duplicate->email)
                ->orderBy('id')
                ->get();

            // Zostaw pierwszy, pozostałe usuń (lub przemianuj)
            foreach ($userDuplicates->skip(1) as $index => $user) {
                // Opcja 1: Usuń duplikat
                DB::table('users')->where('id', $user->id)->delete();
                echo "Usunięto duplikat użytkownika: {$user->email} (ID: {$user->id})\n";
                
                // Opcja 2: Przemianuj email (odkomentuj jeśli wolisz przemianować)
                // $newEmail = str_replace('@', '+' . ($index + 1) . '@', $user->email);
                // DB::table('users')->where('id', $user->id)->update(['email' => $newEmail]);
                // echo "Przemianowano email '{$user->email}' na '{$newEmail}'\n";
            }
        }
    }
};