<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Krt_Bagunan_Sewa extends Model
{
    protected $table = "krt__bagunan_sewa";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profileID', 
                            'jenis_premis_id', 
                            'sewa_alamat',
                            'sewa_pengguna_rt',
                            'sewa_pengguna_srs',
                            'sewa_pengguna_tabika',
                            'sewa_pengguna_taska',
                            'sewa_isu',
                            'sewa_bayaran',
                        ];
}
