<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkingDay extends Model
{
    protected $fillable = ['_id', 'league_date', 'season', 'modality', 'working_day'];

    public function historics()
    {
        return $this->hasMany(Historic::class);
    }
}
