<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_Spk_Peringkat_Kes extends Model
{
    protected $table = "ref__spk_peringkat_kes";
    protected $primaryKey = 'id';
    protected $fillable = ['peringkat_description','status'];
}
