<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SRS_Profile_Meeting extends Model
{
    protected $table = "srs__profile_meeting";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'srs_profile_id', 
                            'minit_mesyuarat_id', 
                            'keterangan',
                        ];
}
