<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nodes extends Model
{
    protected $table = 'nodes';

    public function sensors()
    {
        return $this->hasMany('App\Sensors', 'node_id')->orderBy('name');
    }
}
