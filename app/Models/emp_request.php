<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emp_request extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_type_id', 'name', 'tele_num',
        'mobile_num', 'address', 'birth_date',
        'wanted_work', 'rating', 'current_work',
        'academic_qualification', 'certificate_photo',
        'identity_photo',
        'social_status_id', 'military_service_id'
    ];

    public function empExps()
    {
        return $this->hasMany(emp_exp::class, 'request_id');
    }
}
