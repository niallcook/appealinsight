<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    protected $fillable = ['name'];

    protected $table = 'procedures';

    public $timestamps = false;
}
