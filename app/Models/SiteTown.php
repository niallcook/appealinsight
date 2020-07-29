<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteTown extends Model
{
    protected $fillable = ['name'];

    protected $table = 'site_towns';

    public $timestamps = false;
}
