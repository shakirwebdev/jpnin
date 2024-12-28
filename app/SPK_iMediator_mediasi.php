<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK_iMediator_mediasi extends Model
{
    protected $table = "spk__imediator_mediasi";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'ref_mkp_kategori_id', 
                            'mediasi_tarikh', 
                            'mediasi_alamat',
                            'spk_imediator_id',
                            'mediasi_pembantu_nama',
                            'mediasi_pembantu_ic',
                            'mediasi_pembantu_phone',
                            'mediasi_ngo_terlibat',
                            'mediasi_ringkasan_kes',
                            'ref_spk_mkp_peringkat_id',
                            'mediasi_status_kes',
                            'mediasi_note_penyelesaian_kes',
                            'mediasi_note_sebab_kes_xberjaya',
                            'status',
                            'disokong_by',
                            'disokong_date',
                            'disokong_note',
                            'disokong_p_by',
                            'disokong_p_date',
                            'disokong_p_note',
                            'disahkan_by',
                            'disahkan_date',
                            'disahkan_note',
                            'disemak_by',
                            'disemak_date',
                            'disemak_note',
                            'diluluskan_by',
                            'diluluskan_date',
                            'diluluskan_note',
                        ];
}
