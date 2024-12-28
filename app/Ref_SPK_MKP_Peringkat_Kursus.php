<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_SPK_MKP_Peringkat_Kursus extends Model
{
    protected $table = "ref__spk_mkp_peringkat_kursus";
    protected $primaryKey = 'id';
    protected $fillable = ['peringkat_description','status'];
}
