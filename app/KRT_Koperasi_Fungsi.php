<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Koperasi_Fungsi extends Model
{
    protected $table = "krt__koperasi_fungsi";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_koperasi_id', 
                            'ref_fungsi_koperasi_id', 
                        ];
}
