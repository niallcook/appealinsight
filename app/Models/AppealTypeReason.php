<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppealTypeReason extends Model
{
    protected $fillable = ['name'];

    protected $table = 'appeal_type_reasons';

    public $timestamps = false;
}
