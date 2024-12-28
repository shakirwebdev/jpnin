<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Krt_Kanta_Komuniti extends Model
{
    protected $table = "krt__kanta_komuniti";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'state_id',
                            'daerah_id',
                            'kanta_nama',
                            'kanta_alamat',
                            'kanta_jenis_kediaman_1',
                            'kanta_jenis_kediaman_2',
                            'kanta_jenis_kediaman_3',
                            'kanta_jenis_kediaman_4',
                            'kanta_sejarah_lokasi',
                            'kanta_kelebihan_lokasi',
                            'kanta_kemudahan',
                            'status',
                            'dihantar_by',
                            'dihantar_date',
                            'disemak_by',
                            'disemak_date',
                            'disemak_note',
                            'disahkan_by',
                            'disahkan_date',
                            'disahkan_note'
                        ];
}
