<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMenuIdToNullableInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Usuń obecny klucz obcy
            $table->dropForeign(['menu_id']);
            
            // Zmień kolumnę na nullable
            $table->unsignedBigInteger('menu_id')->nullable()->change();
            
            // Dodaj ponownie klucz obcy z opcją nullable
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
            $table->unsignedBigInteger('menu_id')->nullable(false)->change();
            $table->foreign('menu_id')->references('id')->on('menus');
        });
    }
}