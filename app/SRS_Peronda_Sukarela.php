<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRS_Peronda_Sukarela extends Model
{
    protected $table = "srs__senarai_peronda_sukarela";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'srs_profile_id', 
                            'peronda_nama', 
                            'peronda_kad',
                            'jantina_id',
                            'p_sukarela_pekerjaan',
                            'p_sukarela_alamat_k'
                        ];
}
