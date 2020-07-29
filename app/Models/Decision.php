<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Decision extends Model
{

    protected $fillable = ['name', 'decision_type'];

    protected $table = 'decisions';

    public $timestamps = false;

    public function getDecisionTypeAttribute()
    {
        switch ($this->decision_type) {
            case 'Quashed on Legal Grounds':
            case 'Planning Permission Granted':
            case 'Notice Quashed':
            case 'Allowed with Conditions':
            case 'Allowed':
            case 'Allowed in Part':
                return 'successful';
            case 'Notice Varied and Upheld':
            case 'Notice Upheld':
            case 'Dismissed':
                return 'failed';
            case 'Unknown':
            case 'Turned Away':
            case 'Split Decision':
            case 'Invalid':
            case 'Appeal Withdrawn':
                return 'unknown';
            default:
                return null;
        }
    }
}
