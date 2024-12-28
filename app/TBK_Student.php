<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TBK_Student extends Model
{
    protected $table = "tbk__student";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'tabika_id', 
                            'student_nama', 
                            'student_mykid',
                            'student_sijil_lahir',
                            'student_tarikh_lahir',
                            'student_agama_id',
                            'student_jantina_id',
                            'student_kaum_id',
                            'student_kesihatan',
                            'student_alamat',
                            'student_jarak_rumah',
                            'bapa_nama',
                            'bapa_ic',
                            'bapa_pekerjaan',
                            'bapa_profession_id',
                            'bapa_pendapatan',
                            'bapa_alamat_office',
                            'bapa_phone_office',
                            'bapa_kerakyatan_id',
                            'bapa_phone',
                            'bapa_jumlah_pendapatan',
                            'bapa_phone_rumah',
                            'ibu_nama',
                            'ibu_ic',
                            'ibu_pekerjaan',
                            'ibu_profession_id',
                            'ibu_pendapatan',
                            'ibu_alamat_office',
                            'ibu_phone_office',
                            'ibu_kerakyatan_id',
                            'ibu_phone',
                            'ibu_jumlah_pendapatan',
                            'ibu_jumlah_pendapatan_lain',
                            'ibu_phone_rumah',
                            'ibu_bil_anak',
                            'ibu_bil_anak_sekolah',
                            'ibu_hubungan_student',
                            'ibu_tabika_lain',
                            'ibu_pilihan',
                            'student_status',
                            'dihantar_by',
                            'dihantar_date',
                        ];
}
