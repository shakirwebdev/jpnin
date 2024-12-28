<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Komposisi_penduduk extends Model
{
    protected $table = "krt__komposisi_penduduk";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profileID', 
                            'komposisi_kaum', 
                            'komposisi_jumlah'
                        ];
}
