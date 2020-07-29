<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteCounty extends Model
{
    protected $fillable = ['name'];

    protected $table = 'site_counties';

    public $timestamps = false;
}
