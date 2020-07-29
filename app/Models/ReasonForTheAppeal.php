<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReasonForTheAppeal extends Model
{
    protected $fillable = ['name'];

    protected $table = 'reasons_for_the_appeal';

    public $timestamps = false;
}
