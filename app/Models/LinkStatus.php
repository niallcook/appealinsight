<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkStatus extends Model
{
    protected $fillable = ['name'];

    protected $table = 'link_statuses';

    public $timestamps = false;
}
