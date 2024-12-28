<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Aktiviti_Sub_Bidang extends Model
{
    protected $table = "ref__aktiviti_sub_bidang";
    protected $primaryKey = 'id';
    protected $fillable = ['bidang_id', 'sub_bidang_description', 'status'];
}
