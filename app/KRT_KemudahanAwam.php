<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KRT_KemudahanAwam extends Model
{
    protected $table = "krt__kemudahan_awam";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profileID', 
                            'ref_kemudahan_awamID', 
                            'kemudahan_awam_jumlah'
                        ];
}
