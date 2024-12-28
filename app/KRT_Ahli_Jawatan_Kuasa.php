<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Ahli_Jawatan_Kuasa extends Model
{
    protected $table = "krt__ahli_jawatan_kuasa";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id', 
							'ajk_penggal',
                            'ajk_nama', 
                            'ajk_ic',
                            'ajk_tarikh_lahir',
                            'ajk_kaum',
                            'ajk_jantina',
                            'ajk_warganegara',
                            'ajk_agama',
                            'ajk_phone',
                            'ajk_alamat',
                            'ajk_poskod',
                            'ajk_profession_id',
                            'ajk_pendidikan_id',
                            'ajk_status',
                            'ajk_tarikh_mula',
                            'ajk_tarikh_akhir',
                            'ajk_bekepentingan',
                            'ajk_bekepentingan_interaksi_1',
                            'ajk_bekepentingan_interaksi_2',
                            'ajk_bekepentingan_interaksi_3',
                            'ajk_bekepentingan_interaksi_4',
                            'ajk_bekepentingan_interaksi_5',
                            'ajk_berkepentingan_keterangan',
                            'file_avatar',
                            'ajk_status',
                            'ajk_status_form',
                            'direkodby_user_id',
                            'direkod_date',
                            'disahkan_by',
                            'disahkan_date',
                            'disahkan_note',
                        ];
}
