<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_Aktiviti_Surat_Perancangan extends Model
{
    protected $table = "krt__aktiviti_surat_perancangan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'surat_tahun', 
                            'surat_tarikh', 
                            'create_by',
                        ];
}
