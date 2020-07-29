<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DevelopmentType extends Model
{
    protected $fillable = ['name'];

    protected $table = 'development_types';

    public $timestamps = false;
}
