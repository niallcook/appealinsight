<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteCountry extends Model
{
    protected $fillable = ['name'];

    protected $table = 'site_countries';

    public $timestamps = false;
}
