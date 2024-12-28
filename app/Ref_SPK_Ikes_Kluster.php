<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_SPK_Ikes_Kluster extends Model
{
    protected $table = "ref__spk_ikes_kluster";
    protected $primaryKey = 'id';
    protected $fillable = ['kluster_description','status'];
}
