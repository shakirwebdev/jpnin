<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK_imediator extends Model
{
    protected $table = "spk__imediator";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'hasRT',
                            'user_id', 
                            'krt_profile_id', 
                            'mkp_pemohon_tarikh_lahir',
                            'mkp_pemohon_state_id',
                            'mkp_pemohon_daerah_id',
                            'mkp_pemohon_parlimen_id',
                            'mkp_pemohon_dun_id',
                            'mkp_pemohon_pbt_id',
                            'mkp_pemohon_mukim_id',
                            'mkp_pemohon_jantina_id',
                            'mkp_pemohon_kaum_id',
                            'mkp_pemohon_alamat',
                            'mkp_pemohon_alamat_p',
                            'mkp_pemohon_no_phone_p',
                            'mkp_pemohon_kategori_id',
                            'mkp_pemohon_tahap_id',
                            'mkp_pemohon_akademik',
                            'mkp_pemohon_khusus',
                            'mkp_tarikh_dilantik',
                            'mkp_file_avatar',
                            'status',
                            'dihantar_by',
                            'dihantar_date',
                            'disokong_by',
                            'disokong_date',
                            'disokong_note',
                            'disokong_p_by',
                            'disokong_p_date',
                            'disokong_p_note',
                            'disemak_by',
                            'disemak_date',
                            'disemak_note',
                            'dilulus_by',
                            'dilulus_date',
                            'dilulus_note',
                            'dilantik_by',
                            'dilantik_date',
                            'dilantik_note',
                        ];
}
