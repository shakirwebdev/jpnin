<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Ahli_Jawatan_Kuasa_Cawangan extends Model
{
    protected $table = "krt__ahli_jawatan_kuasa_cawangan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id', 
                            'cawangan_id', 
                            'ajk_nama',
                            'ajk_ic',
                            'ajk_tarikh_lahir',
                            'jantina_id',
                            'kaum_id',
                            'ajk_poskod',
                            'ajk_phone',
                            'ajk_email',
                            'status_perkahwinan_id',
                            'jawatan_cawangan_id',
                            'status_perkejaan_id',
                            'ajk_pekerjaan_jawatan',
                            'ajk_pekerjaan_bidang',
                            'ajk_pekerjaan_pengalaman',
                            'ajk_kemahiran',
                            'ajk_minat',
                            'ajk_status',
                            'ajk_status_form',
                            'direkod_by',
                            'direkod_date',
                            'disemak_by',
                            'disemak_date',
                            'disemak_note',
                            'diakui_by',
                            'diakui_date',
                            'diakui_note'
                        ];
}
