<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixProductClicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if table exists
        if (Schema::hasTable('product_clicks')) {
            // Drop and recreate with correct structure
            Schema::dropIfExists('product_clicks');
        }

        // Create table with proper structure
        Schema::create('product_clicks', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->unsignedBigInteger('product_id');
            $table->date('date');
            $table->timestamps();

            // Add index for better performance
            $table->index(['product_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_clicks');
    }
}
