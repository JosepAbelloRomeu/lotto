<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historic extends Model
{
    protected $fillable = ['_id', 'league_date', 'local','visitor','result'];

    protected $dates = ['league_date'];
}
