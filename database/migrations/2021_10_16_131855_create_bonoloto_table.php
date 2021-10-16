<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonolotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonoloto', function (Blueprint $table) {
            $table->id();
            $table->string('raffle_date');
            $table->integer('raffle');
            $table->integer('ball_0')->nullable();
            $table->integer('ball_1')->nullable();
            $table->integer('ball_2')->nullable();
            $table->integer('ball_3')->nullable();
            $table->integer('ball_4')->nullable();
            $table->integer('ball_5')->nullable();
            $table->integer('reinteger')->nullable();
            $table->integer('complementary')->nullable();
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
        Schema::dropIfExists('bonoloto');
    }
}
