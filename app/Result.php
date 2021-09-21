<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['local', 'visitor', 'wins', 'ties', 'loses'];
}
