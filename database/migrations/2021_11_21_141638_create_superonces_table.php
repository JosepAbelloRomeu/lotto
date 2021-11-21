<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuperoncesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('superonces', function (Blueprint $table) {
            $table->id();
            $table->string('raffle_date');
            $table->integer('raffle');
            $table->integer('number_0')->nullable();
            $table->integer('number_1')->nullable();
            $table->integer('number_2')->nullable();
            $table->integer('number_3')->nullable();
            $table->integer('number_4')->nullable();
            $table->integer('number_5')->nullable();
            $table->integer('number_6')->nullable();
            $table->integer('number_7')->nullable();
            $table->integer('number_8')->nullable();
            $table->integer('number_9')->nullable();
            $table->integer('number_10')->nullable();
            $table->integer('number_11')->nullable();
            $table->integer('number_12')->nullable();
            $table->integer('number_13')->nullable();
            $table->integer('number_14')->nullable();
            $table->integer('number_15')->nullable();
            $table->integer('number_16')->nullable();
            $table->integer('number_17')->nullable();
            $table->integer('number_18')->nullable();
            $table->integer('number_19')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('superonces');
    }
}
