<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->integer('calories')->nullable()->after('price')->comment('Kalorie w kcal');
            $table->decimal('protein', 5, 2)->nullable()->after('calories')->comment('Białko w gramach');
            $table->decimal('carbs', 5, 2)->nullable()->after('protein')->comment('Węglowodany w gramach');
            $table->decimal('fat', 5, 2)->nullable()->after('carbs')->comment('Tłuszcze w gramach');
            $table->decimal('fiber', 5, 2)->nullable()->after('fat')->comment('Błonnik w gramach');
        });
    }

    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn(['calories', 'protein', 'carbs', 'fat', 'fiber']);
        });
    }
};