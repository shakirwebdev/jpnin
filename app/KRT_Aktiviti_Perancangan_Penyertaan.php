<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Aktiviti_Perancangan_Penyertaan extends Model
{
    protected $table = "krt__aktiviti_perancangan_penyertaan";
    protected $primaryKey = 'id';
    protected $fillable = ['aktiviti_perancangan_id', 'kaum_id', 'jantina_id', 'umur_id', 'penyertaan_jumlah'];
}
