<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = "users";
    protected $primaryKey = 'user_id';
    protected $fillable = ['user_name', 'user_email', 'user_role','password','state_id','daerah_id','krt_id','user_id','user_status'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    public function profile(){
        return $this->belongsTo('App\UserProfile', 'user_id', 'user_id');
    }

    public function roles(){
        return $this->belongsTo('App\RefRolesUser', 'user_role');
    }

    /*
    ██╗   ██╗███████╗███████╗██████╗     ██████╗  ██████╗ ██╗     ███████╗███████╗
    ██║   ██║██╔════╝██╔════╝██╔══██╗    ██╔══██╗██╔═══██╗██║     ██╔════╝██╔════╝
    ██║   ██║███████╗█████╗  ██████╔╝    ██████╔╝██║   ██║██║     █████╗  ███████╗
    ██║   ██║╚════██║██╔══╝  ██╔══██╗    ██╔══██╗██║   ██║██║     ██╔══╝  ╚════██║
    ╚██████╔╝███████║███████╗██║  ██║    ██║  ██║╚██████╔╝███████╗███████╗███████║
    */
    
    public static function isPentadbirSistem(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 1){
                return true;
            }
        } else 
        return false;
    }

    public static function isOrangAwam(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 2){
                return true;
            }
        } else 
        return false;
    }

    public static function isPPD(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 3){
                return true;
            }
        } else 
        return false;
    }

    public static function isPPN(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 4){
                return true;
            }
        } else 
        return false;
    }

    public static function isHQRT(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 5){
                return true;
            }
        } else 
        return false;
    }

    public static function isHQSRS(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 8){
                return true;
            }
        } else 
        return false;
    }

    public static function isKetuaPengarahHQ(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 9){
                return true;
            }
        } else 
        return false;
    }

    public static function isPengerusi(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 10){
                return true;
            }
        } else 
        return false;
    }

    public static function isSetiausaha(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 11){
                return true;
            }
        } else 
        return false;
    }

    public static function isBendahari(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 12){
                return true;
            }
        } else 
        return false;
    }

    public static function isKetuaPeronda(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 13){
                return true;
            }
        } else 
        return false;
    }

    public static function isMKPeSepakat(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 15){
                return true;
            }
        } else 
        return false;
    }

    public static function isPPDeSepakat(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 16){
                return true;
            }
        } else 
        return false;
    }

    public static function isPPMKeSepakat(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 17){
                return true;
            }
        } else 
        return false;
    }
    
    public static function isPPNeSepakat(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 18){
                return true;
            }
        } else 
        return false;
    }

    public static function isBPPeSepakat(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 19){
                return true;
            }
        } else 
        return false;
    }

    public static function isPengaraheSepakat(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 20){
                return true;
            }
        } else 
        return false;
    }

    public static function isUPMKeSepakat(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 21){
                return true;
            }
        } else 
        return false;
    }

    public static function isKPeSepakat(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 23){
                return true;
            }
        } else 
        return false;
    }

    public static function isIbu_Bapa(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 25){
                return true;
            }
        } else 
        return false;
    }

    public static function isGuru(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 26){
                return true;
            }
        } else 
        return false;
    }

    public static function isPPDetp(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 27){
                return true;
            }
        } else 
        return false;
    }

    public static function isHQUPAKK(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 28){
                return true;
            }
        } else 
        return false;
    }

    public static function isPKSIN(){
        if (!is_null(Auth::user())) {
            $user = Auth::user()->user_role;
            if($user == 29){
                return true;
            }
        } else 
        return false;
    }
}
