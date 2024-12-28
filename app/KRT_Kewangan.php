<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Kewangan extends Model
{
    protected $table = "krt__kewangan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id', 
                            'kewangan_no_acc', 
                            'kewangan_nama_bank',
                            'kewangan_no_evendor',
                            'kewangan_jenis_kewangan',
                            'kewangan_nama_penuh',
                            'kewangan_alamat',
                            'kewangan_butiran',
                            'kewangan_tarikh_t_b',
                            'kewangan_masa_t_b',
                            'kewangan_jumlah_tunai',
                            'kewangan_jumlah_bank',
                            'kewangan_baki_tunai',
                            'kewangan_baki_bank',
                            'kewangan_jumlah_baki',
                            'kewangan_status',
                            'direkodby',
                            'rekod_date',
                            'semakby',
                            'semak_date',
                            'semak_noted',
                            'sahby',
                            'sah_date',
                            'sah_noted',
                        ];
}
