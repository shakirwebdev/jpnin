<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_SPK_MKP_Mediasi extends Model
{
    protected $table = "ref__spk_mkp_mediasi";
    protected $primaryKey = 'id';
    protected $fillable = ['kluster_description','status'];
}
