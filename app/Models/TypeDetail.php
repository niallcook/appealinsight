<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeDetail extends Model
{
    protected $fillable = ['name'];

    protected $table = 'types_detail';

    public $timestamps = false;
}
