<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appellant extends Model
{
    protected $fillable = ['name'];

    protected $table = 'appellants';

    public $timestamps = false;
}
