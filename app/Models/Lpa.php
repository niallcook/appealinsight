<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lpa extends Model
{
    protected $fillable = ['name', 'ons_lpa_code'];

    protected $table = 'lpas';

    public $timestamps = false;
}
