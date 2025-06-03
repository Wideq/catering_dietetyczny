<?php
// filepath: c:\Users\kosow\Desktop\catering_dietetyczny\lavarel\database\migrations\2023_06_03_create_menu_diet_plan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_diet_plan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diet_plan_id')->constrained()->onDelete('cascade');
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack', 'supper']);
            $table->integer('day')->comment('Dzień tygodnia (1-7)');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_diet_plan');
    }
};