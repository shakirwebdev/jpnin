<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Profile_Skuad_Uniti_Jaringan extends Model
{
    protected $table = "krt__profile_skuad_uniti_jaringan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'skuad_uniti_id', 
                            'jaringan_agensi_nama', 
                            'jaringan_nama_pegawai', 
                            'jaringan_no_telefon',
                            'jaringan_kerjasama',
                        ];
}
