<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Bagunan_Tumpang extends Model
{
    protected $table = "krt__bagunan_tumpang";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profileID', 
                            'tumpang_jenis_premis_id', 
                            'tumpang_alamat',
                            'tumpang_pengguna_rt',
                            'tumpang_pengguna_srs',
                            'tumpang_pengguna_tabika',
                            'tumpang_pengguna_taska',
                            'tumpang_status_tanah_id',
                        ];
}
