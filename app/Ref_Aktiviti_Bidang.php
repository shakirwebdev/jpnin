<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Aktiviti_Bidang extends Model
{
    protected $table = "ref__aktiviti_bidang";
    protected $primaryKey = 'id';
    protected $fillable = ['agenda_id', 'bidang_description', 'status'];
}
