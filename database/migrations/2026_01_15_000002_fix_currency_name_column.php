<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixCurrencyNameColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Increase currency_name column size in orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->string('currency_name', 50)->nullable()->change();
        });

        // 2. Fix the typo in currencies table
        DB::table('currencies')
            ->where('name', 'Joradainain Dinar')
            ->update(['name' => 'Jordanian Dinar']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('currency_name', 10)->nullable()->change();
        });
    }
}
