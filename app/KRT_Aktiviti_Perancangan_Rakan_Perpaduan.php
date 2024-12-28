<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Aktiviti_Perancangan_Rakan_Perpaduan extends Model
{
    protected $table = "krt__aktiviti_perancangan_rakan_perpaduan";
    protected $primaryKey = 'id';
    protected $fillable = ['aktiviti_perancangan_id', 'rakan_id', 'sumbangan_id', 'rakan_perpaduan_jumlah'];
}
