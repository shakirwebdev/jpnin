<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use DB;
use Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // View::composer('layout.sidebar', function ($view) {
        //     $users_menu = DB::table('roles__menu')
        //         ->select('roles__menu.id AS id',
        //         'users__menu.menu_id AS first_menu',
        //         'users__menu.menu2nd_id AS second_menu',
        //         'users__menu.users_menu_page_name AS nama_menu',
        //         'users__menu.users_menu_page_icon AS icon_menu')
        //         ->leftJoin('users__menu','users__menu.id','=','roles__menu.users_menu_id')
        //         ->leftJoin('users__roles','users__roles.role_id','=','roles__menu.roles_id')
        //         ->where('users__roles.user_id', '=', Auth::user()->user_id)
        //         ->get();

        //         $view->with('roles__menu', $users_menu);
        // });
    }
}
