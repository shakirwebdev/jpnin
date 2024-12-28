<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect, Response;
use Auth;
use Validator;
use Session;
use Illuminate\Support\Facades\Input;
use App\RefDaerah;
use App\RefParlimen;
use App\RefDUN;
use App\RefStates;
use App\User;
use App\RT_Applications;

class RT_SM3Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
}
