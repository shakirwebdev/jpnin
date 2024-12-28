<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_SPK_MKP_Mediasi_Status extends Model
{
    protected $table = "ref__spk_mkp_mediasi_status";
    protected $primaryKey = 'id';
    protected $fillable = ['status_description','status'];
}
