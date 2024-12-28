<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Profile_Skuad_Uniti extends Model
{
    protected $table = "krt__profile_skuad_uniti";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id',
                            'skuad_nama', 
                            'skuad_tarikh_ditubuhkan', 
                            'skuad_skop_perkhidmatan',
                            'skuad_nama_ketua',
                            'skuad_ic_ketua',
                            'skuad_email_ketua',
                            'skuad_phone_ketua',
                            'skuad_alamat_ketua',
                            'skuad_pekerjaan_ketua',
                            'skuad_nama_setiausaha',
                            'skuad_ic_setiausaha',
                            'skuad_phone_setiausaha',
                            'skuad_email_setiausaha',
                            'skuad_alamat_setiausaha',
                            'skuad_pekerjaan_setiausaha',
                            'status',
                            'dihantar_by',
                            'dihantar_date',
                            'disemak_by',
                            'disemak_date',
                            'disemak_note',
                            'diakui_by',
                            'diakui_date',
                            'diakui_note'
                        ];
}
