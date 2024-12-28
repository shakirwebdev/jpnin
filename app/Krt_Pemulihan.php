<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Krt_Pemulihan extends Model
{
    protected $table = "krt__pemulihan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id',
                            'pemulihan_tempoh_bulan',
                            'pemulihan_punca_tidak_aktif',
                            'pemulihan_suku_thn_1',
                            'pemulihan_suku_thn_2',
                            'pemulihan_suku_thn_3',
                            'pemulihan_suku_thn_4',
                            'pemulihan_tempoh_pelaksanaan',
                            'pemulihan_cadangan_ppd',
                            'pemulihan_cadangan_hq',
                            'pemulihan_markah',
                            'status',
                            'dihantar_by',
                            'dihantar_date',
                            'disemak_by',
                            'disemak_date',
                            'disemak_note'
                        ];
}
