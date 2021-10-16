<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bonoloto extends Model
{
    protected $table = 'bonoloto';

    protected $fillable = ['raffle_date', 'raffle', 'ball_0', 'ball_1', 'ball_2', 'ball_3', 'ball_4', 'ball_5', 'reinteger', 'complementary'];
}
