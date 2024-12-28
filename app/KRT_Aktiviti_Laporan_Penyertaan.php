<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Aktiviti_Laporan_Penyertaan extends Model
{
    protected $table = "krt__aktiviti_laporan_penyertaan";
    protected $primaryKey = 'id';
    protected $fillable = ['aktiviti_laporan_id', 'kaum_id', 'jantina_id', 'umur_id', 'penyertaan_jumlah'];
}
