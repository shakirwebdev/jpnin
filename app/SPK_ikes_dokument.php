<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SPK_ikes_dokument extends Model
{
    protected $table = "spk__ikes_dokument";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'spk_ikes_id', 
                            'file_title', 
                            'file_catatan',
                            'file_dokument'
                        ];
}
