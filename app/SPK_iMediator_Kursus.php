<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK_iMediator_Kursus extends Model
{
    protected $table = "spk__imediator_kursus";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'spk_imediator_id', 
                            'kursus_nama',
                            'mkp_kategori_kursus_id', 
                            'mkp_peringkat_kursus_id',
                            'kursus_penganjur'
                        ];
}
