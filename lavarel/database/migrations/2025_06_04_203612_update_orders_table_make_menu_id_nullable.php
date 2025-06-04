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
        // Usuń ograniczenie foreign key
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
        });

        // Zmień kolumnę na nullable
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_id')->nullable()->change();
        });

        // Dodaj ponownie klucz obcy z opcją null
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('menu_id')
                  ->references('id')
                  ->on('menus')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Usuń ograniczenie foreign key
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
        });

        // Zmień kolumnę z powrotem na not nullable
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_id')->nullable(false)->change();
        });

        // Dodaj ponownie klucz obcy bez opcji null
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('menu_id')
                  ->references('id')
                  ->on('menus');
        });
    }
};