<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class previous_subject extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name', 'request_id'
    ];
}
