<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historic extends Model
{
    protected $fillable = ['working_day_id', 'local','visitor','result','resultWithGoals'];
}
