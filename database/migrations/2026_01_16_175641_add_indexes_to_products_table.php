<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Add indexes for frequently queried columns
            $table->index('product_type', 'idx_product_type');
            $table->index('status', 'idx_status');
            $table->index(['product_type', 'status'], 'idx_product_type_status');
            $table->index('created_at', 'idx_created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop indexes
            $table->dropIndex('idx_product_type');
            $table->dropIndex('idx_status');
            $table->dropIndex('idx_product_type_status');
            $table->dropIndex('idx_created_at');
        });
    }
}
