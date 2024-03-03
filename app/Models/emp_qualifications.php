<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emp_qualifications extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'emp_id', 'name', 'resource',
        'note', 'date'
    ];
}
