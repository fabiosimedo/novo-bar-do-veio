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
            $table->bigIncrements('saled_id');
            $table->string('saled_name');
            $table->integer('saled_qtty');
            $table->decimal('saled_price', 6, 2);
            $table->decimal('saled_total', 6, 2);
            $table->string('saled_saler');
            $table->string('saled_receiver');
            $table->integer('saled_date');
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
