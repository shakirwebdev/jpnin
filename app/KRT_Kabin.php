<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Kabin extends Model
{
    protected $table = "krt__kabin";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profileID', 
                            'kabin_jenis', 
                            'kabin_sumbangan_lain',
                            'kabin_alamat',
                            'kabin_status_tanah_id',
                            'kabin_tarikh_bina',
                            'kabin_kos',
                            'kabin_pengguna_rt',
                            'kabin_pengguna_srs',
                            'kabin_pengguna_tabika',
                            'kabin_pengguna_taska',
                            'kabin_isu',
                        ];
}
