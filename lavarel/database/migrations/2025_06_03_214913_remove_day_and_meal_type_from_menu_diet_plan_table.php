<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('menu_diet_plan', function (Blueprint $table) {
        $table->dropColumn('meal_type');
        $table->dropColumn('day');
    });
}

public function down()
{
    Schema::table('menu_diet_plan', function (Blueprint $table) {
        $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack', 'supper'])->after('menu_id');
        $table->integer('day')->after('meal_type');
    });
}
};
