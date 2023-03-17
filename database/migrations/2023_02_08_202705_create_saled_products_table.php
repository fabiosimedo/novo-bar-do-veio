<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaledProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saled_products', function (Blueprint $table) {
            $table->id('saled_id');
            $table->string('saled_name');
            $table->integer('saled_qtty');
            $table->decimal('saled_price', 6, 2);
            $table->integer('saled_client');
            $table->string('saler');
            $table->date('saled_date');
            $table->boolean('saled_paid')->default(false);
            $table->string('saled_receiver');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saled_products');
    }
}
