<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Krt_Keaktifan extends Model
{
    protected $table = "krt__keaktifan";
    protected $primaryKey = 'id';
    protected $fillable = ['krt_profile_id','keaktifan_markah','status','tahun'];
}
