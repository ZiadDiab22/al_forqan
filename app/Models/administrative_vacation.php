<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class administrative_vacation extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'emp_id', 'date',
        'duration', 'reason'
    ];
}
