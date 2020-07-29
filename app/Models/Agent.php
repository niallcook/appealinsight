<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = ['name'];

    protected $table = 'agents';

    public $timestamps = false;
}
