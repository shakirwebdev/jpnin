<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Krt_Profile_Upload_Peta extends Model
{
    protected $table = "krt__profile_upload_peta";
    protected $primaryKey = 'id';
    protected $fillable = [
                            'krt_profile_id', 
                            'file_title', 
                            'file_catatan',
                            'file_peta'
                        ];
}
