<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getConfig($configName)
    {
        try {
            //Validation message for detected language
            if ($configName = "message") {
                return $messages = array(
                    'alpha' => 'Hanya huruf sahaja dibenarkan di ruangan ini',
                    'alpha_dash' => 'Hanya gabungan huruf, nombor dan simbol dibenarkan di ruangan ini',
                    'alpha_num' => 'Hanya gabungan huruf dan aksara  dibenarkan di ruangan ini',
                    'digits' => 'Hanya nombor sahaja dibenarkan di ruangan ini',
                    'numeric' => 'Hanya nombor sahaja dibenarkan di ruangan ini',
                    'email' => 'Sila masukkan email yang sah',
                    'required' => 'Ruangan ini diperlukan',
                    'unique' => 'Rekod wujud dalam pangkalan data',
                    'same' => 'Ruangan :attribute dan :other perlu sama',
                    'min' => '',
                    'regex' => 'Sila masukkan mengikut format',
                );
            } else if ($configName = "attributes") {

            }
        } catch (\Exception $e) {

        }
    }
}
