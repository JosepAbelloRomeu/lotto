<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkingDay extends Model
{
    protected $fillable = ['_id', 'league_date', 'season', 'working_day'];

    protected $dates = ['league_date'];

    public function historics()
    {
        return $this->hasMany(Historic::class);
    }
}
