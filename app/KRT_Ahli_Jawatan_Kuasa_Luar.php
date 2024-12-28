<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Ahli_Jawatan_Kuasa_Luar extends Model
{
    protected $table = "krt__ahli_jawatan_kuasa_luar";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id', 
                            'ajk_luar_nama', 
                            'ajk_luar_ic',
                            'ajk_luar_alamat',
                            'ajk_luar_miliki_perniagaan',
                            'ajk_luar_miliki_keluarga',
                            'ajk_luar_miliki_pekerjaan',
                            'ajk_luar_miliki_jawatan',
                            'ajk_luar_miliki_kepentingan',
                            'ajk_luar_note',
                            'ajk_luar_status',
                            'direkod_by',
                            'direkod_date',
                            'disahkan_by',
                            'disahkan_date',
                            'disahkan_note',
                        ];
}
