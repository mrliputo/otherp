<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensors extends Model
{
    protected $table = 'sensors';
    public $timestamps = false;

    public function values()
    {
        return $this->hasMany('App\SensorValues', 'sensor_id')->orderBy('created_at');
    }
}
