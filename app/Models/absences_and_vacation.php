<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absences_and_vacation extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'emp_id', 'from', 'to',
        'duration', 'reason'
    ];
}
