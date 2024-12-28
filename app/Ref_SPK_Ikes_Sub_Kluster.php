<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_SPK_Ikes_Sub_Kluster extends Model
{
    protected $table = "ref__spk_ikes_sub_kluster";
    protected $primaryKey = 'id';
    protected $fillable = ['kluster_id', 'subkluster_description', 'status'];
}
