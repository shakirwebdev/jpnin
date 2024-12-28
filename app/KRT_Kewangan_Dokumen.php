<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Kewangan_Dokumen extends Model
{
    protected $table = "krt__kewangan_dokumen";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id', 
                            'kewangan_id', 
                            'jenis',
							'butiran',
                            'fail_dokumen',
                            'created_at',
                            'updated_at',
                        ];
}
