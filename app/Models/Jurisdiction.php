<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurisdiction extends Model
{
    protected $fillable = ['name'];

    protected $table = 'jurisdictions';

    public $timestamps = false;
}
