<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeOfAppeal extends Model
{
    protected $fillable = ['name'];

    protected $table = 'types_of_appeals';

    public $timestamps = false;
}
