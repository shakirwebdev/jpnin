<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_SPK_MKP_Tahap extends Model
{
    protected $table = "ref__spk_mkp_tahap";
    protected $primaryKey = 'id';
    protected $fillable = ['tahap_description','status'];
}
