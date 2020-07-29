<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppellantAltName extends Model
{
    protected $fillable = ['alt_name', 'appellant_id'];

    protected $table = 'appellant_alt_names';

    public $timestamps = false;
}
