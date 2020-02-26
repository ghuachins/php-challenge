<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeRateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_rate', function (Blueprint $table) {
            $table->primary(['currencyIdFrom', 'currencyIdTo']);
            $table->string('currencyIdFrom');
            $table->string('currencyIdTo');
            $table->double('rate');
            $table->timestamps();

            $table->foreign('currencyIdFrom')->references('id')->on('currency')->onDelete('cascade');
            $table->foreign('currencyIdTo')->references('id')->on('currency')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchange_rate');
    }
}
