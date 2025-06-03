<?php
// filepath: c:\Users\kosow\Desktop\catering_dietetyczny\lavarel\database\migrations\2023_06_03_create_diet_plans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diet_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price_per_day', 8, 2);
            $table->string('icon')->nullable(); // Klasa ikony Font Awesome
            $table->string('image')->nullable(); // Opcjonalny obrazek
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diet_plans');
    }
};