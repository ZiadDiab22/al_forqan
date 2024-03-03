<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'sector_id', 'name', 'tele_num', 'autograph_photo',
        'mobile_num', 'address', 'birth_date', 'work', 'from',
        'birth_city', 'father_name', 'nationality_id',
        'mother_name', 'subject', 'contracted', 'active',
        'childs_num', 'rest_place', 'comp_num', 'nat_num',
        'AppBook_num', 'AppBook_date', 'start_date', 'social_status_id',
        'leave_date', 'military', 'military_rank', 'school'
    ];
}
