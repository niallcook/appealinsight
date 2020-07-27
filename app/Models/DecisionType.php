<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DecisionType extends Model
{
    protected $fillable = ['decision_id', 'name'];
    public $timestamps = false;
}
