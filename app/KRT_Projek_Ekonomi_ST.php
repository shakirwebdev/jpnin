<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Projek_Ekonomi_ST extends Model
{
    protected $table = "krt__projek_ekonomi_st";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id',
                            'projek_st_nama', 
                            'projek_st_kategori',
                            'projek_st_cabaran',
                            'projek_st_peruntukan_jabatan',
                            'projek_st_tahun',
                            'projek_st_pendapatan',
                            'projek_st_pembelanjaan',
                            'status',
                            'dihantar_by',
                            'dihantar_date',
                            'disemak_by',
                            'disemak_date',
                            'disemak_note',
                            'disahkan_by',
                            'disahkan_date',
                            'disahkan_note',
                        ];
}
