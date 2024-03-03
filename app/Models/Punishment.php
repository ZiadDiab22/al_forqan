<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Punishment extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'emp_id', 'name', 'resourse',
        'note', 'date', 'type'
    ];
}
