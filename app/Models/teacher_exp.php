<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teacher_exp extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'years_num', 'to_date', 'from_date',
        'work_place', 'work', 'request_id'
    ];

    public function teachRequest()
    {
        return $this->belongsTo(teaching_request::class);
    }
}
