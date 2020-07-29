<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentAltName extends Model
{
    protected $fillable = ['alt_name', 'agent_id'];

    protected $table = 'agent_alt_names';

    public $timestamps = false;
}
