<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'status')) {
                $table->string('status')->after('description'); 
            }
            if (!Schema::hasColumn('transactions', 'order_id')) {
                $table->unsignedBigInteger('order_id')->after('id'); 
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            }
            if (!Schema::hasColumn('transactions', 'payment_method')) {
                $table->string('payment_method')->after('status'); 
            }
            if (!Schema::hasColumn('transactions', 'payment_date')) {
                $table->timestamp('payment_date')->default(DB::raw('CURRENT_TIMESTAMP'))->after('payment_method'); // Dodaj kolumnę 'payment_date'
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('transactions', 'order_id')) {
                $table->dropForeign(['order_id']);
                $table->dropColumn('order_id');
            }
            if (Schema::hasColumn('transactions', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
            if (Schema::hasColumn('transactions', 'payment_date')) {
                $table->dropColumn('payment_date');
            }
        });
    }
};