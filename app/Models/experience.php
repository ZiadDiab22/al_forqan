<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class experience extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'emp_id', 'subject_id', 'class_id', 'year', 'hours_num'
    ];
}
