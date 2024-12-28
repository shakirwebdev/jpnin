<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Aktiviti_Laporan extends Model
{
    protected $table = "krt__aktiviti_laporan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id', 
                            'state_id', 
                            'daerah_id',
                            'aktiviti_tempat',
                            'aktiviti_kawasan_DL',
                            'aktiviti_penganjur',
                            'bahagian_id',
                            'pmk_id',
                            'aktiviti_tajuk',
                            'aktiviti_tarikh',
                            'aktiviti_tarikh_rancang',
                            'aktiviti_masa',
                            'agenda_id',
                            'bidang_id',
                            'sub_bidang_id',
                            'teras_id',
                            'strategi_id',
                            'aktiviti_kategori_pemulihan',
                            'aktiviti_kategori_pencegahan',
                            'jenis_aktiviti_id',
                            'aktiviti_pembelanjaan',
                            'kewangan_id',
                            'aktiviti_sasar',
                            'aktiviti_perasmi',
                            'aktiviti_status',
                            'dihantar_by',
                            'dihantar_date',
                            'disahkan_by',
                            'disahkan_date',
                            'disahkan_note',
                        ];
}
