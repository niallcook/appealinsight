<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Decision extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;
}
