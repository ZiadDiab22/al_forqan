<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teaching_request extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_type_id', 'name', 'tele_num',
        'mobile_num', 'address', 'birth_date',
        'birth_city', 'rating', 'nationality_id',
        'academic_qualification', 'issuing_authority',
        'acquisition_year', 'study_place',
        'social_status_id', 'military_service_id',
    ];

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public function militaryService()
    {
        return $this->belongsTo(MilitaryService::class);
    }

    public function socialStatus()
    {
        return $this->belongsTo(SocialStatus::class);
    }
    public function teachExps()
    {
        return $this->hasMany(teacher_exp::class, 'request_id');
    }
}
