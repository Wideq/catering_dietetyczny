<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Modyfikacja istniejącego ograniczenia - menu_id może być null
            $table->foreignId('menu_id')->nullable()->change();
            
            // Dodanie nowych kolumn
            $table->unsignedBigInteger('diet_plan_id')->nullable()->after('menu_id');
            $table->string('item_type')->default('menu')->after('price'); // 'menu' lub 'diet_plan'
            $table->integer('duration')->nullable()->after('item_type');
            $table->date('start_date')->nullable()->after('duration');
            $table->text('notes')->nullable()->after('start_date');
            
            // Dodanie klucza obcego dla diet_plan_id
            $table->foreign('diet_plan_id')->references('id')->on('diet_plans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Usunięcie klucza obcego
            $table->dropForeign(['diet_plan_id']);
            
            // Usunięcie nowych kolumn
            $table->dropColumn([
                'diet_plan_id',
                'item_type',
                'duration',
                'start_date',
                'notes'
            ]);
            
            // Przywrócenie ograniczenia not null dla menu_id
            $table->foreignId('menu_id')->nullable(false)->change();
        });
    }
};