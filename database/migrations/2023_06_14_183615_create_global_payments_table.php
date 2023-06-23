<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobalPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_payments', function (Blueprint $table) {
            $table->id('monthly_payment_id');
            $table->integer('monthly_payment_date');
            $table->decimal('monthly_total', 8, 2);
            $table->decimal('monthly_paid', 8, 2);
            $table->decimal('monthly_payment', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('global_payments');
    }
}
