<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Aktiviti extends Model
{
    protected $table = "ref__aktiviti";
    protected $primaryKey = 'id';
    protected $fillable = ['sub_bidang_id','aktiviti_description', 'status'];
}
