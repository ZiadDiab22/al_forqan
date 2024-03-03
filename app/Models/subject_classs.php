<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subject_classs extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'class_id', 'subject_id'
    ];
}
