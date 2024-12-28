<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_JenisRumah extends Model
{
    protected $table = "krt__jenis_rumah";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profileID', 
                            'jenis_rumah_id', 
                            'jumlah_pintu'
                        ];
}
