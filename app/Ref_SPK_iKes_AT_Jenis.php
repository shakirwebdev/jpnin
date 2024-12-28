<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ref_SPK_iKes_AT_Jenis extends Model
{
    protected $table = "ref__spk_ikes_at_jenis";
    protected $primaryKey = 'id';
    protected $fillable = ['jenis_description', 'status'];
}
