<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK_ikes_kedudukan extends Model
{
    protected $table = "spk__ikes_kedudukan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'spk_ikes_id', 
                            'jenis_harta', 
                            'nilai_anggaran_kerosakan', 
                        ];
}
