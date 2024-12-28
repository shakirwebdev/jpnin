<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Srs_Profile_Upload_Peta extends Model
{
    protected $table = "srs__profile_upload_peta";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'srs_profile_id', 
                            'file_title', 
                            'file_catatan',
                            'file_peta'
                        ];
}
