<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Projek_Ekonomi_ST_Peserta extends Model
{
    protected $table = "krt__projek_ekonomi_st_peserta";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'projek_ekonomi_st_id',
                            'nama_peserta', 
                        ];
}
