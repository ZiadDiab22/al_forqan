<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emp_exp extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name', 'request_id'
    ];

    public function empRequest()
    {
        return $this->belongsTo(emp_request::class);
    }
}
