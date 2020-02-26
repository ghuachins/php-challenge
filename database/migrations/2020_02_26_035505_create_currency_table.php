<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency', function (Blueprint $table) {
            $table->string('id', 3)->primary();
            $table->string('name', 60);
            $table->string('symbol', 10);
            $table->mediumInteger('decimalPlaces')->default(2);
            $table->string('decimalSeparator', 2)->default('.');
            $table->string('thousandSeparator', 2)->default(',');
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
        Schema::dropIfExists('currency');
    }
}
