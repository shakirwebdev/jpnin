<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Kewangan_Penyata extends Model
{
    protected $table = "krt__kewangan_penyata";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id', 
                            'bulan', 
                            'tahun',
                            'fail_penyata',
                            'created_at',
                            'updated_at',
                        ];
}
