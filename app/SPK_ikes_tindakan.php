<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK_ikes_tindakan extends Model
{
    protected $table = "spk__ikes_tindakan";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'spk_ikes_id', 
                            'ref_spk_tindakan_id', 
                        ];
}
