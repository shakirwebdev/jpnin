<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Aktiviti_Sub extends Model
{
    protected $table = "ref__aktiviti_sub";
    protected $primaryKey = 'id';
    protected $fillable = ['aktiviti_id','sub_aktiviti_description', 'status'];
}
