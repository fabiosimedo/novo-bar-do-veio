<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->double('kaiser_600ml',10,2);
            $table->double('kaiser_lata',10,2);
            $table->double('kaiser_latao',10,2);
            $table->double('skol_600ml',10,2);
            $table->double('skol_latao',10,2);
            $table->double('skol_litrinho',10,2);
            $table->double('itaipava_litrinho',10,2);
            $table->double('itaipava_lata',10,2);
            $table->double('outra_600ml',10,2);
            $table->double('vinho_copo',10,2);
            $table->double('dose',10,2);
            $table->double('sodinha',10,2);
            $table->double('refri_lata',10,2);
            $table->double('sinuca',10,2);
            $table->double('cigarro_solto',10,2);
            $table->double('dinheiro_valor',10,2);
            $table->text('dinheiro_descricao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
