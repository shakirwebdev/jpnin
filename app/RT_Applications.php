<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RT_Applications extends Model
{
    protected $table = "rt__applications";
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_fullname',
        'no_ic',
        'no_phone',
        'user_address',
        'daerah_id',
        'state_id',
        'krt_name',
        'krt_note',
        'is_edit',
        'submitby_user_id'
    ];
}
