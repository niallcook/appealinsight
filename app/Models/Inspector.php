<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspector extends Model
{
    protected $fillable = ['name'];

    protected $table = 'inspectors';

    public $timestamps = false;
}
