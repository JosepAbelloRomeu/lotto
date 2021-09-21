<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historic extends Model
{
    protected $fillable = ['_id', 'local','visitor','result'];
}
