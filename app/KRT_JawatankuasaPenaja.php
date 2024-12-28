<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_JawatankuasaPenaja extends Model
{
    protected $table = "krt__senarai_jawatankuasa_penaja";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profileID', 
                            'penaja_nama', 
                            'penaja_ic',
                            'penaja_birth',
                            'ref_jantinaID',
                            'ref_kaumID',
                            'penaja_pekerjaan',
                            'penaja_alamat_rumah',
                            'penaja_no_fone',
                            'penaja_alamat_pejabat',
                            'penaja_no_office'
                        ];
}
