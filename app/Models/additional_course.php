<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class additional_course extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name', 'request_id', 'request_type_id'
    ];
}
