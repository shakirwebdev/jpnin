<?php

/*
|--------------------------------------------------------------------------
| Web Routess
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\User;
use Illuminate\Support\Facades\Route;

//Route::get('/chart/statistik/aktif', 'ChartController@statistik_aktif')->name('chart.statistik.aktif');

Route::get('/', function () {
    return redirect('secure/login');
});
Route::get('haha', function () {
    dd(User::all());
});

Route::group(['prefix' => '/secure'], function () {
    Route::get('/', function () {
        return redirect('secure/login');
    });
    Route::get('login',                     'AuthenticationController@login')->name('authentication.login');
    Route::get('register',                  'AuthenticationController@register')->name('authentication.register');
    Route::post('register',                 'AuthenticationController@doRegister')->name('authentication.doregister');
    Route::get('sendemail',                 'AuthenticationController@email_register');
    Route::get('logout',                    'AuthenticationController@doLogout')->name('authentication.dologout');
    Route::post('login',                    'AuthenticationController@doLogin')->name('authentication.dologin');
    Route::post('my-captcha',               'AuthenticationController@myCaptchaPost')->name('myCaptcha.post');
    Route::get('refresh_captcha',           'AuthenticationController@refreshCaptcha')->name('refresh_captcha');
    Route::get('update_profile',            'AuthenticationController@update_profile')->name('authentication.update_profile');
    Route::get('lupakatalaluan',            'AuthenticationController@lupakatalaluan')->name('authentication.lupakatalaluan');
});

Route::get('/secure/ajk_krt/{id}',          'landing_pageController@ajk_krt')->name('authentication.ajk_krt');
Route::get('/secure/ajk_srs/{id}',          'landing_pageController@ajk_srs')->name('authentication.ajk_srs');
Route::get('/secure/ahli_mk/{id}',          'landing_pageController@ahli_mk')->name('authentication.ahli_mk');

/* menu */
Route::get('layout/sidebar',                'Users_MenuController@get_roles_menu')->name('layout.sidebar');


/* Dashboard */
Route::get('dashboard', function () {
    return redirect('dashboard/index');
});
Route::get('dashboard/index',               'DashboardController@index')->name('dashboard.index');

/* User Profile */
//Route::get('user/user-profile', 'DashboardController@user_profile')->name('user.profile');

Route::get('user-profile', 'DashboardController@user_profile')->name('user.profile');
Route::put('user-profile', 'DashboardController@update_user_profile')->name('update_user_profile');
/* Modul e-RT - Sub Modul 1 : Penubuhan KRT */

Route::get('/rt/sm1/permohonan-penubuhan-krt',                          'RT_SM1Controller@permohonan_penubuhan_krt')->name('rt-sm1.permohonan_penubuhan_krt');
Route::post('/rt/sm1/permohonan-penubuhan-krt',                         'RT_SM1Controller@action_permohonan_penubuhan_krt')->name('rt-sm1.permohonan_penubuhan_krt');
Route::post('/rt/sm1/buka-permohonan-penubuhan-krt',                    'RT_SM1Controller@unlock_permohonan_penubuhan_krt')->name('rt-sm1.unlock_permohonan_penubuhan_krt');
Route::get('/rt/sm1/status-permohonan-penubuhan-krt',                   'RT_SM1Controller@status_permohonan_penubuhan_krt')->name('rt-sm1.status_permohonan_penubuhan_krt');
Route::get('/rt/sm1/semakan-cadangan-krt-baharu',                        'RT_SM1Controller@semakan_cadangan_krt_baharu')->name('rt-sm1.semakan_cadangan_krt_baharu');
Route::get('/rt/sm1/semak-borang-cadangan-krt-baharu/{id}',              'RT_SM1Controller@semak_borang_cadangan_krt_baharu')->name('rt-sm1.semak_borang_cadangan_krt_baharu');
Route::post('/rt/sm1/post_semak_borang_cadangan_krt_baharu',            'RT_SM1Controller@post_semak_borang_cadangan_krt_baharu')->name('rt-sm1.post_semak_borang_cadangan_krt_baharu');
Route::get('/rt/sm1/kemaskini-profil-krt/{id}',                            'RT_SM1Controller@kemaskini_profil_krt')->name('rt-sm1.kemaskini_profil_krt');
Route::post('/rt/sm1/kemaskini-profil-krt',                             'RT_SM1Controller@add_komposisi_penduduk')->name('rt-sm1.post_komposisi_penduduk');
Route::get('get_komposisi_penduduk_table/{id}',                         'RT_SM1Controller@komposisi_penduduk_table')->name('rt-sm1.get_komposisi_penduduk_table');
Route::get('delete_komposisi_penduduk/{id}',                            'RT_SM1Controller@delete_komposisi_penduduk')->name('rt-sm1.delete_komposisi_penduduk');
Route::post('update_kemaskini_profil_krt',                              'RT_SM1Controller@update_kemaskini_profil_krt')->name('rt-sm1.update_kemaskini_profil_krt');
Route::get('/rt/sm1/kemaskini-profil-krt-1/{id}',                        'RT_SM1Controller@kemaskini_profil_krt_1')->name('rt-sm1.kemaskini_profil_krt_1');
Route::get('get_pekerjaan_table/{id}',                                  'RT_SM1Controller@pekerjaan_table')->name('rt-sm1.get_pekerjaan_table');
Route::post('post_pekerjaan',                                           'RT_SM1Controller@add_pekerjaan')->name('rt-sm1.post_pekerjaan');
Route::get('delete_pekerjaan_krt/{id}',                                 'RT_SM1Controller@delete_pekerjaan_krt')->name('rt-sm1.delete_pekerjaan_krt');
Route::get('get_jenis_rumah_table/{id}',                                'RT_SM1Controller@jenis_rumah_table')->name('rt-sm1.get_jenis_rumah_table');
Route::post('post_jenis_rumah',                                         'RT_SM1Controller@add_jenis_rumah')->name('rt-sm1.post_jenis_rumah');
Route::get('delete_jenis_rumah/{id}',                                   'RT_SM1Controller@delete_jenis_rumah')->name('rt-sm1.delete_jenis_rumah');
Route::get('/rt/sm1/kemaskini-profil-krt-2/{id}',                        'RT_SM1Controller@kemaskini_profil_krt_2')->name('rt-sm1.kemaskini_profil_krt_2');
Route::get('get_jenis_pertubuhan_table/{id}',                           'RT_SM1Controller@jenis_pertubuhan_table')->name('rt-sm1.get_jenis_pertubuhan_table');
Route::post('post_jenis_pertubuhan',                                    'RT_SM1Controller@post_jenis_pertubuhan')->name('rt-sm1.post_jenis_pertubuhan');
Route::post('delete_jenis_pertubuhan',                                  'RT_SM1Controller@delete_jenis_pertubuhan')->name('rt-sm1.delete_jenis_pertubuhan');
Route::get('/rt/sm1/kemaskini-profil-krt-3/{id}',                        'RT_SM1Controller@kemaskini_profil_krt_3')->name('rt-sm1.kemaskini_profil_krt_3');
Route::get('get_kemudahan_awam_table/{id}',                             'RT_SM1Controller@kemudahan_awam_table')->name('rt-sm1.get_kemudahan_awam_table');
Route::post('post_kemudahan_awam',                                      'RT_SM1Controller@add_kemudahan_awam')->name('rt-sm1.post_kemudahan_awam');
Route::get('delete_kemudahan_awam/{id}',                                'RT_SM1Controller@delete_kemudahan_awam')->name('rt-sm1.delete_kemudahan_awam');
Route::get('/rt/sm1/kemaskini-profil-krt-4/{id}',                        'RT_SM1Controller@kemaskini_profil_krt_4')->name('rt-sm1.kemaskini_profil_krt_4');
Route::get('get_kes_jenayah_table/{id}',                                'RT_SM1Controller@kes_jenayah_table')->name('rt-sm1.get_kes_jenayah_table');
Route::post('post_kes_jenayah',                                         'RT_SM1Controller@post_kes_jenayah')->name('rt-sm1.post_kes_jenayah');
Route::post('delete_kes_jenayah',                                       'RT_SM1Controller@delete_kes_jenayah')->name('rt-sm1.delete_kes_jenayah');
Route::get('get_masalah_sosial_table/{id}',                             'RT_SM1Controller@kes_masalah_sosial_table')->name('rt-sm1.get_masalah_sosial_table');
Route::post('post_masalah_sosial',                                      'RT_SM1Controller@post_masalah_sosial')->name('rt-sm1.post_masalah_sosial');
Route::post('delete_masalah_sosial',                                    'RT_SM1Controller@delete_masalah_sosial')->name('rt-sm1.delete_masalah_sosial');
Route::get('/rt/sm1/kemaskini-profil-krt-5/{id}',                        'RT_SM1Controller@kemaskini_profil_krt_5')->name('rt-sm1.kemaskini_profil_krt_5');
Route::get('get_kawasan_pertanian_table/{id}',                          'RT_SM1Controller@kawasan_pertanian_table')->name('rt-sm1.get_kawasan_pertanian_table');
Route::post('post_kawasan_pertanian',                                   'RT_SM1Controller@add_kawasan_pertanian')->name('rt-sm1.post_kawasan_pertanian');
Route::get('delete_kawasan_pertanian/{id}',                             'RT_SM1Controller@delete_kawasan_pertanian')->name('rt-sm1.delete_kawasan_pertanian');
Route::get('/rt/sm1/kemaskini-profil-krt-6/{id}',                        'RT_SM1Controller@kemaskini_profil_krt_6')->name('rt-sm1.kemaskini_profil_krt_6');
Route::get('get_senarai_binaan/{id}',                                   'RT_SM1Controller@senarai_binaan_table')->name('rt-sm1.get_senarai_binaan');
Route::post('add_binaan_jambatan',                                      'RT_SM1Controller@add_binaan_jambatan')->name('rt-sm1.add_binaan_jambatan');
Route::get('delete_binaan/{id}',                                        'RT_SM1Controller@delete_binaan')->name('rt-sm1.delete_binaan');
Route::get('get_senarai_bagunan_tumpang/{id}',                          'RT_SM1Controller@get_senarai_bagunan_tumpang')->name('rt-sm1.get_senarai_bagunan_tumpang');
Route::post('add_bagunan_tumpang',                                      'RT_SM1Controller@add_bagunan_tumpang')->name('rt-sm1.add_bagunan_tumpang');
Route::get('delete_bagunan_tumpang/{id}',                               'RT_SM1Controller@delete_bagunan_tumpang')->name('rt-sm1.delete_bagunan_tumpang');
Route::get('get_senarai_kabin/{id}',                                    'RT_SM1Controller@senarai_kabin_table')->name('rt-sm1.get_senarai_kabin');
Route::post('add_kabin',                                                'RT_SM1Controller@add_kabin')->name('rt-sm1.add_kabin');
Route::post('post_kabin',                                               'RT_SM1Controller@add_kabin_sedia_ada')->name('rt-sm1.post_kabin');
Route::get('delete_kabin/{id}',                                         'RT_SM1Controller@delete_kabin')->name('rt-sm1.delete_kabin');
Route::get('get_cadangan_pembinaan/{id}',                               'RT_SM1Controller@cadangan_pembinaan_table')->name('rt-sm1.get_cadangan_pembinaan');
Route::post('post_cadangan_pembinaan_prt',                              'RT_SM1Controller@add_cadangan_pembinaan_prt')->name('rt-sm1.post_cadangan_pembinaan_prt');
Route::get('delete_cadangan_pembinaan/{id}',                            'RT_SM1Controller@delete_cadangan_pembinaan')->name('rt-sm1.delete_cadangan_pembinaan');
Route::post('update_kemaskini_profil_krt_6',                            'RT_SM1Controller@update_kemaskini_profil_krt_6')->name('rt-sm1.update_kemaskini_profil_krt_6');
Route::get('/rt/sm1/kemaskini-profil-krt-7/{id}',                        'RT_SM1Controller@kemaskini_profil_krt_7')->name('rt-sm1.kemaskini_profil_krt_7');
Route::get('get_peta_kawasan_table/{id}',                               'RT_SM1Controller@get_peta_kawasan_table')->name('rt-sm1.get_peta_kawasan_table');
Route::post('/rt/sm1/add_peta_kawasan',                                 'RT_SM1Controller@add_peta_kawasan')->name('rt-sm1.add_peta_kawasan');
Route::get('get_peta_kawasan/{id}',                                     'RT_SM1Controller@get_peta_kawasan')->name('rt-sm1.get_peta_kawasan');
Route::get('delete_peta_kawasan/{id}',                                  'RT_SM1Controller@delete_peta_kawasan')->name('rt-sm1.delete_peta_kawasan');
Route::get('/rt/sm1/kemaskini-profil-krt-8/{id}',                        'RT_SM1Controller@kemaskini_profil_krt_8')->name('rt-sm1.kemaskini_profil_krt_8');
Route::get('get_jawatankuasa_penaja_table/{id}',                        'RT_SM1Controller@jawatankuasa_penaja_table')->name('rt-sm1.get_jawatankuasa_penaja_table');
Route::post('post_jawatankuasa_penaja',                                 'RT_SM1Controller@add_jawatankuasa_penaja')->name('rt-sm1.post_jawatankuasa_penaja');
Route::get('delete_jawatankuasa_penaja/{id}',                           'RT_SM1Controller@delete_jawatankuasa_penaja')->name('rt-sm1.delete_jawatankuasa_penaja');
Route::get('get_view_jawatankuasa_penaja_table/{id}',                   'RT_SM1Controller@view_jawatankuasa_penaja_table')->name('rt-sm1.get_view_jawatankuasa_penaja_table');
Route::post('post_hantar_permohonan_krt',                               'RT_SM1Controller@hantar_permohonan_krt')->name('rt-sm1.post_hantar_permohonan_krt');
Route::get('/rt/sm1/semakan-permohonan-krt-baharu',                     'RT_SM1Controller@semakan_permohonan_krt_baharu')->name('rt-sm1.semakan_permohonan_krt_baharu');
Route::get('/rt/sm1/semakan-permohonan-krt-ppd/{id}',                   'RT_SM1Controller@semakan_permohonan_krt_ppd')->name('rt-sm1.semakan_permohonan_krt_ppd');
Route::get('/rt/sm1/semakan-permohonan-krt-ppd-1/{id}',                 'RT_SM1Controller@semakan_permohonan_krt_ppd_1')->name('rt-sm1.semakan_permohonan_krt_ppd_1');
Route::get('/rt/sm1/semakan-permohonan-krt-ppd-2/{id}',                 'RT_SM1Controller@semakan_permohonan_krt_ppd_2')->name('rt-sm1.semakan_permohonan_krt_ppd_2');
Route::get('/rt/sm1/semakan-permohonan-krt-ppd-3/{id}',                 'RT_SM1Controller@semakan_permohonan_krt_ppd_3')->name('rt-sm1.semakan_permohonan_krt_ppd_3');
Route::get('/rt/sm1/semakan-permohonan-krt-ppd-4/{id}',                 'RT_SM1Controller@semakan_permohonan_krt_ppd_4')->name('rt-sm1.semakan_permohonan_krt_ppd_4');
Route::get('/rt/sm1/semakan-permohonan-krt-ppd-5/{id}',                 'RT_SM1Controller@semakan_permohonan_krt_ppd_5')->name('rt-sm1.semakan_permohonan_krt_ppd_5');
Route::post('post_semakan_permohonan_krt_ppd',                          'RT_SM1Controller@post_semakan_permohonan_krt_ppd')->name('rt-sm1.post_semakan_permohonan_krt_ppd');
Route::get('/rt/sm1/pengesahan-permohonan-krt-baharu',                  'RT_SM1Controller@pengesahan_permohonan_krt_baharu')->name('rt-sm1.pengesahan_permohonan_krt_baharu');
Route::get('/rt/sm1/pengesahan-permohonan-krt-ppn/{id}',                'RT_SM1Controller@pengesahan_permohonan_krt_ppn')->name('rt-sm1.pengesahan_permohonan_krt_ppn');
Route::get('/rt/sm1/pengesahan-permohonan-krt-ppn-1/{id}',              'RT_SM1Controller@pengesahan_permohonan_krt_ppn_1')->name('rt-sm1.pengesahan_permohonan_krt_ppn_1');
Route::get('/rt/sm1/pengesahan-permohonan-krt-ppn-2/{id}',              'RT_SM1Controller@pengesahan_permohonan_krt_ppn_2')->name('rt-sm1.pengesahan_permohonan_krt_ppn_2');
Route::get('/rt/sm1/pengesahan-permohonan-krt-ppn-3/{id}',              'RT_SM1Controller@pengesahan_permohonan_krt_ppn_3')->name('rt-sm1.pengesahan_permohonan_krt_ppn_3');
Route::get('/rt/sm1/pengesahan-permohonan-krt-ppn-4/{id}',              'RT_SM1Controller@pengesahan_permohonan_krt_ppn_4')->name('rt-sm1.pengesahan_permohonan_krt_ppn_4');
Route::get('/rt/sm1/pengesahan-permohonan-krt-ppn-5/{id}',              'RT_SM1Controller@pengesahan_permohonan_krt_ppn_5')->name('rt-sm1.pengesahan_permohonan_krt_ppn_5');
Route::post('post_pengesahan_permohonan_krt_ppn',                       'RT_SM1Controller@hantar_pengesahan_permohonan_krt_ppn')->name('rt-sm1.post_pengesahan_permohonan_krt_ppn');
Route::get('/rt/sm1/kelulusan-permohonan-krt-baharu',                      'RT_SM1Controller@kelulusan_permohonan_krt_baharu')->name('rt-sm1.kelulusan_permohonan_krt_baharu');
Route::get('/rt/sm1/kelulusan-permohonan-krt-hq/{id}',                  'RT_SM1Controller@kelulusan_permohonan_krt_hq')->name('rt-sm1.kelulusan_permohonan_krt_hq');
Route::get('/rt/sm1/kelulusan-permohonan-krt-hq-1/{id}',                'RT_SM1Controller@kelulusan_permohonan_krt_hq_1')->name('rt-sm1.kelulusan_permohonan_krt_hq_1');
Route::get('/rt/sm1/kelulusan-permohonan-krt-hq-2/{id}',                'RT_SM1Controller@kelulusan_permohonan_krt_hq_2')->name('rt-sm1.kelulusan_permohonan_krt_hq_2');
Route::get('/rt/sm1/kelulusan-permohonan-krt-hq-3/{id}',                'RT_SM1Controller@kelulusan_permohonan_krt_hq_3')->name('rt-sm1.kelulusan_permohonan_krt_hq_3');
Route::get('/rt/sm1/kelulusan-permohonan-krt-hq-4/{id}',                'RT_SM1Controller@kelulusan_permohonan_krt_hq_4')->name('rt-sm1.kelulusan_permohonan_krt_hq_4');
Route::get('/rt/sm1/kelulusan-permohonan-krt-hq-5/{id}',                'RT_SM1Controller@kelulusan_permohonan_krt_hq_5')->name('rt-sm1.kelulusan_permohonan_krt_hq_5');
Route::post('post_kelulusan_permohonan_krt_hq',                         'RT_SM1Controller@post_kelulusan_permohonan_krt_hq')->name('rt-sm1.post_kelulusan_permohonan_krt_hq');

/* Modul e-RT - Sub Modul 2 : Senarai KRT */
Route::get('/rt/sm2', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm2/profile-krt',                                          'RT_SM2Controller@profile_krt')->name('rt-sm2.profile_krt');
Route::get('get_krt_profile_komposisi_table/{id}',                      'RT_SM2Controller@get_krt_profile_komposisi_table')->name('rt-sm2.get_krt_profile_komposisi_table');
Route::post('/rt/sm2/add_profile_krt_komposisi',                        'RT_SM2Controller@add_profile_krt_komposisi')->name('rt-sm2.add_profile_krt_komposisi');
Route::get('delete_krt_profile_komposisi/{id}',                         'RT_SM2Controller@delete_krt_profile_komposisi')->name('rt-sm2.delete_krt_profile_komposisi');
Route::post('update_profile_krt',                                       'RT_SM2Controller@update_profile_krt')->name('rt-sm2.update_profile_krt');
Route::get('/rt/sm2/profile-krt-1',                                      'RT_SM2Controller@profile_krt_1')->name('rt-sm2.profile_krt_1');
Route::get('get_krt_profile_pekerjaan_table/{id}',                      'RT_SM2Controller@get_krt_profile_pekerjaan_table')->name('rt-sm2.get_krt_profile_pekerjaan_table');
Route::post('/rt/sm2/add_profile_krt_pekerjaan',                        'RT_SM2Controller@add_profile_krt_pekerjaan')->name('rt-sm2.add_profile_krt_pekerjaan');
Route::get('delete_krt_profile_pekerjaan/{id}',                         'RT_SM2Controller@delete_krt_profile_pekerjaan')->name('rt-sm2.delete_krt_profile_pekerjaan');
Route::get('get_krt_profile_jenis_rumah_table/{id}',                    'RT_SM2Controller@get_krt_profile_jenis_rumah_table')->name('rt-sm2.get_krt_profile_jenis_rumah_table');
Route::post('/rt/sm2/add_profile_krt_jenis_rumah',                      'RT_SM2Controller@add_profile_krt_jenis_rumah')->name('rt-sm2.add_profile_krt_jenis_rumah');
Route::get('delete_krt_profile_jenis_rumah/{id}',                       'RT_SM2Controller@delete_krt_profile_jenis_rumah')->name('rt-sm2.delete_krt_profile_jenis_rumah');
Route::get('/rt/sm2/profile-krt-2',                                      'RT_SM2Controller@profile_krt_2')->name('rt-sm2.profile_krt_2');
Route::get('get_profile_krt_jenis_pertubuhan_table/{id}',               'RT_SM2Controller@get_profile_krt_jenis_pertubuhan_table')->name('rt-sm2.get_profile_krt_jenis_pertubuhan_table');
Route::post('post_profile_krt_jenis_pertubuhan',                        'RT_SM2Controller@post_profile_krt_jenis_pertubuhan')->name('rt-sm2.post_profile_krt_jenis_pertubuhan');
Route::post('post_delete_profile_krt_jenis_pertubuhan',                 'RT_SM2Controller@post_delete_profile_krt_jenis_pertubuhan')->name('rt-sm2.post_delete_profile_krt_jenis_pertubuhan');
Route::get('/rt/sm2/profile-krt-3',                                      'RT_SM2Controller@profile_krt_3')->name('rt-sm2.profile_krt_3');
Route::get('get_profile_krt_kemudahan_awam_table/{id}',                 'RT_SM2Controller@get_profile_krt_kemudahan_awam_table')->name('rt-sm2.get_profile_krt_kemudahan_awam_table');
Route::post('/rt/sm2/add_profile_krt_kemudahan_awam',                   'RT_SM2Controller@add_profile_krt_kemudahan_awam')->name('rt-sm2.add_profile_krt_kemudahan_awam');
Route::get('delete_profile_krt_kemudahan_awam/{id}',                    'RT_SM2Controller@delete_profile_krt_kemudahan_awam')->name('rt-sm2.delete_profile_krt_kemudahan_awam');
Route::get('/rt/sm2/profile-krt-4',                                      'RT_SM2Controller@profile_krt_4')->name('rt-sm2.profile_krt_4');
Route::get('get_profile_krt_kes_jenayah_table/{id}',                    'RT_SM2Controller@get_profile_krt_kes_jenayah_table')->name('rt-sm2.get_profile_krt_kes_jenayah_table');
Route::post('post_profile_krt_kes_jenayah',                             'RT_SM2Controller@post_profile_krt_kes_jenayah')->name('rt-sm2.post_profile_krt_kes_jenayah');
Route::post('post_delete_profile_krt_kes_jenayah',                      'RT_SM2Controller@post_delete_profile_krt_kes_jenayah')->name('rt-sm2.post_delete_profile_krt_kes_jenayah');
Route::get('get_profile_krt_masalah_sosial_table/{id}',                 'RT_SM2Controller@get_profile_krt_masalah_sosial_table')->name('rt-sm2.get_profile_krt_masalah_sosial_table');
Route::post('post_profile_krt_masalah_sosial',                          'RT_SM2Controller@post_profile_krt_masalah_sosial')->name('rt-sm2.post_profile_krt_masalah_sosial');
Route::post('post_delete_profile_krt_masalah_sosial',                   'RT_SM2Controller@post_delete_profile_krt_masalah_sosial')->name('rt-sm2.post_delete_profile_krt_masalah_sosial');
Route::get('/rt/sm2/profile-krt-5',                                      'RT_SM2Controller@profile_krt_5')->name('rt-sm2.profile_krt_5');
Route::get('get_profile_krt_kawasan_pertanian_table/{id}',              'RT_SM2Controller@get_profile_krt_kawasan_pertanian_table')->name('rt-sm2.get_profile_krt_kawasan_pertanian_table');
Route::post('/rt/sm2/add_profile_krt_kawasan_pertanian',                'RT_SM2Controller@add_profile_krt_kawasan_pertanian')->name('rt-sm2.add_profile_krt_kawasan_pertanian');
Route::get('delete_profile_krt_kawasan_pertanian/{id}',                 'RT_SM2Controller@delete_profile_krt_kawasan_pertanian')->name('rt-sm2.delete_profile_krt_kawasan_pertanian');
Route::get('/rt/sm2/profile-krt-6',                                      'RT_SM2Controller@profile_krt_6')->name('rt-sm2.profile_krt_6');
Route::get('get_profile_krt_senarai_binaan/{id}',                       'RT_SM2Controller@get_profile_krt_senarai_binaan')->name('rt-sm2.get_profile_krt_senarai_binaan');
Route::post('/rt/sm2/add_profile_krt_binaan_jambatan',                  'RT_SM2Controller@add_profile_krt_binaan_jambatan')->name('rt-sm2.add_profile_krt_binaan_jambatan');
Route::get('get_view_binaan_jambatan/{id}',                             'RT_SM2Controller@get_view_binaan_jambatan')->name('rt-sm2.get_view_binaan_jambatan');
Route::get('delete_profile_krt_binaan/{id}',                            'RT_SM2Controller@delete_profile_krt_binaan')->name('rt-sm2.delete_profile_krt_binaan');
Route::get('get_profile_krt_bagunan_tumpang/{id}',                      'RT_SM2Controller@get_profile_krt_bagunan_tumpang')->name('rt-sm2.get_profile_krt_bagunan_tumpang');
Route::post('/rt/sm2/add_profile_krt_bagunan_tumpang',                  'RT_SM2Controller@add_profile_krt_bagunan_tumpang')->name('rt-sm2.add_profile_krt_bagunan_tumpang');
Route::get('get_view_bagunan_tumpang/{id}',                             'RT_SM2Controller@get_view_bagunan_tumpang')->name('rt-sm2.get_view_bagunan_tumpang');
Route::get('delete_get_profile_bagunan_tumpang/{id}',                   'RT_SM2Controller@delete_get_profile_bagunan_tumpang')->name('rt-sm2.delete_get_profile_bagunan_tumpang');
Route::get('get_profile_krt_bagunan_sewa/{id}',                         'RT_SM2Controller@get_profile_krt_bagunan_sewa')->name('rt-sm2.get_profile_krt_bagunan_sewa');
Route::post('/rt/sm2/add_profile_krt_bagunan_sewa',                     'RT_SM2Controller@add_profile_krt_bagunan_sewa')->name('rt-sm2.add_profile_krt_bagunan_sewa');
Route::get('get_view_bagunan_sewa/{id}',                                'RT_SM2Controller@get_view_bagunan_sewa')->name('rt-sm2.get_view_bagunan_sewa');
Route::get('delete_get_profile_bagunan_sewa/{id}',                      'RT_SM2Controller@delete_get_profile_bagunan_sewa')->name('rt-sm2.delete_get_profile_bagunan_sewa');
Route::get('get_profile_krt_senarai_kabin/{id}',                        'RT_SM2Controller@get_profile_krt_senarai_kabin')->name('rt-sm2.get_profile_krt_senarai_kabin');
Route::post('/rt/sm2/add_profile_krt_kabin',                            'RT_SM2Controller@add_profile_krt_kabin')->name('rt-sm2.add_profile_krt_kabin');
Route::get('get_view_kabin_table/{id}',                                 'RT_SM2Controller@get_view_kabin_table')->name('rt-sm2.get_view_kabin_table');
Route::get('delete_profile_krt_kabin/{id}',                             'RT_SM2Controller@delete_profile_krt_kabin')->name('rt-sm2.delete_profile_krt_kabin');
Route::get('get_profile_krt_cadangan_pembinaan/{id}',                   'RT_SM2Controller@get_profile_krt_cadangan_pembinaan')->name('rt-sm2.get_profile_krt_cadangan_pembinaan');
Route::get('delete_cadangan_pembinaan_prt/{id}',                        'RT_SM2Controller@delete_cadangan_pembinaan_prt')->name('rt-sm2.delete_cadangan_pembinaan_prt');
Route::post('/rt/sm2/add_profile_krt_cadangan_pembinaan',               'RT_SM2Controller@add_profile_krt_cadangan_pembinaan')->name('rt-sm2.add_profile_krt_cadangan_pembinaan');
Route::get('get_view_cadangan_pembinaan_table/{id}',                    'RT_SM2Controller@view_cadangan_pembinaan_table')->name('rt-sm2.get_view_cadangan_pembinaan_table');
Route::get('/rt/sm2/profile-krt-7',                                      'RT_SM2Controller@profile_krt_7')->name('rt-sm2.profile_krt_7');
Route::post('/rt/sm2/add_profile_krt_peta_kawasan',                     'RT_SM2Controller@add_profile_krt_peta_kawasan')->name('rt-sm2.add_profile_krt_peta_kawasan');
Route::get('get_profile_krt_peta_kawasan_table/{id}',                   'RT_SM2Controller@get_profile_krt_peta_kawasan_table')->name('rt-sm2.get_profile_krt_peta_kawasan_table');
Route::get('delete_profile_krt_peta_kawasan/{id}',                      'RT_SM2Controller@delete_profile_krt_peta_kawasan')->name('rt-sm2.delete_profile_krt_peta_kawasan');
Route::get('get_data_peta_kawasan/{id}',                                'RT_SM2Controller@get_data_peta_kawasan')->name('rt-sm2.get_data_peta_kawasan');
Route::get('/rt/sm2/profile-krt-8',                                      'RT_SM2Controller@profile_krt_8')->name('rt-sm2.profile_krt_8');
Route::get('get_profile_krt_jawatankuasa_penaja_table/{id}',            'RT_SM2Controller@get_profile_krt_jawatankuasa_penaja_table')->name('rt-sm2.get_profile_krt_jawatankuasa_penaja_table');
Route::post('/rt/sm2/add_profile_krt_jawatankuasa_penaja',              'RT_SM2Controller@add_profile_krt_jawatankuasa_penaja')->name('rt-sm2.add_profile_krt_jawatankuasa_penaja');
Route::get('delete_profile_krt_jawatankuasa_penaja/{id}',               'RT_SM2Controller@delete_profile_krt_jawatankuasa_penaja')->name('rt-sm2.delete_profile_krt_jawatankuasa_penaja');
Route::post('update_profile_krt_8',                                     'RT_SM2Controller@update_profile_krt_8')->name('rt-sm2.update_profile_krt_8');
Route::get('/rt/sm2/profile-krt-ppd',                                      'RT_SM2Controller@profile_krt_ppd')->name('rt-sm2.profile_krt_ppd');
Route::get('/rt/sm2/profile-krt-ppd-1/{id}',                              'RT_SM2Controller@profile_krt_ppd_1')->name('rt-sm2.profile_krt_ppd_1');
Route::get('/rt/sm2/profile-krt-ppd-2/{id}',                              'RT_SM2Controller@profile_krt_ppd_2')->name('rt-sm2.profile_krt_ppd_2');
Route::post('/rt/sm2/profile-krt-ppd-2-update',                          'RT_SM2Controller@profile_krt_ppd_2_update')->name('rt-sm2.profile_krt_ppd_2_update');
Route::get('/rt/sm2/profile-krt-ppd-3/{id}',                              'RT_SM2Controller@profile_krt_ppd_3')->name('rt-sm2.profile_krt_ppd_3');
Route::get('/rt/sm2/profile-krt-ppd-4/{id}',                              'RT_SM2Controller@profile_krt_ppd_4')->name('rt-sm2.profile_krt_ppd_4');
Route::get('/rt/sm2/profile-krt-ppd-5/{id}',                              'RT_SM2Controller@profile_krt_ppd_5')->name('rt-sm2.profile_krt_ppd_5');
Route::get('/rt/sm2/profile-krt-ppd-6/{id}',                              'RT_SM2Controller@profile_krt_ppd_6')->name('rt-sm2.profile_krt_ppd_6');
Route::get('/rt/sm2/profile-krt-ppn',                                      'RT_SM2Controller@profile_krt_ppn')->name('rt-sm2.profile_krt_ppn');
Route::get('/rt/sm2/profile-krt-ppn-1/{id}',                              'RT_SM2Controller@profile_krt_ppn_1')->name('rt-sm2.profile_krt_ppn_1');
Route::get('/rt/sm2/profile-krt-ppn-2/{id}',                              'RT_SM2Controller@profile_krt_ppn_2')->name('rt-sm2.profile_krt_ppn_2');
Route::get('/rt/sm2/profile-krt-ppn-3/{id}',                              'RT_SM2Controller@profile_krt_ppn_3')->name('rt-sm2.profile_krt_ppn_3');
Route::get('/rt/sm2/profile-krt-ppn-4/{id}',                              'RT_SM2Controller@profile_krt_ppn_4')->name('rt-sm2.profile_krt_ppn_4');
Route::get('/rt/sm2/profile-krt-ppn-5/{id}',                              'RT_SM2Controller@profile_krt_ppn_5')->name('rt-sm2.profile_krt_ppn_5');
Route::get('/rt/sm2/profile-krt-ppn-6/{id}',                              'RT_SM2Controller@profile_krt_ppn_6')->name('rt-sm2.profile_krt_ppn_6');
Route::get('/rt/sm2/profile-krt-hqrt',                                  'RT_SM2Controller@profile_krt_hqrt')->name('rt-sm2.profile_krt_hqrt');
Route::get('/rt/sm2/profile-krt-hqrt-1/{id}',                              'RT_SM2Controller@profile_krt_hqrt_1')->name('rt-sm2.profile_krt_hqrt_1');
Route::get('/rt/sm2/profile-krt-hqrt-2/{id}',                              'RT_SM2Controller@profile_krt_hqrt_2')->name('rt-sm2.profile_krt_hqrt_2');
Route::get('/rt/sm2/profile-krt-hqrt-3/{id}',                              'RT_SM2Controller@profile_krt_hqrt_3')->name('rt-sm2.profile_krt_hqrt_3');
Route::get('/rt/sm2/profile-krt-hqrt-4/{id}',                              'RT_SM2Controller@profile_krt_hqrt_4')->name('rt-sm2.profile_krt_hqrt_4');
Route::get('/rt/sm2/profile-krt-hqrt-5/{id}',                              'RT_SM2Controller@profile_krt_hqrt_5')->name('rt-sm2.profile_krt_hqrt_5');
Route::get('/rt/sm2/profile-krt-hqrt-6/{id}',                              'RT_SM2Controller@profile_krt_hqrt_6')->name('rt-sm2.profile_krt_hqrt_6');

/* Modul e-RT - Sub Modul 3 : Penubuhan KRT Baharu */



/* Modul e-RT - Sub Modul 4 : Pelantikan Rukun Tetangga */
Route::get('/rt/sm4', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm4/pendaftaran-ahli-krt-utama',                        'RT_SM4Controller@pendaftaran_ahli_krt_utama')->name('rt-sm4.pendaftaran_ahli_krt_utama');
Route::post('post_daftar_ahli_krt',                                     'RT_SM4Controller@post_daftar_ahli_krt')->name('rt-sm4.post_daftar_ahli_krt');
Route::get('/rt/sm4/borang-pendaftaran-eIDRT/{id}',                     'RT_SM4Controller@borang_pendaftaran_eIDRT')->name('rt-sm4.borang_pendaftaran_eIDRT');
Route::post('/rt/sm4/post_add_gambar',                                  'RT_SM4Controller@post_add_gambar')->name('rt-sm4.post_add_gambar');
Route::post('post_pendaftaran_ahli_krt',                                'RT_SM4Controller@post_pendaftaran_ahli_krt')->name('rt-sm4.post_pendaftaran_ahli_krt');
Route::get('/rt/sm4/pengesahan-ahli-krt-utama',                            'RT_SM4Controller@pengesahan_ahli_krt_utama')->name('rt-sm4.pengesahan_ahli_krt_utama');
Route::get('/rt/sm4/pengesahan-borang-pendaftaran-eIDRT/{id}',          'RT_SM4Controller@pengesahan_borang_pendaftaran_eIDRT')->name('rt-sm4.pengesahan_borang_pendaftaran_eIDRT');
Route::post('post_pengesahan_ahli_krt',                                 'RT_SM4Controller@post_pengesahan_ahli_krt')->name('rt-sm4.post_pengesahan_ahli_krt');
Route::get('/rt/sm4/cadangan-ajk-kepentingan-krt',                      'RT_SM4Controller@cadangan_ajk_kepentingan_krt')->name('rt-sm4.cadangan_ajk_kepentingan_krt');
Route::get('/rt/sm4/borang-pendaftaran-rt-b1',                          'RT_SM4Controller@borang_pendaftaran_rt_b1')->name('rt-sm4.borang_pendaftaran_rt_b1');
Route::post('post_borang_rt_b1',                                        'RT_SM4Controller@post_borang_rt_b1')->name('rt-sm4.post_borang_rt_b1');
Route::get('/rt/sm4/pengesahan-cadangan-ajk-kepentingan-krt-ppd',       'RT_SM4Controller@pengesahan_cadangan_ajk_kepentingan_krt_ppd')->name('rt-sm4.pengesahan_cadangan_ajk_kepentingan_krt_ppd');
Route::get('/rt/sm4/pengesahan-borang-pendaftaran-rt-b1/{id}',          'RT_SM4Controller@pengesahan_borang_pendaftaran_rt_b1')->name('rt-sm4.pengesahan_borang_pendaftaran_rt_b1');
Route::post('post_pengesahan_borang_rt_b1',                             'RT_SM4Controller@post_pengesahan_borang_rt_b1')->name('rt-sm4.post_pengesahan_borang_rt_b1');
Route::get('/rt/sm4/senarai-ajk-krt',                                   'RT_SM4Controller@senarai_ajk_krt')->name('rt-sm4.senarai_ajk_krt');
Route::get('/rt/sm4/kemaskini-ajk-krt/{id}',                            'RT_SM4Controller@kemaskini_ajk_krt')->name('rt-sm4.kemaskini_ajk_krt');
Route::post('/rt/sm4/post_edit_gambar',                                 'RT_SM4Controller@post_edit_gambar')->name('rt-sm4.post_edit_gambar');
Route::post('post_kemaskini_ahli_krt',                                  'RT_SM4Controller@post_kemaskini_ahli_krt')->name('rt-sm4.post_kemaskini_ahli_krt');
Route::get('/rt/sm4/senarai-ajk-krt-ppd',                               'RT_SM4Controller@senarai_ajk_krt_ppd')->name('rt-sm4.senarai_ajk_krt_ppd');
Route::get('/rt/sm4/senarai-ajk-krt-ppn',                               'RT_SM4Controller@senarai_ajk_krt_ppn')->name('rt-sm4.senarai_ajk_krt_ppn');
Route::get('/rt/sm4/kad-keahlian-ppd',                                  'RT_SM4Controller@kad_keahlian_ppd')->name('rt-sm4.kad_keahlian_ppd');
Route::get('/rt/sm4/kad-keahlian-ppn',                                  'RT_SM4Controller@kad_keahlian_ppn')->name('rt-sm4.kad_keahlian_ppn');
Route::get('/rt/sm4/kad-keahlian-hqrt',                                 'RT_SM4Controller@kad_keahlian_hqrt')->name('rt-sm4.kad_keahlian_hqrt');
Route::get('/rt/sm4/pendaftaran-ahli-krt-utama-admin',                  'RT_SM4Controller@pendaftaran_ahli_krt_utama_admin')->name('rt-sm4.pendaftaran_ahli_krt_utama_admin');
Route::get('/rt/sm4/pengesahan-ahli-krt-utama-admin',                   'RT_SM4Controller@pengesahan_ahli_krt_utama_admin')->name('rt-sm4.pengesahan_ahli_krt_utama_admin');
Route::get('/rt/sm4/senarai-ajk-krt-admin',                             'RT_SM4Controller@senarai_ajk_krt_admin')->name('rt-sm4.senarai_ajk_krt_admin');
Route::get('/rt/sm4/cadangan-ajk-kepentingan-krt-admin',                'RT_SM4Controller@cadangan_ajk_kepentingan_krt_admin')->name('rt-sm4.cadangan_ajk_kepentingan_krt_admin');
Route::get('/rt/sm4/kad-keahlian-admin',                                'RT_SM4Controller@kad_keahlian_admin')->name('rt-sm4.kad_keahlian_admin');
Route::get('/rt/sm4/jana-analisa-lampiran',                             'RT_SM4Controller@jana_analisa_lampiran')->name('rt-sm4.jana_analisa_lampiran');
Route::get('/rt/sm4/check-ajk',                                         'RT_SM4Controller@check_ajk')->name('rt-sm4.check_ajk');
Route::get('delete_ajk/{id}',                                             'RT_SM4Controller@delete_ajk')->name('rt-sm4.delete_ajk');


/* Modul e-RT - Sub Modul 5 : Pengurusan Minit Mesyuarat RT */
Route::get('/rt/sm5', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm5/senarai-minit-mesyuarat-rt',                        'RT_SM5Controller@senarai_minit_mesyuarat_rt')->name('rt-sm5.senarai_minit_mesyuarat_rt');
Route::post('post_daftar_minit_mesyuarat',                              'RT_SM5Controller@post_daftar_minit_mesyuarat')->name('rt-sm5.post_daftar_minit_mesyuarat');
Route::get('/rt/sm5/penyediaan-minit-mesyuarat-rt/{id}',                'RT_SM5Controller@penyediaan_minit_mesyuarat_rt')->name('rt-sm5.penyediaan_minit_mesyuarat_rt');
Route::post('post_penyediaan_minit_mesyuarat_rt',                       'RT_SM5Controller@post_penyediaan_minit_mesyuarat_rt')->name('rt-sm5.post_penyediaan_minit_mesyuarat_rt');
Route::post('kembali_penyediaan_minit_mesyuarat_rt',                    'RT_SM5Controller@kembali_penyediaan_minit_mesyuarat_rt')->name('rt-sm5.kembali_penyediaan_minit_mesyuarat_rt');
Route::get('get_senarai_kehadiran/{id}',                                'RT_SM5Controller@senarai_kehadiran_table')->name('rt-sm5.get_senarai_kehadiran');
Route::get('get_senarai_kehadiran_all/{id}',                            'RT_SM5Controller@senarai_kehadiran_all_table')->name('rt-sm5.get_senarai_kehadiran_all');
Route::get('get_senarai_kehadiran_ajk/{id}',                            'RT_SM5Controller@senarai_kehadiran_ajk_table')->name('rt-sm5.get_senarai_kehadiran_ajk');
Route::get('get_senarai_kehadiran_ajk_show/{id}',                       'RT_SM5Controller@senarai_kehadiran_ajk_table_show')->name('rt-sm5.get_senarai_kehadiran_ajk_show');
Route::get('get_senarai_ajk',                                            'RT_SM5Controller@senarai_ajk_table')->name('rt-sm5.get_senarai_ajk');
Route::post('add_kehadiran_mesyuarat',                                  'RT_SM5Controller@add_kehadiran_mesyuarat')->name('rt-sm5.add_kehadiran_mesyuarat');
Route::get('get_view_kehadiran_mesyuarat/{id}',                         'RT_SM5Controller@get_view_kehadiran_mesyuarat')->name('rt-sm5.get_view_kehadiran_mesyuarat');
Route::get('delete_kehadiran/{id}',                                     'RT_SM5Controller@delete_kehadiran')->name('rt-sm5.delete_kehadiran');
Route::get('delete_minit/{id}',                                         'RT_SM5Controller@delete_minit')->name('rt-sm5.delete_minit');
Route::get('delete_kehadiran_ajk',                                      'RT_SM5Controller@delete_kehadiran_ajk')->name('rt-sm5.delete_kehadiran_ajk');
Route::get('add_kehadiran_ajk',                                         'RT_SM5Controller@add_kehadiran_ajk')->name('rt-sm5.add_kehadiran_ajk');
Route::get('/rt/sm5/penyediaan-minit-mesyuarat-rt-1/{id}',              'RT_SM5Controller@penyediaan_minit_mesyuarat_rt_1')->name('rt-sm5.penyediaan_minit_mesyuarat_rt_1');
Route::get('get_senarai_perkara_berbangkit/{id}',                       'RT_SM5Controller@senarai_perkara_berbangkit_table')->name('rt-sm5.get_senarai_perkara_berbangkit');
Route::post('add_pekara_berbangkit_mesyuarat',                          'RT_SM5Controller@add_pekara_berbangkit_mesyuarat')->name('rt-sm5.add_pekara_berbangkit_mesyuarat');
Route::get('get_view_pekara_berbangkit_mesyuarat/{id}',                 'RT_SM5Controller@get_view_pekara_berbangkit_mesyuarat')->name('rt-sm5.get_view_pekara_berbangkit_mesyuarat');
Route::get('delete_perkara_berbangkit_mesyuarat/{id}',                  'RT_SM5Controller@delete_perkara_berbangkit_mesyuarat')->name('rt-sm5.delete_perkara_berbangkit_mesyuarat');
Route::get('get_senarai_kertas_kerja/{id}',                             'RT_SM5Controller@senarai_kertas_kerja_table')->name('rt-sm5.get_senarai_kertas_kerja');
Route::post('add_kertas_kerja_mesyuarat',                               'RT_SM5Controller@add_kertas_kerja_mesyuarat')->name('rt-sm5.add_kertas_kerja_mesyuarat');
Route::get('get_view_kertas_kerja_mesyuarat/{id}',                      'RT_SM5Controller@get_view_kertas_kerja_mesyuarat')->name('rt-sm5.get_view_kertas_kerja_mesyuarat');
Route::get('delete_kertas_kerja_mesyuarat/{id}',                        'RT_SM5Controller@delete_kertas_kerja_mesyuarat')->name('rt-sm5.delete_kertas_kerja_mesyuarat');
Route::get('get_senarai_hal_lain/{id}',                                 'RT_SM5Controller@senarai_hal_lain_table')->name('rt-sm5.get_senarai_hal_lain');
Route::post('add_hal_lain_mesyuarat',                                   'RT_SM5Controller@add_hal_lain_mesyuarat')->name('rt-sm5.add_hal_lain_mesyuarat');
Route::get('get_view_hal_lain_mesyuarat/{id}',                          'RT_SM5Controller@get_view_hal_lain_mesyuarat')->name('rt-sm5.get_view_hal_lain_mesyuarat');
Route::get('delete_hal_lain_mesyuarat/{id}',                            'RT_SM5Controller@delete_hal_lain_mesyuarat')->name('rt-sm5.delete_hal_lain_mesyuarat');
Route::post('post_penyediaan_minit_mesyuarat_rt_1',                     'RT_SM5Controller@post_penyediaan_minit_mesyuarat_rt_1')->name('rt-sm5.post_penyediaan_minit_mesyuarat_rt_1');
Route::post('kembali_penyediaan_minit_mesyuarat_rt_1',                  'RT_SM5Controller@kembali_penyediaan_minit_mesyuarat_rt_1')->name('rt-sm5.kembali_penyediaan_minit_mesyuarat_rt_1');
Route::get('/rt/sm5/pengesahan-minit-mesyuarat-rt',                     'RT_SM5Controller@pengesahan_minit_mesyuarat_rt')->name('rt-sm5.pengesahan_minit_mesyuarat_rt');
Route::get('/rt/sm5/pengesahan-minit-mesyuarat-rt-ppd/{id}',            'RT_SM5Controller@pengesahan_minit_mesyuarat_rt_ppd')->name('rt-sm5.pengesahan_minit_mesyuarat_rt_ppd');
Route::get('/rt/sm5/pengesahan-minit-mesyuarat-rt-ppd-1/{id}',          'RT_SM5Controller@pengesahan_minit_mesyuarat_rt_ppd_1')->name('rt-sm5.pengesahan_minit_mesyuarat_rt_ppd_1');
Route::post('post_pengesahan_minit_mesyuarat',                          'RT_SM5Controller@post_pengesahan_minit_mesyuarat')->name('rt-sm5.post_pengesahan_minit_mesyuarat');
Route::get('/rt/sm5/paparan-minit-mesyuarat-rt',                        'RT_SM5Controller@paparan_minit_mesyuarat_rt')->name('rt-sm5.paparan_minit_mesyuarat_rt');
Route::get('/rt/sm5/paparan-minit-mesyuarat-rt-ppd',                    'RT_SM5Controller@paparan_minit_mesyuarat_rt_ppd')->name('rt-sm5.paparan_minit_mesyuarat_rt_ppd');


/* Modul e-RT - Sub Modul 6 : Pengurusan Aktiviti Rukun Tetangga */
Route::get('/rt/sm6', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm6/surat-perancangan-aktiviti-hq',                     'RT_SM6Controller@surat_perancangan_aktiviti_hq')->name('rt-sm6.surat_perancangan_aktiviti_hq');
Route::post('add_surat_perancangan_aktiviti_hq',                        'RT_SM6Controller@add_surat_perancangan_aktiviti_hq')->name('rt-sm6.add_surat_perancangan_aktiviti_hq');
Route::get('/rt/sm6/surat-perancangan-aktiviti-ppn',                    'RT_SM6Controller@surat_perancangan_aktiviti_ppn')->name('rt-sm6.surat_perancangan_aktiviti_ppn');
Route::get('/rt/sm6/surat-perancangan-aktiviti-ppd',                    'RT_SM6Controller@surat_perancangan_aktiviti_ppd')->name('rt-sm6.surat_perancangan_aktiviti_ppd');
Route::get('/rt/sm6/surat-perancangan-aktiviti-krt',                    'RT_SM6Controller@surat_perancangan_aktiviti_krt')->name('rt-sm6.surat_perancangan_aktiviti_krt');
Route::get('/rt/sm6/surat-perancangan-aktiviti-admin',                  'RT_SM6Controller@surat_perancangan_aktiviti_admin')->name('rt-sm6.surat_perancangan_aktiviti_admin');
Route::get('/rt/sm6/penyediaan-perancangan-aktiviti-krt',               'RT_SM6Controller@penyediaan_perancangan_aktiviti_krt')->name('rt-sm6.penyediaan_perancangan_aktiviti_krt');
Route::post('post_penyediaan_perancangan_aktiviti_krt',                 'RT_SM6Controller@post_penyediaan_perancangan_aktiviti_krt')->name('rt-sm6.post_penyediaan_perancangan_aktiviti_krt');
Route::get('/rt/sm6/penyediaan-perancangan-aktiviti-krt-1/{id}',        'RT_SM6Controller@penyediaan_perancangan_aktiviti_krt_1')->name('rt-sm6.penyediaan_perancangan_aktiviti_krt_1');
Route::post('post_penyediaan_perancangan_aktiviti_krt_1',               'RT_SM6Controller@post_penyediaan_perancangan_aktiviti_krt_1')->name('rt-sm6.post_penyediaan_perancangan_aktiviti_krt_1');
Route::get('/rt/sm6/penyediaan-perancangan-aktiviti-krt-2/{id}',        'RT_SM6Controller@penyediaan_perancangan_aktiviti_krt_2')->name('rt-sm6.penyediaan_perancangan_aktiviti_krt_2');
Route::get('get_penyertaan_table/{id}',                                 'RT_SM6Controller@get_penyertaan_table')->name('rt-sm6.get_penyertaan_table');
Route::post('post_perancangan_penyertaan',                              'RT_SM6Controller@post_perancangan_penyertaan')->name('rt-sm6.post_perancangan_penyertaan');
Route::get('delete_penyertaan/{id}',                                    'RT_SM6Controller@delete_penyertaan')->name('rt-sm6.delete_penyertaan');
Route::get('get_rakan_perpaduan_table/{id}',                            'RT_SM6Controller@get_rakan_perpaduan_table')->name('rt-sm6.get_rakan_perpaduan_table');
Route::post('post_perancangan_rakan_perpaduan',                         'RT_SM6Controller@post_perancangan_rakan_perpaduan')->name('rt-sm6.post_perancangan_rakan_perpaduan');
Route::get('delete_rakan_perpaduan/{id}',                               'RT_SM6Controller@delete_rakan_perpaduan')->name('rt-sm6.delete_rakan_perpaduan');
Route::get('/rt/sm6/penyediaan-perancangan-aktiviti-krt-3/{id}',        'RT_SM6Controller@penyediaan_perancangan_aktiviti_krt_3')->name('rt-sm6.penyediaan_perancangan_aktiviti_krt_3');
Route::post('post_penyediaan_perancangan_aktiviti_krt_2',               'RT_SM6Controller@post_penyediaan_perancangan_aktiviti_krt_2')->name('rt-sm6.post_penyediaan_perancangan_aktiviti_krt_2');
Route::get('/rt/sm6/pengesahan-perancangan-aktiviti-ppd',               'RT_SM6Controller@pengesahan_perancangan_aktiviti_ppd')->name('rt-sm6.pengesahan_perancangan_aktiviti_ppd');
Route::get('/rt/sm6/pengesahan-perancangan-aktiviti-ppd-1/{id}',        'RT_SM6Controller@pengesahan_perancangan_aktiviti_ppd_1')->name('rt-sm6.pengesahan_perancangan_aktiviti_ppd_1');
Route::post('post_perancangan_aktiviti_krt_ppd',                        'RT_SM6Controller@post_perancangan_aktiviti_krt_ppd')->name('rt-sm6.post_perancangan_aktiviti_krt_ppd');
Route::get('/rt/sm6/pengesahan-perancangan-aktiviti-ppd-2/{id}',        'RT_SM6Controller@pengesahan_perancangan_aktiviti_ppd_2')->name('rt-sm6.pengesahan_perancangan_aktiviti_ppd_2');
Route::get('/rt/sm6/pengesahan-perancangan-aktiviti-ppd-3/{id}',        'RT_SM6Controller@pengesahan_perancangan_aktiviti_ppd_3')->name('rt-sm6.pengesahan_perancangan_aktiviti_ppd_3');
Route::post('post_pengesahan_perancangan_aktiviti',                     'RT_SM6Controller@post_pengesahan_perancangan_aktiviti')->name('rt-sm6.post_pengesahan_perancangan_aktiviti');
Route::get('/rt/sm6/penyediaan-laporan-aktiviti-krt',                   'RT_SM6Controller@penyediaan_laporan_aktiviti_krt')->name('rt-sm6.penyediaan_laporan_aktiviti_krt');
Route::post('post_penyediaan_laporan_aktiviti_krt',                     'RT_SM6Controller@post_penyediaan_laporan_aktiviti_krt')->name('rt-sm6.post_penyediaan_laporan_aktiviti_krt');
Route::get('/rt/sm6/penyediaan-laporan-aktiviti-krt-1/{id}',            'RT_SM6Controller@penyediaan_laporan_aktiviti_krt_1')->name('rt-sm6.penyediaan_laporan_aktiviti_krt_1');
Route::post('post_penyediaan_laporan_aktiviti_krt_1',                   'RT_SM6Controller@post_penyediaan_laporan_aktiviti_krt_1')->name('rt-sm6.post_penyediaan_laporan_aktiviti_krt_1');
Route::get('/rt/sm6/penyediaan-laporan-aktiviti-krt-2/{id}',            'RT_SM6Controller@penyediaan_laporan_aktiviti_krt_2')->name('rt-sm6.penyediaan_laporan_aktiviti_krt_2');
Route::get('get_laporan_penyertaan_table/{id}',                         'RT_SM6Controller@get_laporan_penyertaan_table')->name('rt-sm6.get_laporan_penyertaan_table');
Route::post('post_laporan_penyertaan',                                  'RT_SM6Controller@post_laporan_penyertaan')->name('rt-sm6.post_laporan_penyertaan');
Route::get('delete_laporan_penyertaan/{id}',                            'RT_SM6Controller@delete_laporan_penyertaan')->name('rt-sm6.delete_laporan_penyertaan');
Route::get('get_laporan_rakan_perpaduan_table/{id}',                    'RT_SM6Controller@get_laporan_rakan_perpaduan_table')->name('rt-sm6.get_laporan_rakan_perpaduan_table');
Route::post('post_laporan_rakan_perpaduan',                             'RT_SM6Controller@post_laporan_rakan_perpaduan')->name('rt-sm6.post_laporan_rakan_perpaduan');
Route::get('delete_laporan_rakan_perpaduan/{id}',                       'RT_SM6Controller@delete_laporan_rakan_perpaduan')->name('rt-sm6.delete_laporan_rakan_perpaduan');
Route::get('/rt/sm6/penyediaan-laporan-aktiviti-krt-3/{id}',            'RT_SM6Controller@penyediaan_laporan_aktiviti_krt_3')->name('rt-sm6.penyediaan_laporan_aktiviti_krt_3');
Route::post('post_penyediaan_laporan_aktiviti_krt_2',                   'RT_SM6Controller@post_penyediaan_laporan_aktiviti_krt_2')->name('rt-sm6.post_penyediaan_laporan_aktiviti_krt_2');
Route::get('/rt/sm6/pengesahan-laporan-aktiviti-ppd',                   'RT_SM6Controller@pengesahan_laporan_aktiviti_ppd')->name('rt-sm6.pengesahan_laporan_aktiviti_ppd');
Route::get('/rt/sm6/pengesahan-laporan-aktiviti-ppd-1/{id}',            'RT_SM6Controller@pengesahan_laporan_aktiviti_ppd_1')->name('rt-sm6.pengesahan_laporan_aktiviti_ppd_1');
Route::get('/rt/sm6/pengesahan-laporan-aktiviti-ppd-2/{id}',            'RT_SM6Controller@pengesahan_laporan_aktiviti_ppd_2')->name('rt-sm6.pengesahan_laporan_aktiviti_ppd_2');
Route::get('/rt/sm6/pengesahan-laporan-aktiviti-ppd-3/{id}',            'RT_SM6Controller@pengesahan_laporan_aktiviti_ppd_3')->name('rt-sm6.pengesahan_laporan_aktiviti_ppd_3');
Route::post('post_pengesahan_laporan_aktiviti',                         'RT_SM6Controller@post_pengesahan_laporan_aktiviti')->name('rt-sm6.post_pengesahan_laporan_aktiviti');
Route::get('/rt/sm6/jana-laporan-perancangan-aktiviti-krt',             'RT_SM6Controller@jana_laporan_perancangan_aktiviti_krt')->name('rt-sm6.jana_laporan_perancangan_aktiviti_krt');
Route::get('/rt/sm6/jana-laporan-perancangan-aktiviti-krt-1/{id}',      'RT_SM6Controller@jana_laporan_perancangan_aktiviti_krt_1')->name('rt-sm6.jana_laporan_perancangan_aktiviti_krt_1');
Route::get('/rt/sm6/jana-laporan-perancangan-aktiviti-krt-2/{id}',      'RT_SM6Controller@jana_laporan_perancangan_aktiviti_krt_2')->name('rt-sm6.jana_laporan_perancangan_aktiviti_krt_2');
Route::get('/rt/sm6/jana-laporan-perancangan-aktiviti-krt-3/{id}',      'RT_SM6Controller@jana_laporan_perancangan_aktiviti_krt_3')->name('rt-sm6.jana_laporan_perancangan_aktiviti_krt_3');
Route::get('/rt/sm6/jana-laporan-perancangan-aktiviti-ppd',             'RT_SM6Controller@jana_laporan_perancangan_aktiviti_ppd')->name('rt-sm6.jana_laporan_perancangan_aktiviti_ppd');
Route::get('/rt/sm6/jana-laporan-perancangan-aktiviti-ppd-1/{id}',      'RT_SM6Controller@jana_laporan_perancangan_aktiviti_ppd_1')->name('rt-sm6.jana_laporan_perancangan_aktiviti_ppd_1');
Route::get('/rt/sm6/jana-laporan-perancangan-aktiviti-ppd-2/{id}',      'RT_SM6Controller@jana_laporan_perancangan_aktiviti_ppd_2')->name('rt-sm6.jana_laporan_perancangan_aktiviti_ppd_2');
Route::get('/rt/sm6/jana-laporan-perancangan-aktiviti-ppd-3/{id}',      'RT_SM6Controller@jana_laporan_perancangan_aktiviti_ppd_3')->name('rt-sm6.jana_laporan_perancangan_aktiviti_ppd_3');
Route::get('/rt/sm6/jana-laporan-perancangan-aktiviti-ppn',             'RT_SM6Controller@jana_laporan_perancangan_aktiviti_ppn')->name('rt-sm6.jana_laporan_perancangan_aktiviti_ppn');
Route::get('/rt/sm6/jana-laporan-perancangan-aktiviti-ppn-1/{id}',      'RT_SM6Controller@jana_laporan_perancangan_aktiviti_ppn_1')->name('rt-sm6.jana_laporan_perancangan_aktiviti_ppn_1');
Route::get('/rt/sm6/jana-laporan-perancangan-aktiviti-ppn-2/{id}',      'RT_SM6Controller@jana_laporan_perancangan_aktiviti_ppn_2')->name('rt-sm6.jana_laporan_perancangan_aktiviti_ppn_2');
Route::get('/rt/sm6/jana-laporan-perancangan-aktiviti-ppn-3/{id}',      'RT_SM6Controller@jana_laporan_perancangan_aktiviti_ppn_3')->name('rt-sm6.jana_laporan_perancangan_aktiviti_ppn_3');
Route::get('/rt/sm6/jana-laporan-perancangan-aktiviti-hq',              'RT_SM6Controller@jana_laporan_perancangan_aktiviti_hq')->name('rt-sm6.jana_laporan_perancangan_aktiviti_hq');
Route::get('/rt/sm6/jana-laporan-perancangan-aktiviti-hq-1/{id}',       'RT_SM6Controller@jana_laporan_perancangan_aktiviti_hq_1')->name('rt-sm6.jana_laporan_perancangan_aktiviti_hq_1');
Route::get('/rt/sm6/jana-laporan-perancangan-aktiviti-hq-2/{id}',       'RT_SM6Controller@jana_laporan_perancangan_aktiviti_hq_2')->name('rt-sm6.jana_laporan_perancangan_aktiviti_hq_2');
Route::get('/rt/sm6/jana-laporan-perancangan-aktiviti-hq-3/{id}',       'RT_SM6Controller@jana_laporan_perancangan_aktiviti_hq_3')->name('rt-sm6.jana_laporan_perancangan_aktiviti_hq_3');
Route::get('/rt/sm6/jana-laporan-aktiviti-krt',                         'RT_SM6Controller@jana_laporan_aktiviti_krt')->name('rt-sm6.jana_laporan_aktiviti_krt');
Route::get('/rt/sm6/jana-laporan-aktiviti-krt-1/{id}',                  'RT_SM6Controller@jana_laporan_aktiviti_krt_1')->name('rt-sm6.jana_laporan_aktiviti_krt_1');
Route::get('/rt/sm6/jana-laporan-aktiviti-krt-2/{id}',                  'RT_SM6Controller@jana_laporan_aktiviti_krt_2')->name('rt-sm6.jana_laporan_aktiviti_krt_2');
Route::get('/rt/sm6/jana-laporan-aktiviti-krt-3/{id}',                  'RT_SM6Controller@jana_laporan_aktiviti_krt_3')->name('rt-sm6.jana_laporan_aktiviti_krt_3');
Route::get('/rt/sm6/jana-laporan-aktiviti-ppd',                         'RT_SM6Controller@jana_laporan_aktiviti_ppd')->name('rt-sm6.jana_laporan_aktiviti_ppd');
Route::get('/rt/sm6/jana-laporan-aktiviti-ppd-1/{id}',                  'RT_SM6Controller@jana_laporan_aktiviti_ppd_1')->name('rt-sm6.jana_laporan_aktiviti_ppd_1');
Route::get('/rt/sm6/jana-laporan-aktiviti-ppd-2/{id}',                  'RT_SM6Controller@jana_laporan_aktiviti_ppd_2')->name('rt-sm6.jana_laporan_aktiviti_ppd_2');
Route::get('/rt/sm6/jana-laporan-aktiviti-ppd-3/{id}',                  'RT_SM6Controller@jana_laporan_aktiviti_ppd_3')->name('rt-sm6.jana_laporan_aktiviti_ppd_3');
Route::get('/rt/sm6/jana-laporan-aktiviti-ppn',                         'RT_SM6Controller@jana_laporan_aktiviti_ppn')->name('rt-sm6.jana_laporan_aktiviti_ppn');
Route::get('/rt/sm6/jana-laporan-aktiviti-ppn-1/{id}',                  'RT_SM6Controller@jana_laporan_aktiviti_ppn_1')->name('rt-sm6.jana_laporan_aktiviti_ppn_1');
Route::get('/rt/sm6/jana-laporan-aktiviti-ppn-2/{id}',                  'RT_SM6Controller@jana_laporan_aktiviti_ppn_2')->name('rt-sm6.jana_laporan_aktiviti_ppn_2');
Route::get('/rt/sm6/jana-laporan-aktiviti-ppn-3/{id}',                  'RT_SM6Controller@jana_laporan_aktiviti_ppn_3')->name('rt-sm6.jana_laporan_aktiviti_ppn_3');
Route::get('/rt/sm6/jana-laporan-aktiviti-hq',                          'RT_SM6Controller@jana_laporan_aktiviti_hq')->name('rt-sm6.jana_laporan_aktiviti_hq');
Route::get('/rt/sm6/jana-laporan-aktiviti-hq-1/{id}',                   'RT_SM6Controller@jana_laporan_aktiviti_hq_1')->name('rt-sm6.jana_laporan_aktiviti_hq_1');
Route::get('/rt/sm6/jana-laporan-aktiviti-hq-2/{id}',                   'RT_SM6Controller@jana_laporan_aktiviti_hq_2')->name('rt-sm6.jana_laporan_aktiviti_hq_2');
Route::get('/rt/sm6/jana-laporan-aktiviti-hq-3/{id}',                   'RT_SM6Controller@jana_laporan_aktiviti_hq_3')->name('rt-sm6.jana_laporan_aktiviti_hq_3');

Route::get('/rt/sm6/penyediaan-perancangan-aktiviti',                   'RT_SM6Controller@penyediaan_perancangan_aktiviti')->name('rt-sm6.penyediaan_perancangan_aktiviti');
Route::get('/rt/sm6/borang-perancangan-aktiviti-perpaduan',             'RT_SM6Controller@borang_perancangan_aktiviti_perpaduan')->name('rt-sm6.borang_perancangan_aktiviti_perpaduan');
Route::get('/rt/sm6/borang-perancangan-aktiviti-perpaduan-1',           'RT_SM6Controller@borang_perancangan_aktiviti_perpaduan_1')->name('rt-sm6.borang_perancangan_aktiviti_perpaduan_1');
Route::get('/rt/sm6/borang-perancangan-aktiviti-perpaduan-2',           'RT_SM6Controller@borang_perancangan_aktiviti_perpaduan_2')->name('rt-sm6.borang_perancangan_aktiviti_perpaduan_2');
Route::get('/rt/sm6/pengesahan-perancangan-aktiviti',                   'RT_SM6Controller@pengesahan_perancangan_aktiviti')->name('rt-sm6.pengesahan_perancangan_aktiviti');
Route::get('/rt/sm6/pengesahan-borang-perancangan-aktiviti',            'RT_SM6Controller@pengesahan_borang_perancangan_aktiviti')->name('rt-sm6.pengesahan_borang_perancangan_aktiviti');
Route::get('/rt/sm6/pengesahan-borang-perancangan-aktiviti-1',          'RT_SM6Controller@pengesahan_borang_perancangan_aktiviti_1')->name('rt-sm6.pengesahan_borang_perancangan_aktiviti_1');
Route::get('/rt/sm6/pengesahan-borang-perancangan-aktiviti-2',          'RT_SM6Controller@pengesahan_borang_perancangan_aktiviti_2')->name('rt-sm6.pengesahan_borang_perancangan_aktiviti_2');
Route::get('/rt/sm6/penyediaan-laporan-aktiviti',                       'RT_SM6Controller@penyediaan_laporan_aktiviti')->name('rt-sm6.penyediaan_laporan_aktiviti');
Route::get('/rt/sm6/borang-laporan-aktiviti-perpaduan',                  'RT_SM6Controller@borang_laporan_aktiviti_perpaduan')->name('rt-sm6.borang_laporan_aktiviti_perpaduan');
Route::get('/rt/sm6/borang-laporan-aktiviti-perpaduan-1',                'RT_SM6Controller@borang_laporan_aktiviti_perpaduan_1')->name('rt-sm6.borang_laporan_aktiviti_perpaduan_1');
Route::get('/rt/sm6/borang-laporan-aktiviti-perpaduan-2',                'RT_SM6Controller@borang_laporan_aktiviti_perpaduan_2')->name('rt-sm6.borang_laporan_aktiviti_perpaduan_2');
Route::get('/rt/sm6/pengesahan-laporan-aktiviti',                       'RT_SM6Controller@pengesahan_laporan_aktiviti')->name('rt-sm6.pengesahan_laporan_aktiviti');
Route::get('/rt/sm6/pengesahan-borang-laporan-aktiviti',                 'RT_SM6Controller@pengesahan_borang_laporan_aktiviti')->name('rt-sm6.pengesahan_borang_laporan_aktiviti');
Route::get('/rt/sm6/pengesahan-borang-laporan-aktiviti-1',               'RT_SM6Controller@pengesahan_borang_laporan_aktiviti_1')->name('rt-sm6.pengesahan_borang_laporan_aktiviti_1');
Route::get('/rt/sm6/pengesahan-borang-laporan-aktiviti-2',               'RT_SM6Controller@pengesahan_borang_laporan_aktiviti_2')->name('rt-sm6.pengesahan_borang_laporan_aktiviti_2');
Route::get('/rt/sm6/jana-analisa-laporan-aktiviti',                     'RT_SM6Controller@jana_analisa_laporan_aktiviti')->name('rt-sm6.jana_analisa_laporan_aktiviti');
Route::get('/rt/sm6/jana-laporan-perancangan-aktiviti-rt',              'RT_SM6Controller@jana_laporan_perancangan_aktiviti_rt')->name('rt-sm6.jana_laporan_perancangan_aktiviti_rt');
Route::get('/rt/sm6/jana-laporan-perancangan-aktiviti-daerah',          'RT_SM6Controller@jana_laporan_perancangan_aktiviti_daerah')->name('rt-sm6.jana_laporan_perancangan_aktiviti_daerah');
Route::get('/rt/sm6/view-pengesahan-borang-perancangan-aktiviti',       'RT_SM6Controller@view_pengesahan_borang_perancangan_aktiviti')->name('rt-sm6.view_pengesahan_borang_perancangan_aktiviti');
Route::get('/rt/sm6/view-pengesahan-borang-perancangan-aktiviti-1',     'RT_SM6Controller@view_pengesahan_borang_perancangan_aktiviti_1')->name('rt-sm6.view_pengesahan_borang_perancangan_aktiviti_1');
Route::get('/rt/sm6/view-pengesahan-borang-perancangan-aktiviti-2',     'RT_SM6Controller@view_pengesahan_borang_perancangan_aktiviti_2')->name('rt-sm6.view_pengesahan_borang_perancangan_aktiviti_2');
Route::get('/rt/sm6/jana-laporan-perancangan-aktiviti-negeri',          'RT_SM6Controller@jana_laporan_perancangan_aktiviti_negeri')->name('rt-sm6.jana_laporan_perancangan_aktiviti_negeri');
Route::get('/rt/sm6/jana-laporan-aktiviti-daerah',                      'RT_SM6Controller@jana_laporan_aktiviti_daerah')->name('rt-sm6.jana_laporan_aktiviti_daerah');
Route::get('/rt/sm6/jana-laporan-aktiviti-negeri',                      'RT_SM6Controller@jana_laporan_aktiviti_negeri')->name('rt-sm6.jana_laporan_aktiviti_negeri');
Route::get('/rt/sm6/jana-laporan-aktiviti-hq',                          'RT_SM6Controller@jana_laporan_aktiviti_hq')->name('rt-sm6.jana_laporan_aktiviti_hq');

/* Modul e-RT - Sub Modul 7 : Pengurusan Kewangan Rukun Tetangga */
Route::get('/rt/sm7', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm7/senarai-rekod-kewangan-rt',                         'RT_SM7Controller@senarai_rekod_kewangan_rt')->name('rt-sm7.senarai_rekod_kewangan_rt');
Route::get('/rt/sm7/add-rekod-kewangan-rt',                             'RT_SM7Controller@add_rekod_kewangan_rt')->name('rt-sm7.add_rekod_kewangan_rt');
Route::post('post_rekod_kewangan_rt',                                   'RT_SM7Controller@post_rekod_kewangan_rt')->name('rt-sm7.post_rekod_kewangan_rt');
Route::get('/rt/sm7/kemaskini-rekod-kewangan-rt-1/{id}',                'RT_SM7Controller@kemaskini_rekod_kewangan_rt_1')->name('rt-sm7.kemaskini_rekod_kewangan_rt_1');
Route::get('/rt/sm7/lihat-rekod-kewangan-rt-1/{id}',                    'RT_SM7Controller@lihat_rekod_kewangan_rt_1')->name('rt-sm7.lihat_rekod_kewangan_rt_1');
Route::get('/rt/sm7/lihatsemakan-rekod-kewangan-rt-1/{id}',             'RT_SM7Controller@lihatsemakan_rekod_kewangan_rt_1')->name('rt-sm7.lihatsemakan_rekod_kewangan_rt_1');
Route::post('post_edit_rekod_kewangan_rt',                              'RT_SM7Controller@post_edit_rekod_kewangan_rt')->name('rt-sm7.post_edit_rekod_kewangan_rt');
Route::get('/rt/sm7/semakan-rekod-kewangan-rt',                         'RT_SM7Controller@semakan_rekod_kewangan_rt')->name('rt-sm7.semakan_rekod_kewangan_rt');
Route::get('/rt/sm7/semakan-rekod-kewangan-rt-1/{id}',                  'RT_SM7Controller@semakan_rekod_kewangan_rt_1')->name('rt-sm7.semakan_rekod_kewangan_rt_1');
Route::post('post_semakan_rekod_kewangan_rt',                           'RT_SM7Controller@post_semakan_rekod_kewangan_rt')->name('rt-sm7.post_semakan_rekod_kewangan_rt');
Route::get('/rt/sm7/pengesahan-rekod-kewangan-rt',                      'RT_SM7Controller@pengesahan_rekod_kewangan_rt')->name('rt-sm7.pengesahan_rekod_kewangan_rt');
Route::get('/rt/sm7/pengesahan-rekod-kewangan-rt-trx',                  'RT_SM7Controller@pengesahan_rekod_kewangan_rt_trx')->name('rt-sm7.pengesahan_rekod_kewangan_rt_trx');
Route::get('/rt/sm7/pengesahan-rekod-kewangan-rt-1/{id}',               'RT_SM7Controller@pengesahan_rekod_kewangan_rt_1')->name('rt-sm7.pengesahan_rekod_kewangan_rt_1');
Route::post('post_pengesahan_rekod_kewangan_rt',                        'RT_SM7Controller@post_pengesahan_rekod_kewangan_rt')->name('rt-sm7.post_pengesahan_rekod_kewangan_rt');
Route::get('/rt/sm7/senarai-rekod-kewangan-rt-diluluskan',              'RT_SM7Controller@senarai_rekod_kewangan_rt_diluluskan')->name('rt-sm7.senarai_rekod_kewangan_rt_diluluskan');
Route::get('/rt/sm7/laporan-kewangan-rt',                               'RT_SM7Controller@laporan_kewangan_rt')->name('rt-sm7.laporan_kewangan_rt');
Route::post('/rt/sm7/post_add_dokumen',                                 'RT_SM7Controller@post_add_dokumen')->name('rt-sm7.post_add_dokumen');
Route::post('/rt/sm7/post_add_penyata',                                 'RT_SM7Controller@post_add_penyata')->name('rt-sm7.post_add_penyata');
Route::post('/rt/sm7/get_penyata',                                         'RT_SM7Controller@get_penyata')->name('rt-sm7.get_penyata');
Route::post('/rt/sm7/get_krt_kewangan',                                    'RT_SM7Controller@get_krt_kewangan')->name('rt-sm7.get_krt_kewangan');
Route::get('get_senarai_trx/{id}',                                        'RT_SM7Controller@senarai_trx')->name('rt-sm7.get_senarai_trx');
Route::get('get_senarai_dokumen_sokongan/{id}',                            'RT_SM7Controller@senarai_dokumen_sokongan')->name('rt-sm7.get_senarai_dokumen_sokongan');
Route::get('delete_kewangan/{id}',                                         'RT_SM7Controller@delete_kewangan')->name('rt-sm7.delete_kewangan');
Route::post('/rt/sm7/kembali_rekod_kewangan_rt',                        'RT_SM7Controller@kembali_rekod_kewangan_rt')->name('rt-sm7.kembali_rekod_kewangan_rt');
Route::get('delete_dokumen/{id}',                                         'RT_SM7Controller@delete_dokumen')->name('rt-sm7.delete_dokumen');
Route::post('/rt/sm7/post_hantarppd_rekod_kewangan_rt',                 'RT_SM7Controller@post_hantarppd_rekod_kewangan_rt')->name('rt-sm7.post_hantarppd_rekod_kewangan_rt');
Route::post('/rt/sm7/post_ppdsah_rekod_kewangan_rt',                     'RT_SM7Controller@post_ppdsah_rekod_kewangan_rt')->name('rt-sm7.post_ppdsah_rekod_kewangan_rt');
Route::get('/rt/sm7/modal_senarai_dokumen',                             'RT_SM7Controller@modal_senarai_dokumen')->name('rt-sm7.modal_senarai_dokumen');
Route::get('/rt/sm7/get_senarai_penyata',                                 'RT_SM7Controller@get_senarai_penyata')->name('rt-sm7.get_senarai_penyata');
Route::get('/rt/sm7/get_senarai_dokumen',                                 'RT_SM7Controller@get_senarai_dokumen')->name('rt-sm7.get_senarai_dokumen');
Route::get('/rt/sm7/get_excel_file/{id}',                               'RT_SM7Controller@get_excel_file')->name('rt-sm7.get_excel_file');
Route::get('/rt/sm7/get_excel_file2/krt/{krt}/bulan/{bulan}/tahun/{tahun}',                               'RT_SM7Controller@get_excel_file2')->name('rt-sm7.get_excel_file2');

/* Modul e-RT - Sub Modul 8 : Pembatalan KRT */
Route::get('/rt/sm8', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm8/permohonan-pembatalan-krt',                         'RT_SM8Controller@permohonan_pembatalan_krt')->name('rt-sm8.permohonan_pembatalan_krt');
Route::post('post_create_permohonan_pembatalan_krt',                    'RT_SM8Controller@post_create_permohonan_pembatalan_krt')->name('rt-sm8.post_create_permohonan_pembatalan_krt');
Route::get('/rt/sm8/permohonan-pembatalan-krt-1/{id}',                  'RT_SM8Controller@permohonan_pembatalan_krt_1')->name('rt-sm8.permohonan_pembatalan_krt_1');
Route::get('get_minit_meeting_pembatalan_krt_table/{id}',               'RT_SM8Controller@get_minit_meeting_pembatalan_krt_table')->name('rt-sm8.get_minit_meeting_pembatalan_krt_table');
Route::post('post_minit_meeting_pembatalan_krt',                        'RT_SM8Controller@post_minit_meeting_pembatalan_krt')->name('rt-sm8.post_minit_meeting_pembatalan_krt');
Route::get('delete_minit_meeting_pembatalan_krt/{id}',                  'RT_SM8Controller@delete_minit_meeting_pembatalan_krt')->name('rt-sm8.delete_minit_meeting_pembatalan_krt');
Route::post('post_create_permohonan_pembatalan_krt_1',                  'RT_SM8Controller@post_create_permohonan_pembatalan_krt_1')->name('rt-sm8.post_create_permohonan_pembatalan_krt_1');
Route::get('/rt/sm8/semakan-pembatalan-krt',                            'RT_SM8Controller@semakan_pembatalan_krt')->name('rt-sm8.semakan_pembatalan_krt');
Route::get('/rt/sm8/semakan-pembatalan-krt-1/{id}',                     'RT_SM8Controller@semakan_pembatalan_krt_1')->name('rt-sm8.semakan_pembatalan_krt_1');
Route::post('post_semakan_pembatalan_krt',                              'RT_SM8Controller@post_semakan_pembatalan_krt')->name('rt-sm8.post_semakan_pembatalan_krt');
Route::get('/rt/sm8/sokongan-pembatalan-krt',                           'RT_SM8Controller@sokongan_pembatalan_krt')->name('rt-sm8.sokongan_pembatalan_krt');
Route::get('/rt/sm8/sokongan-pembatalan-krt-1/{id}',                    'RT_SM8Controller@sokongan_pembatalan_krt_1')->name('rt-sm8.sokongan_pembatalan_krt_1');
Route::post('post_sokongan_pembatalan_krt',                             'RT_SM8Controller@post_sokongan_pembatalan_krt')->name('rt-sm8.post_sokongan_pembatalan_krt');
Route::get('/rt/sm8/kelulusan-pembatalan-krt',                          'RT_SM8Controller@kelulusan_pembatalan_krt')->name('rt-sm8.kelulusan_pembatalan_krt');
Route::get('/rt/sm8/kelulusan-pembatalan-krt-1/{id}',                   'RT_SM8Controller@kelulusan_pembatalan_krt_1')->name('rt-sm8.kelulusan_pembatalan_krt_1');
Route::post('post_kelulusan_pembatalan_krt',                            'RT_SM8Controller@post_kelulusan_pembatalan_krt')->name('rt-sm8.post_kelulusan_pembatalan_krt');
Route::get('/rt/sm8/senarai-pembatalan-krt-ppd',                        'RT_SM8Controller@senarai_pembatalan_krt_ppd')->name('rt-sm8.senarai_pembatalan_krt_ppd');
Route::get('/rt/sm8/senarai-pembatalan-krt-ppn',                        'RT_SM8Controller@senarai_pembatalan_krt_ppn')->name('rt-sm8.senarai_pembatalan_krt_ppn');
Route::get('/rt/sm8/senarai-pembatalan-krt-hqrt',                       'RT_SM8Controller@senarai_pembatalan_krt_hqrt')->name('rt-sm8.senarai_pembatalan_krt_hqrt');

Route::get('/rt/sm8/permohonan-pembatalan-krt-admin',                   'RT_SM8Controller@permohonan_pembatalan_krt_admin')->name('rt-sm8.permohonan_pembatalan_krt_admin');
Route::get('/rt/sm8/semak-permohonan-pembatalan-krt-admin',             'RT_SM8Controller@semak_permohonan_pembatalan_krt_admin')->name('rt-sm8.semak_permohonan_pembatalan_krt_admin');
Route::get('/rt/sm8/sokongan-pembatalan-krt-admin',                     'RT_SM8Controller@sokongan_pembatalan_krt_admin')->name('rt-sm8.sokongan_pembatalan_krt_admin');
Route::get('/rt/sm8/semakan-pembatalan-krt-ppd-admin',                  'RT_SM8Controller@semakan_pembatalan_krt_ppd_admin')->name('rt-sm8.semakan_pembatalan_krt_ppd_admin');
Route::get('/rt/sm8/semakan-pembatalan-krt-ppd-admin-1',                'RT_SM8Controller@semakan_pembatalan_krt_ppd_admin_1')->name('rt-sm8.semakan_pembatalan_krt_ppd_admin_1');
Route::get('/rt/sm8/paparan-senarai-permohonan-krt-batal-admin',        'RT_SM8Controller@paparan_senarai_permohonan_krt_batal_admin')->name('rt-sm8.paparan_senarai_permohonan_krt_batal_admin');
Route::get('/rt/sm8/semakan-pembatalan-krt-ppn-admin',                  'RT_SM8Controller@semakan_pembatalan_krt_ppn_admin')->name('rt-sm8.semakan_pembatalan_krt_ppn_admin');
Route::get('/rt/sm8/semakan-pembatalan-krt-ppn-admin-1',                'RT_SM8Controller@semakan_pembatalan_krt_ppn_admin_1')->name('rt-sm8.semakan_pembatalan_krt_ppn_admin_1');
Route::get('/rt/sm8/kelulusan-pembatalan-admin',                        'RT_SM8Controller@kelulusan_pembatalan_admin')->name('rt-sm8.kelulusan_pembatalan_admin');
Route::get('/rt/sm8/semakan-pembatalan-krt-hq-admin',                   'RT_SM8Controller@semakan_pembatalan_krt_hq_admin')->name('rt-sm8.semakan_pembatalan_krt_hq_admin');
Route::get('/rt/sm8/semakan-pembatalan-krt-hq-admin-1',                 'RT_SM8Controller@semakan_pembatalan_krt_hq_admin_1')->name('rt-sm8.semakan_pembatalan_krt_hq_admin_1');
Route::get('/rt/sm8/jana-surat-kelulusan-pembatalan-admin',             'RT_SM8Controller@jana_surat_kelulusan_pembatalan_admin')->name('rt-sm8.jana_surat_kelulusan_pembatalan_admin');
Route::get('/rt/sm8/surat-kelulusan-pembatalan-krt-admin',              'RT_SM8Controller@surat_kelulusan_pembatalan_krt_admin')->name('rt-sm8.surat_kelulusan_pembatalan_krt_admin');
Route::get('/rt/sm8/paparan-senarai-krt-batal-admin',                   'RT_SM8Controller@paparan_senarai_krt_batal_admin')->name('rt-sm8.paparan_senarai_krt_batal_admin');

/* Modul e-RT - Sub Modul 9 : Cawangan RT */
Route::get('/rt/sm9', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm9/tambah-ajk-cawangan-rt',                            'RT_SM9Controller@tambah_ajk_cawangan_rt')->name('rt-sm9.tambah_ajk_cawangan_rt');
Route::post('post_tambah_ajk_cawangan_rt',                              'RT_SM9Controller@post_tambah_ajk_cawangan_rt')->name('rt-sm9.post_tambah_ajk_cawangan_rt');
Route::get('/rt/sm9/tambah-ajk-cawangan-rt-1/{id}',                     'RT_SM9Controller@tambah_ajk_cawangan_rt_1')->name('rt-sm9.tambah_ajk_cawangan_rt_1');
Route::get('get_pendidikan_table/{id}',                                 'RT_SM9Controller@get_pendidikan_table')->name('rt-sm9.get_pendidikan_table');
Route::post('post_pendidikan',                                          'RT_SM9Controller@post_pendidikan')->name('rt-sm9.post_pendidikan');
Route::get('delete_pendidikans/{id}',                                   'RT_SM9Controller@delete_pendidikans')->name('rt-sm9.delete_pendidikans');
Route::post('update_ajk_cawangan_rt',                                   'RT_SM9Controller@update_ajk_cawangan_rt')->name('rt-sm9.update_ajk_cawangan_rt');
Route::get('/rt/sm9/tambah-ajk-cawangan-rt-2/{id}',                     'RT_SM9Controller@tambah_ajk_cawangan_rt_2')->name('rt-sm9.tambah_ajk_cawangan_rt_2');
Route::get('get_pengalaman_table/{id}',                                 'RT_SM9Controller@get_pengalaman_table')->name('rt-sm9.get_pengalaman_table');
Route::post('post_pengalaman',                                          'RT_SM9Controller@post_pengalaman')->name('rt-sm9.post_pengalaman');
Route::get('delete_pengalaman/{id}',                                    'RT_SM9Controller@delete_pengalaman')->name('rt-sm9.delete_pengalaman');
Route::post('update_ajk_cawangan_rt_2',                                 'RT_SM9Controller@update_ajk_cawangan_rt_2')->name('rt-sm9.update_ajk_cawangan_rt_2');
Route::get('/rt/sm9/menyemak-ajk-cawangan-rt',                          'RT_SM9Controller@menyemak_ajk_cawangan_rt')->name('rt-sm9.menyemak_ajk_cawangan_rt');
Route::get('/rt/sm9/menyemak-ajk-cawangan-rt-1-ppd/{id}',               'RT_SM9Controller@menyemak_ajk_cawangan_rt_1_ppd')->name('rt-sm9.menyemak_ajk_cawangan_rt_1_ppd');
Route::get('/rt/sm9/menyemak-ajk-cawangan-rt-2-ppd/{id}',               'RT_SM9Controller@menyemak_ajk_cawangan_rt_2_ppd')->name('rt-sm9.menyemak_ajk_cawangan_rt_2_ppd');
Route::post('post_semakan_ajk_cawangan_rt_ppd',                         'RT_SM9Controller@post_semakan_ajk_cawangan_rt_ppd')->name('rt-sm9.post_semakan_ajk_cawangan_rt_ppd');
Route::get('/rt/sm9/memperakui-ajk-cawangan-rt-ppn',                    'RT_SM9Controller@memperakui_ajk_cawangan_rt_ppn')->name('rt-sm9.memperakui_ajk_cawangan_rt_ppn');
Route::get('/rt/sm9/memperakui-ajk-cawangan-rt-ppn-1/{id}',             'RT_SM9Controller@memperakui_ajk_cawangan_rt_ppn_1')->name('rt-sm9.memperakui_ajk_cawangan_rt_ppn_1');
Route::get('/rt/sm9/memperakui-ajk-cawangan-rt-ppn-2/{id}',             'RT_SM9Controller@memperakui_ajk_cawangan_rt_ppn_2')->name('rt-sm9.memperakui_ajk_cawangan_rt_ppn_2');
Route::post('post_akui_ajk_cawangan_rt_ppd',                            'RT_SM9Controller@post_akui_ajk_cawangan_rt_ppd')->name('rt-sm9.post_akui_ajk_cawangan_rt_ppd');
Route::get('/rt/sm9/senarai-ajk-cawangan-rt',                           'RT_SM9Controller@senarai_ajk_cawangan_rt')->name('rt-sm9.senarai_ajk_cawangan_rt');
Route::get('/rt/sm9/view-ajk-cawangan-rt/{id}',                         'RT_SM9Controller@view_ajk_cawangan_rt')->name('rt-sm9.view_ajk_cawangan_rt');
Route::get('/rt/sm9/view-ajk-cawangan-rt-1/{id}',                       'RT_SM9Controller@view_ajk_cawangan_rt_1')->name('rt-sm9.view_ajk_cawangan_rt_1');
Route::post('post_kemaskini_status_ajk',                                'RT_SM9Controller@post_kemaskini_status_ajk')->name('rt-sm9.post_kemaskini_status_ajk');
Route::get('/rt/sm9/senarai-ajk-cawangan-rt-ppd',                       'RT_SM9Controller@senarai_ajk_cawangan_rt_ppd')->name('rt-sm9.senarai_ajk_cawangan_rt_ppd');
Route::get('/rt/sm9/view-ajk-cawangan-rt-ppd/{id}',                     'RT_SM9Controller@view_ajk_cawangan_rt_ppd')->name('rt-sm9.view_ajk_cawangan_rt_ppd');
Route::get('/rt/sm9/view-ajk-cawangan-rt-ppd-1/{id}',                   'RT_SM9Controller@view_ajk_cawangan_rt_ppd_1')->name('rt-sm9.view_ajk_cawangan_rt_ppd_1');
Route::get('/rt/sm9/senarai-ajk-cawangan-rt-ppn',                       'RT_SM9Controller@senarai_ajk_cawangan_rt_ppn')->name('rt-sm9.senarai_ajk_cawangan_rt_ppn');
Route::get('/rt/sm9/tambah-ajk-cawangan-rt-admin',                      'RT_SM9Controller@tambah_ajk_cawangan_rt_admin')->name('rt-sm9.tambah_ajk_cawangan_rt_admin');
Route::get('/rt/sm9/menyemak-ajk-cawangan-rt-admin',                    'RT_SM9Controller@menyemak_ajk_cawangan_rt_admin')->name('rt-sm9.menyemak_ajk_cawangan_rt_admin');
Route::get('/rt/sm9/memperakui-ajk-cawangan-rt-admin',                  'RT_SM9Controller@memperakui_ajk_cawangan_rt_admin')->name('rt-sm9.memperakui_ajk_cawangan_rt_admin');
Route::get('/rt/sm9/senarai-ajk-cawangan-rt-admin',                     'RT_SM9Controller@senarai_ajk_cawangan_rt_admin')->name('rt-sm9.senarai_ajk_cawangan_rt_admin');
Route::get('/rt/sm9/view-ajk-cawangan-rt-admin/{id}',                   'RT_SM9Controller@view_ajk_cawangan_rt_admin')->name('rt-sm9.view_ajk_cawangan_rt_admin');
Route::get('/rt/sm9/view-ajk-cawangan-rt-1-admin/{id}',                 'RT_SM9Controller@view_ajk_cawangan_rt_1_admin')->name('rt-sm9.view_ajk_cawangan_rt_1_admin');

/* Modul e-RT - Sub Modul 10 :  Program Outcome Based Budgeting (OBB) */
Route::get('/rt/sm10', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm10/profil-skuad-uniti-krt',                           'RT_SM10Controller@profil_skuad_uniti_krt')->name('rt-sm10.profil_skuad_uniti_krt');
Route::post('post_tambah_profile_skuad_uniti',                          'RT_SM10Controller@post_tambah_profile_skuad_uniti')->name('rt-sm10.post_tambah_profile_skuad_uniti');
Route::get('/rt/sm10/profil-skuad-uniti-krt-1/{id}',                    'RT_SM10Controller@profil_skuad_uniti_krt_1')->name('rt-sm10.profil_skuad_uniti_krt_1');
Route::get('get_senarai_biro_table/{id}',                               'RT_SM10Controller@get_senarai_biro_table')->name('rt-sm10.get_senarai_biro_table');
Route::post('add_biro_skuad_uniti',                                     'RT_SM10Controller@add_biro_skuad_uniti')->name('rt-sm10.add_biro_skuad_uniti');
Route::get('get_view_biro_skuad_uniti/{id}',                            'RT_SM10Controller@get_view_biro_skuad_uniti')->name('rt-sm10.get_view_biro_skuad_uniti');
Route::get('delete_biro/{id}',                                          'RT_SM10Controller@delete_biro')->name('rt-sm10.delete_biro');
Route::get('get_senarai_jaringan_table/{id}',                           'RT_SM10Controller@get_senarai_jaringan_table')->name('rt-sm10.get_senarai_jaringan_table');
Route::post('add_jaringan_skuad_uniti',                                 'RT_SM10Controller@add_jaringan_skuad_uniti')->name('rt-sm10.add_jaringan_skuad_uniti');
Route::get('get_view_jaringan_skuad_uniti/{id}',                        'RT_SM10Controller@get_view_jaringan_skuad_uniti')->name('rt-sm10.get_view_jaringan_skuad_uniti');
Route::post('post_profil_skuad_uniti_krt',                              'RT_SM10Controller@post_profil_skuad_uniti_krt')->name('rt-sm10.post_profil_skuad_uniti_krt');
Route::get('delete_jaringan/{id}',                                      'RT_SM10Controller@delete_jaringan')->name('rt-sm10.delete_jaringan');
Route::get('/rt/sm10/semakan-profil-skuad-uniti-krt',                   'RT_SM10Controller@semakan_profil_skuad_uniti_krt')->name('rt-sm10.semakan_profil_skuad_uniti_krt');
Route::get('/rt/sm10/semakan-profil-skuad-uniti-krt-1/{id}',            'RT_SM10Controller@semakan_profil_skuad_uniti_krt_1')->name('rt-sm10.semakan_profil_skuad_uniti_krt_1');
Route::post('post_semakan_profile_skuad_uniti',                         'RT_SM10Controller@post_semakan_profile_skuad_uniti')->name('rt-sm10.post_semakan_profile_skuad_uniti');
Route::get('/rt/sm10/akui-profil-skuad-uniti-krt',                      'RT_SM10Controller@akui_profil_skuad_uniti_krt')->name('rt-sm10.akui_profil_skuad_uniti_krt');
Route::get('/rt/sm10/akui-profil-skuad-uniti-krt-1/{id}',               'RT_SM10Controller@akui_profil_skuad_uniti_krt_1')->name('rt-sm10.akui_profil_skuad_uniti_krt_1');
Route::post('post_akui_profile_skuad_uniti',                            'RT_SM10Controller@post_akui_profile_skuad_uniti')->name('rt-sm10.post_akui_profile_skuad_uniti');
Route::get('/rt/sm10/senarai-skuad-uniti-krt',                          'RT_SM10Controller@senarai_skuad_uniti_krt')->name('rt-sm10.senarai_skuad_uniti_krt');
Route::get('/rt/sm10/senarai-skuad-uniti-krt-1/{id}',                   'RT_SM10Controller@senarai_skuad_uniti_krt_1')->name('rt-sm10.senarai_skuad_uniti_krt_1');
Route::get('/rt/sm10/senarai-skuad-uniti-krt-ppd',                      'RT_SM10Controller@senarai_skuad_uniti_krt_ppd')->name('rt-sm10.senarai_skuad_uniti_krt_ppd');
Route::get('/rt/sm10/senarai-skuad-uniti-krt-ppd-1/{id}',               'RT_SM10Controller@senarai_skuad_uniti_krt_ppd_1')->name('rt-sm10.senarai_skuad_uniti_krt_ppd_1');
Route::get('/rt/sm10/senarai-skuad-uniti-krt-ppn',                      'RT_SM10Controller@senarai_skuad_uniti_krt_ppn')->name('rt-sm10.senarai_skuad_uniti_krt_ppn');
Route::get('/rt/sm10/senarai-skuad-uniti-krt-ppn-1/{id}',               'RT_SM10Controller@senarai_skuad_uniti_krt_ppn_1')->name('rt-sm10.senarai_skuad_uniti_krt_ppn_1');
Route::get('/rt/sm10/senarai-skuad-uniti-krt-hqrt',                     'RT_SM10Controller@senarai_skuad_uniti_krt_hqrt')->name('rt-sm10.senarai_skuad_uniti_krt_hqrt');
Route::get('/rt/sm10/senarai-skuad-uniti-krt-hqrt-1/{id}',              'RT_SM10Controller@senarai_skuad_uniti_krt_hqrt_1')->name('rt-sm10.senarai_skuad_uniti_krt_hqrt_1');
Route::get('/rt/sm10/permohonan-sejiwa-krt',                            'RT_SM10Controller@permohonan_sejiwa_krt')->name('rt-sm10.permohonan_sejiwa_krt');
Route::post('post_permohonan_sejiwa',                                   'RT_SM10Controller@post_permohonan_sejiwa')->name('rt-sm10.post_permohonan_sejiwa');
Route::get('/rt/sm10/permohonan-sejiwa-krt-1/{id}',                     'RT_SM10Controller@permohonan_sejiwa_krt_1')->name('rt-sm10.permohonan_sejiwa_krt_1');
Route::post('post_profil_sejiwa_krt',                                   'RT_SM10Controller@post_profil_sejiwa_krt')->name('rt-sm10.post_profil_sejiwa_krt');
Route::get('/rt/sm10/permohonan-sejiwa-krt-2/{id}',                     'RT_SM10Controller@permohonan_sejiwa_krt_2')->name('rt-sm10.permohonan_sejiwa_krt_2');
Route::get('get_senarai_ahli_sejiwa_table/{id}',                        'RT_SM10Controller@get_senarai_ahli_sejiwa_table')->name('rt-sm10.get_senarai_ahli_sejiwa_table');
Route::post('add_ahli_sejiwa',                                          'RT_SM10Controller@add_ahli_sejiwa')->name('rt-sm10.add_ahli_sejiwa');
Route::get('get_view_ahli_sejiwa/{id}',                                 'RT_SM10Controller@get_view_ahli_sejiwa')->name('rt-sm10.get_view_ahli_sejiwa');
Route::get('delete_ahli_sejiwa/{id}',                                   'RT_SM10Controller@delete_ahli_sejiwa')->name('rt-sm10.delete_ahli_sejiwa');
Route::get('get_senarai_perkhidmatan_sejiwa_table/{id}',                'RT_SM10Controller@get_senarai_perkhidmatan_sejiwa_table')->name('rt-sm10.get_senarai_perkhidmatan_sejiwa_table');
Route::post('add_perkhidmatan_sejiwa',                                  'RT_SM10Controller@add_perkhidmatan_sejiwa')->name('rt-sm10.add_perkhidmatan_sejiwa');
Route::get('get_view_perkhidmatan_sejiwa/{id}',                         'RT_SM10Controller@get_view_perkhidmatan_sejiwa')->name('rt-sm10.get_view_perkhidmatan_sejiwa');
Route::get('delete_perkhidmatan_sejiwa/{id}',                           'RT_SM10Controller@delete_perkhidmatan_sejiwa')->name('rt-sm10.delete_perkhidmatan_sejiwa');
Route::get('get_senarai_cabaran_sejiwa_table/{id}',                     'RT_SM10Controller@get_senarai_cabaran_sejiwa_table')->name('rt-sm10.get_senarai_cabaran_sejiwa_table');
Route::post('add_cabaran_sejiwa',                                       'RT_SM10Controller@add_cabaran_sejiwa')->name('rt-sm10.add_cabaran_sejiwa');
Route::get('get_view_cabaran_sejiwa/{id}',                              'RT_SM10Controller@get_view_cabaran_sejiwa')->name('rt-sm10.get_view_cabaran_sejiwa');
Route::get('delete_cabaran_sejiwa/{id}',                                'RT_SM10Controller@delete_cabaran_sejiwa')->name('rt-sm10.delete_cabaran_sejiwa');
Route::post('post_profil_sejiwa_krt_1',                                 'RT_SM10Controller@post_profil_sejiwa_krt_1')->name('rt-sm10.post_profil_sejiwa_krt_1');
Route::get('/rt/sm10/semakan-sejiwa-krt',                               'RT_SM10Controller@semakan_sejiwa_krt')->name('rt-sm10.semakan_sejiwa_krt');
Route::get('/rt/sm10/semakan-sejiwa-krt-1/{id}',                        'RT_SM10Controller@semakan_sejiwa_krt_1')->name('rt-sm10.semakan_sejiwa_krt_1');
Route::get('/rt/sm10/semakan-sejiwa-krt-2/{id}',                        'RT_SM10Controller@semakan_sejiwa_krt_2')->name('rt-sm10.semakan_sejiwa_krt_2');
Route::post('post_semakan_profile_sejiwa',                              'RT_SM10Controller@post_semakan_profile_sejiwa')->name('rt-sm10.post_semakan_profile_sejiwa');
Route::get('/rt/sm10/akui-sejiwa-krt',                                  'RT_SM10Controller@akui_sejiwa_krt')->name('rt-sm10.akui_sejiwa_krt');
Route::get('/rt/sm10/akui-sejiwa-krt-1/{id}',                           'RT_SM10Controller@akui_sejiwa_krt_1')->name('rt-sm10.akui_sejiwa_krt_1');
Route::get('/rt/sm10/akui-sejiwa-krt-2/{id}',                           'RT_SM10Controller@akui_sejiwa_krt_2')->name('rt-sm10.akui_sejiwa_krt_2');
Route::post('post_akui_profile_sejiwa',                                 'RT_SM10Controller@post_akui_profile_sejiwa')->name('rt-sm10.post_akui_profile_sejiwa');
Route::get('/rt/sm10/senarai-sejiwa-krt',                               'RT_SM10Controller@senarai_sejiwa_krt')->name('rt-sm10.senarai_sejiwa_krt');
Route::get('/rt/sm10/senarai-sejiwa-krt-1/{id}',                        'RT_SM10Controller@senarai_sejiwa_krt_1')->name('rt-sm10.senarai_sejiwa_krt_1');
Route::get('/rt/sm10/senarai-sejiwa-krt-2/{id}',                        'RT_SM10Controller@senarai_sejiwa_krt_2')->name('rt-sm10.senarai_sejiwa_krt_2');
Route::get('/rt/sm10/senarai-sejiwa-krt-ppd',                           'RT_SM10Controller@senarai_sejiwa_krt_ppd')->name('rt-sm10.senarai_sejiwa_krt_ppd');
Route::get('/rt/sm10/senarai-sejiwa-krt-ppd-1/{id}',                    'RT_SM10Controller@senarai_sejiwa_krt_ppd_1')->name('rt-sm10.senarai_sejiwa_krt_ppd_1');
Route::get('/rt/sm10/senarai-sejiwa-krt-ppd-2/{id}',                    'RT_SM10Controller@senarai_sejiwa_krt_ppd_2')->name('rt-sm10.senarai_sejiwa_krt_ppd_2');
Route::get('/rt/sm10/senarai-sejiwa-krt-ppn',                           'RT_SM10Controller@senarai_sejiwa_krt_ppn')->name('rt-sm10.senarai_sejiwa_krt_ppn');
Route::get('/rt/sm10/senarai-sejiwa-krt-ppn-1/{id}',                    'RT_SM10Controller@senarai_sejiwa_krt_ppn_1')->name('rt-sm10.senarai_sejiwa_krt_ppn_1');
Route::get('/rt/sm10/senarai-sejiwa-krt-ppn-2/{id}',                    'RT_SM10Controller@senarai_sejiwa_krt_ppn_2')->name('rt-sm10.senarai_sejiwa_krt_ppn_2');
Route::get('/rt/sm10/senarai-sejiwa-krt-hqrt',                          'RT_SM10Controller@senarai_sejiwa_krt_hqrt')->name('rt-sm10.senarai_sejiwa_krt_hqrt');
Route::get('/rt/sm10/senarai-sejiwa-krt-hqrt-1/{id}',                   'RT_SM10Controller@senarai_sejiwa_krt_hqrt_1')->name('rt-sm10.senarai_sejiwa_krt_hqrt_1');
Route::get('/rt/sm10/senarai-sejiwa-krt-hqrt-2/{id}',                   'RT_SM10Controller@senarai_sejiwa_krt_hqrt_2')->name('rt-sm10.senarai_sejiwa_krt_hqrt_2');
Route::get('/rt/sm10/permohonan-projek-ekonomi-krt',                    'RT_SM10Controller@permohonan_projek_ekonomi_krt')->name('rt-sm10.permohonan_projek_ekonomi_krt');
Route::post('post_permohonan_projek_ekonomi',                           'RT_SM10Controller@post_permohonan_projek_ekonomi')->name('rt-sm10.post_permohonan_projek_ekonomi');
Route::get('/rt/sm10/permohonan-projek-ekonomi-krt-1/{id}',             'RT_SM10Controller@permohonan_projek_ekonomi_krt_1')->name('rt-sm10.permohonan_projek_ekonomi_krt_1');
Route::post('post_permohonan_projek_ekonomi_1',                         'RT_SM10Controller@post_permohonan_projek_ekonomi_1')->name('rt-sm10.post_permohonan_projek_ekonomi_1');
Route::get('/rt/sm10/semakan-projek-ekonomi-krt',                       'RT_SM10Controller@semakan_projek_ekonomi_krt')->name('rt-sm10.semakan_projek_ekonomi_krt');
Route::get('/rt/sm10/semakan-projek-ekonomi-krt-1/{id}',                'RT_SM10Controller@semakan_projek_ekonomi_krt_1')->name('rt-sm10.semakan_projek_ekonomi_krt_1');
Route::post('post_semakan_projek_ekonomi',                              'RT_SM10Controller@post_semakan_projek_ekonomi')->name('rt-sm10.post_semakan_projek_ekonomi');
Route::get('/rt/sm10/pengesahan-projek-ekonomi-krt',                    'RT_SM10Controller@pengesahan_projek_ekonomi_krt')->name('rt-sm10.pengesahan_projek_ekonomi_krt');
Route::get('/rt/sm10/pengesahan-projek-ekonomi-krt-1/{id}',             'RT_SM10Controller@pengesahan_projek_ekonomi_krt_1')->name('rt-sm10.pengesahan_projek_ekonomi_krt_1');
Route::post('post_pengesahan_projek_ekonomi',                           'RT_SM10Controller@post_pengesahan_projek_ekonomi')->name('rt-sm10.post_pengesahan_projek_ekonomi');
Route::get('/rt/sm10/senarai-projek-ekonomi-krt',                       'RT_SM10Controller@senarai_projek_ekonomi_krt')->name('rt-sm10.senarai_projek_ekonomi_krt');
Route::get('/rt/sm10/senarai-projek-ekonomi-krt-1/{id}',                'RT_SM10Controller@senarai_projek_ekonomi_krt_1')->name('rt-sm10.senarai_projek_ekonomi_krt_1');
Route::get('/rt/sm10/senarai-projek-ekonomi-krt-ppd',                   'RT_SM10Controller@senarai_projek_ekonomi_krt_ppd')->name('rt-sm10.senarai_projek_ekonomi_krt_ppd');
Route::get('/rt/sm10/senarai-projek-ekonomi-krt-ppd-1/{id}',            'RT_SM10Controller@senarai_projek_ekonomi_krt_ppd_1')->name('rt-sm10.senarai_projek_ekonomi_krt_ppd_1');
Route::get('/rt/sm10/senarai-projek-ekonomi-krt-ppn',                   'RT_SM10Controller@senarai_projek_ekonomi_krt_ppn')->name('rt-sm10.senarai_projek_ekonomi_krt_ppn');
Route::get('/rt/sm10/senarai-projek-ekonomi-krt-ppn-1/{id}',            'RT_SM10Controller@senarai_projek_ekonomi_krt_ppn_1')->name('rt-sm10.senarai_projek_ekonomi_krt_ppn_1');
Route::get('/rt/sm10/senarai-projek-ekonomi-krt-hqrt',                  'RT_SM10Controller@senarai_projek_ekonomi_krt_hqrt')->name('rt-sm10.senarai_projek_ekonomi_krt_hqrt');
Route::get('/rt/sm10/senarai-projek-ekonomi-krt-hqrt-1/{id}',           'RT_SM10Controller@senarai_projek_ekonomi_krt_hqrt_1')->name('rt-sm10.senarai_projek_ekonomi_krt_hqrt_1');
Route::get('/rt/sm10/pelaksanaan-projek-ekonomi-st-krt',                'RT_SM10Controller@pelaksanaan_projek_ekonomi_st_krt')->name('rt-sm10.pelaksanaan_projek_ekonomi_st_krt');
Route::post('post_pelaksanaan_projek_ekonomi_st',                       'RT_SM10Controller@post_pelaksanaan_projek_ekonomi_st')->name('rt-sm10.post_pelaksanaan_projek_ekonomi_st');
Route::get('/rt/sm10/pelaksanaan-projek-ekonomi-st-krt-1/{id}',         'RT_SM10Controller@pelaksanaan_projek_ekonomi_st_krt_1')->name('rt-sm10.pelaksanaan_projek_ekonomi_st_krt_1');
Route::get('get_peserta_table/{id}',                                    'RT_SM10Controller@get_peserta_table')->name('rt-sm10.get_peserta_table');
Route::post('post_peserta_projek_ekonomi',                              'RT_SM10Controller@post_peserta_projek_ekonomi')->name('rt-sm10.post_peserta_projek_ekonomi');
Route::get('delete_peserta/{id}',                                       'RT_SM10Controller@delete_peserta')->name('rt-sm10.delete_peserta');
Route::post('post_pelaksanaan_projek_ekonomi_1',                        'RT_SM10Controller@post_pelaksanaan_projek_ekonomi_1')->name('rt-sm10.post_pelaksanaan_projek_ekonomi_1');
Route::get('/rt/sm10/semakan-projek-ekonomi-st-krt',                    'RT_SM10Controller@semakan_projek_ekonomi_st_krt')->name('rt-sm10.semakan_projek_ekonomi_st_krt');
Route::get('/rt/sm10/semakan-projek-ekonomi-st-krt-1/{id}',             'RT_SM10Controller@semakan_projek_ekonomi_st_krt_1')->name('rt-sm10.semakan_projek_ekonomi_st_krt_1');
Route::post('post_semakan_pelaksanaan_projek_ekonomi',                  'RT_SM10Controller@post_semakan_pelaksanaan_projek_ekonomi')->name('rt-sm10.post_semakan_pelaksanaan_projek_ekonomi');
Route::get('/rt/sm10/pengesahan-projek-ekonomi-st-krt',                 'RT_SM10Controller@pengesahan_projek_ekonomi_st_krt')->name('rt-sm10.pengesahan_projek_ekonomi_st_krt');
Route::get('/rt/sm10/pengesahan-projek-ekonomi-st-krt-1/{id}',          'RT_SM10Controller@pengesahan_projek_ekonomi_st_krt_1')->name('rt-sm10.pengesahan_projek_ekonomi_st_krt_1');
Route::post('post_pengesahan_pelaksanaan_projek_ekonomi',               'RT_SM10Controller@post_pengesahan_pelaksanaan_projek_ekonomi')->name('rt-sm10.post_pengesahan_pelaksanaan_projek_ekonomi');
Route::get('/rt/sm10/senarai-pelaksanaan-projek-ekonomi-krt',           'RT_SM10Controller@senarai_pelaksanaan_projek_ekonomi_krt')->name('rt-sm10.senarai_pelaksanaan_projek_ekonomi_krt');
Route::get('/rt/sm10/senarai-pelaksanaan-projek-ekonomi-krt-1/{id}',    'RT_SM10Controller@senarai_pelaksanaan_projek_ekonomi_krt_1')->name('rt-sm10.senarai_pelaksanaan_projek_ekonomi_krt_1');
Route::get('/rt/sm10/senarai-pelaksanaan-projek-ekonomi-ppd',           'RT_SM10Controller@senarai_pelaksanaan_projek_ekonomi_ppd')->name('rt-sm10.senarai_pelaksanaan_projek_ekonomi_ppd');
Route::get('/rt/sm10/senarai-pelaksanaan-projek-ekonomi-ppd-1/{id}',    'RT_SM10Controller@senarai_pelaksanaan_projek_ekonomi_ppd_1')->name('rt-sm10.senarai_pelaksanaan_projek_ekonomi_ppd_1');
Route::get('/rt/sm10/senarai-pelaksanaan-projek-ekonomi-ppn',           'RT_SM10Controller@senarai_pelaksanaan_projek_ekonomi_ppn')->name('rt-sm10.senarai_pelaksanaan_projek_ekonomi_ppn');
Route::get('/rt/sm10/senarai-pelaksanaan-projek-ekonomi-ppn-1/{id}',    'RT_SM10Controller@senarai_pelaksanaan_projek_ekonomi_ppn_1')->name('rt-sm10.senarai_pelaksanaan_projek_ekonomi_ppn_1');
Route::get('/rt/sm10/senarai-pelaksanaan-projek-ekonomi-hqrt',          'RT_SM10Controller@senarai_pelaksanaan_projek_ekonomi_hqrt')->name('rt-sm10.senarai_pelaksanaan_projek_ekonomi_hqrt');
Route::get('/rt/sm10/senarai-pelaksanaan-projek-ekonomi-hqrt-1/{id}',   'RT_SM10Controller@senarai_pelaksanaan_projek_ekonomi_hqrt_1')->name('rt-sm10.senarai_pelaksanaan_projek_ekonomi_hqrt_1');
Route::get('/rt/sm10/permohonan-koperasi-krt',                          'RT_SM10Controller@permohonan_koperasi_krt')->name('rt-sm10.permohonan_koperasi_krt');
Route::post('post_permohonan_koperasi',                                 'RT_SM10Controller@post_permohonan_koperasi')->name('rt-sm10.post_permohonan_koperasi');
Route::get('/rt/sm10/permohonan-koperasi-krt-1/{id}',                   'RT_SM10Controller@permohonan_koperasi_krt_1')->name('rt-sm10.permohonan_koperasi_krt_1');
Route::get('get_fungsi_koperasi_table/{id}',                            'RT_SM10Controller@get_fungsi_koperasi_table')->name('rt-sm10.get_fungsi_koperasi_table');
Route::post('post_add_fungsi_koperasi',                                 'RT_SM10Controller@post_add_fungsi_koperasi')->name('rt-sm10.post_add_fungsi_koperasi');
Route::post('post_delete_fungsi_koperasi',                              'RT_SM10Controller@post_delete_fungsi_koperasi')->name('rt-sm10.post_delete_fungsi_koperasi');
Route::get('get_aktiviti_tambahan_koperasi_table/{id}',                 'RT_SM10Controller@get_aktiviti_tambahan_koperasi_table')->name('rt-sm10.get_aktiviti_tambahan_koperasi_table');
Route::post('post_add_koperasi_aktiviti_tambahan',                      'RT_SM10Controller@post_add_koperasi_aktiviti_tambahan')->name('rt-sm10.post_add_koperasi_aktiviti_tambahan');
Route::post('post_delete_koperasi_aktiviti_tambahan',                   'RT_SM10Controller@post_delete_koperasi_aktiviti_tambahan')->name('rt-sm10.post_delete_koperasi_aktiviti_tambahan');
Route::post('post_permohonan_koperasi_1',                               'RT_SM10Controller@post_permohonan_koperasi_1')->name('rt-sm10.post_permohonan_koperasi_1');
Route::get('/rt/sm10/semakan-koperasi-krt',                             'RT_SM10Controller@semakan_koperasi_krt')->name('rt-sm10.semakan_koperasi_krt');
Route::get('/rt/sm10/semakan-koperasi-krt-1/{id}',                      'RT_SM10Controller@semakan_koperasi_krt_1')->name('rt-sm10.semakan_koperasi_krt_1');
Route::post('post_semakan_koperasi',                                    'RT_SM10Controller@post_semakan_koperasi')->name('rt-sm10.post_semakan_koperasi');
Route::get('/rt/sm10/pengesahan-koperasi-krt',                          'RT_SM10Controller@pengesahan_koperasi_krt')->name('rt-sm10.pengesahan_koperasi_krt');
Route::get('/rt/sm10/pengesahan-koperasi-krt-1/{id}',                   'RT_SM10Controller@pengesahan_koperasi_krt_1')->name('rt-sm10.pengesahan_koperasi_krt_1');
Route::post('post_pengesahan_koperasi',                                 'RT_SM10Controller@post_pengesahan_koperasi')->name('rt-sm10.post_pengesahan_koperasi');
Route::get('/rt/sm10/senarai-koperasi-krt',                             'RT_SM10Controller@senarai_koperasi_krt')->name('rt-sm10.senarai_koperasi_krt');
Route::get('/rt/sm10/senarai-koperasi-krt-1/{id}',                      'RT_SM10Controller@senarai_koperasi_krt_1')->name('rt-sm10.senarai_koperasi_krt_1');
Route::get('/rt/sm10/senarai-koperasi-ppd',                             'RT_SM10Controller@senarai_koperasi_ppd')->name('rt-sm10.senarai_koperasi_ppd');
Route::get('/rt/sm10/senarai-koperasi-ppd-1/{id}',                      'RT_SM10Controller@senarai_koperasi_ppd_1')->name('rt-sm10.senarai_koperasi_ppd_1');
Route::get('/rt/sm10/senarai-koperasi-ppn',                             'RT_SM10Controller@senarai_koperasi_ppn')->name('rt-sm10.senarai_koperasi_ppn');
Route::get('/rt/sm10/senarai-koperasi-ppn-1/{id}',                      'RT_SM10Controller@senarai_koperasi_ppn_1')->name('rt-sm10.senarai_koperasi_ppn_1');
Route::get('/rt/sm10/senarai-koperasi-hqrt',                            'RT_SM10Controller@senarai_koperasi_hqrt')->name('rt-sm10.senarai_koperasi_hqrt');
Route::get('/rt/sm10/senarai-koperasi-hqrt-1/{id}',                     'RT_SM10Controller@senarai_koperasi_hqrt_1')->name('rt-sm10.senarai_koperasi_hqrt_1');
Route::get('/rt/sm10/isu-lokasi-kanta-komuniti-krt',                    'RT_SM10Controller@isu_lokasi_kanta_komuniti_krt')->name('rt-sm10.isu_lokasi_kanta_komuniti_krt');
Route::post('post_lapor_isu_lokasi_kanta_komuniti',                     'RT_SM10Controller@post_lapor_isu_lokasi_kanta_komuniti')->name('rt-sm10.post_lapor_isu_lokasi_kanta_komuniti');
Route::get('/rt/sm10/isu-lokasi-kanta-komuniti-krt-1/{id}',             'RT_SM10Controller@isu_lokasi_kanta_komuniti_krt_1')->name('rt-sm10.isu_lokasi_kanta_komuniti_krt_1');
Route::get('get_senarai_terlibat_table/{id}',                           'RT_SM10Controller@get_senarai_terlibat_table')->name('rt-sm10.get_senarai_terlibat_table');
Route::post('post_isu_lokasi_kk_terlibat',                              'RT_SM10Controller@post_isu_lokasi_kk_terlibat')->name('rt-sm10.post_isu_lokasi_kk_terlibat');
Route::get('delete_isu_lokasi_kk_terlibat/{id}',                        'RT_SM10Controller@delete_isu_lokasi_kk_terlibat')->name('rt-sm10.delete_isu_lokasi_kk_terlibat');
Route::post('post_lapor_isu_lokasi_kanta_komuniti_1',                   'RT_SM10Controller@post_lapor_isu_lokasi_kanta_komuniti_1')->name('rt-sm10.post_lapor_isu_lokasi_kanta_komuniti_1');
Route::get('/rt/sm10/semakan-isu-lokasi-kanta-komuniti',                'RT_SM10Controller@semakan_isu_lokasi_kanta_komuniti')->name('rt-sm10.semakan_isu_lokasi_kanta_komuniti');
Route::get('/rt/sm10/semakan-isu-lokasi-kanta-komuniti-1/{id}',         'RT_SM10Controller@semakan_isu_lokasi_kanta_komuniti_1')->name('rt-sm10.semakan_isu_lokasi_kanta_komuniti_1');
Route::post('post_semakan_isu_lokasi_kanta_komuniti',                   'RT_SM10Controller@post_semakan_isu_lokasi_kanta_komuniti')->name('rt-sm10.post_semakan_isu_lokasi_kanta_komuniti');
Route::get('/rt/sm10/pengesahan-isu-lokasi-kanta-komuniti',             'RT_SM10Controller@pengesahan_isu_lokasi_kanta_komuniti')->name('rt-sm10.pengesahan_isu_lokasi_kanta_komuniti');
Route::get('/rt/sm10/pengesahan-isu-lokasi-kanta-komuniti-1/{id}',      'RT_SM10Controller@pengesahan_isu_lokasi_kanta_komuniti_1')->name('rt-sm10.pengesahan_isu_lokasi_kanta_komuniti_1');
Route::post('post_pengesahan_isu_lokasi_kanta_komuniti',                'RT_SM10Controller@post_pengesahan_isu_lokasi_kanta_komuniti')->name('rt-sm10.post_pengesahan_isu_lokasi_kanta_komuniti');
Route::get('/rt/sm10/analisa-isu-lokasi-kanta-komuniti',                'RT_SM10Controller@analisa_isu_lokasi_kanta_komuniti')->name('rt-sm10.analisa_isu_lokasi_kanta_komuniti');
Route::get('/rt/sm10/analisa-isu-lokasi-kanta-komuniti-1/{id}',         'RT_SM10Controller@analisa_isu_lokasi_kanta_komuniti_1')->name('rt-sm10.analisa_isu_lokasi_kanta_komuniti_1');
Route::get('/rt/sm10/analisa-isu-lokasi-kanta-komuniti-ppn',            'RT_SM10Controller@analisa_isu_lokasi_kanta_komuniti_ppn')->name('rt-sm10.analisa_isu_lokasi_kanta_komuniti_ppn');
Route::get('/rt/sm10/analisa-isu-lokasi-kanta-komuniti-ppn-1/{id}',     'RT_SM10Controller@analisa_isu_lokasi_kanta_komuniti_ppn_1')->name('rt-sm10.analisa_isu_lokasi_kanta_komuniti_ppn_1');

Route::get('/rt/sm10/permohonan-kanta-komuniti',                        'RT_SM10Controller@permohonan_kanta_komuniti')->name('rt-sm10.permohonan_kanta_komuniti');
Route::post('post_permohonan_kanta_komuniti',                           'RT_SM10Controller@post_permohonan_kanta_komuniti')->name('rt-sm10.post_permohonan_kanta_komuniti');
Route::get('/rt/sm10/permohonan-kanta-komuniti-1/{id}',                 'RT_SM10Controller@permohonan_kanta_komuniti_1')->name('rt-sm10.permohonan_kanta_komuniti_1');
Route::get('get_senarai_kaum_table/{id}',                               'RT_SM10Controller@get_senarai_kaum_table')->name('rt-sm10.get_senarai_kaum_table');
Route::post('/rt/sm10/add_kanta_komuniti_kaum',                         'RT_SM10Controller@add_kanta_komuniti_kaum')->name('rt-sm10.add_kanta_komuniti_kaum');
Route::get('delete_kaum/{id}',                                          'RT_SM10Controller@delete_kaum')->name('rt-sm10.delete_kaum');
Route::get('get_senarai_penduduk_table/{id}',                           'RT_SM10Controller@get_senarai_penduduk_table')->name('rt-sm10.get_senarai_penduduk_table');
Route::post('/rt/sm10/add_kanta_komuniti_penduduk',                     'RT_SM10Controller@add_kanta_komuniti_penduduk')->name('rt-sm10.add_kanta_komuniti_penduduk');
Route::get('delete_penduduk/{id}',                                      'RT_SM10Controller@delete_penduduk')->name('rt-sm10.delete_penduduk');
Route::post('post_permohonan_kanta_komuniti_1',                         'RT_SM10Controller@post_permohonan_kanta_komuniti_1')->name('rt-sm10.post_permohonan_kanta_komuniti_1');
Route::get('/rt/sm10/permohonan-kanta-komuniti-2/{id}',                 'RT_SM10Controller@permohonan_kanta_komuniti_2')->name('rt-sm10.permohonan_kanta_komuniti_2');
Route::get('get_senarai_risiko_kanta_table/{id}',                       'RT_SM10Controller@get_senarai_risiko_kanta_table')->name('rt-sm10.get_senarai_risiko_kanta_table');
Route::post('/rt/sm10/add_kanta_komuniti_risiko',                       'RT_SM10Controller@add_kanta_komuniti_risiko')->name('rt-sm10.add_kanta_komuniti_risiko');
Route::get('delete_risiko_kanta/{id}',                                  'RT_SM10Controller@delete_risiko_kanta')->name('rt-sm10.delete_risiko_kanta');
Route::post('post_permohonan_kanta_komuniti_2',                         'RT_SM10Controller@post_permohonan_kanta_komuniti_2')->name('rt-sm10.post_permohonan_kanta_komuniti_2');
Route::get('/rt/sm10/permohonan-kanta-komuniti-3/{id}',                 'RT_SM10Controller@permohonan_kanta_komuniti_3')->name('rt-sm10.permohonan_kanta_komuniti_3');
Route::get('get_senarai_masalah_kanta_table/{id}',                      'RT_SM10Controller@get_senarai_masalah_kanta_table')->name('rt-sm10.get_senarai_masalah_kanta_table');
Route::post('/rt/sm10/add_kanta_komuniti_masalah',                      'RT_SM10Controller@add_kanta_komuniti_masalah')->name('rt-sm10.add_kanta_komuniti_masalah');
Route::get('delete_masalah_kanta/{id}',                                 'RT_SM10Controller@delete_masalah_kanta')->name('rt-sm10.delete_masalah_kanta');
Route::get('get_senarai_krt_kanta_table/{id}',                          'RT_SM10Controller@get_senarai_krt_kanta_table')->name('rt-sm10.get_senarai_krt_kanta_table');
Route::post('/rt/sm10/add_kanta_komuniti_krt',                          'RT_SM10Controller@add_kanta_komuniti_krt')->name('rt-sm10.add_kanta_komuniti_krt');
Route::get('delete_krt_kanta/{id}',                                     'RT_SM10Controller@delete_krt_kanta')->name('rt-sm10.delete_krt_kanta');
Route::get('/rt/sm10/permohonan-kanta-komuniti-4/{id}',                 'RT_SM10Controller@permohonan_kanta_komuniti_4')->name('rt-sm10.permohonan_kanta_komuniti_4');
Route::get('get_senarai_langkah_masalah_kanta_table/{id}',              'RT_SM10Controller@get_senarai_langkah_masalah_kanta_table')->name('rt-sm10.get_senarai_langkah_masalah_kanta_table');
Route::post('/rt/sm10/add_kanta_komuniti_langkah_masalah',              'RT_SM10Controller@add_kanta_komuniti_langkah_masalah')->name('rt-sm10.add_kanta_komuniti_langkah_masalah');
Route::get('delete_langkah_masalah_kanta/{id}',                         'RT_SM10Controller@delete_langkah_masalah_kanta')->name('rt-sm10.delete_langkah_masalah_kanta');
Route::get('get_senarai_pemimpin_kanta_table/{id}',                     'RT_SM10Controller@get_senarai_pemimpin_kanta_table')->name('rt-sm10.get_senarai_pemimpin_kanta_table');
Route::post('/rt/sm10/add_kanta_komuniti_pemimpin',                     'RT_SM10Controller@add_kanta_komuniti_pemimpin')->name('rt-sm10.add_kanta_komuniti_pemimpin');
Route::get('delete_pemimpin_kanta/{id}',                                'RT_SM10Controller@delete_pemimpin_kanta')->name('rt-sm10.delete_pemimpin_kanta');
Route::post('post_permohonan_kanta_komuniti_3',                         'RT_SM10Controller@post_permohonan_kanta_komuniti_3')->name('rt-sm10.post_permohonan_kanta_komuniti_3');
Route::get('/rt/sm10/semakan-kanta-komuniti',                           'RT_SM10Controller@semakan_kanta_komuniti')->name('rt-sm10.semakan_kanta_komuniti');
Route::get('/rt/sm10/semakan-kanta-komuniti-1/{id}',                    'RT_SM10Controller@semakan_kanta_komuniti_1')->name('rt-sm10.semakan_kanta_komuniti_1');
Route::get('/rt/sm10/semakan-kanta-komuniti-2/{id}',                    'RT_SM10Controller@semakan_kanta_komuniti_2')->name('rt-sm10.semakan_kanta_komuniti_2');
Route::get('/rt/sm10/semakan-kanta-komuniti-3/{id}',                    'RT_SM10Controller@semakan_kanta_komuniti_3')->name('rt-sm10.semakan_kanta_komuniti_3');
Route::get('/rt/sm10/semakan-kanta-komuniti-4/{id}',                    'RT_SM10Controller@semakan_kanta_komuniti_4')->name('rt-sm10.semakan_kanta_komuniti_4');
Route::post('post_semakan_kanta_komuniti',                              'RT_SM10Controller@post_semakan_kanta_komuniti')->name('rt-sm10.post_semakan_kanta_komuniti');
Route::get('/rt/sm10/pengesahan-kanta-komuniti',                        'RT_SM10Controller@pengesahan_kanta_komuniti')->name('rt-sm10.pengesahan_kanta_komuniti');
Route::get('/rt/sm10/pengesahan-kanta-komuniti-1/{id}',                 'RT_SM10Controller@pengesahan_kanta_komuniti_1')->name('rt-sm10.pengesahan_kanta_komuniti_1');
Route::get('/rt/sm10/pengesahan-kanta-komuniti-2/{id}',                 'RT_SM10Controller@pengesahan_kanta_komuniti_2')->name('rt-sm10.pengesahan_kanta_komuniti_2');
Route::get('/rt/sm10/pengesahan-kanta-komuniti-3/{id}',                 'RT_SM10Controller@pengesahan_kanta_komuniti_3')->name('rt-sm10.pengesahan_kanta_komuniti_3');
Route::get('/rt/sm10/pengesahan-kanta-komuniti-4/{id}',                 'RT_SM10Controller@pengesahan_kanta_komuniti_4')->name('rt-sm10.pengesahan_kanta_komuniti_4');
Route::post('post_pengesahan_kanta_komuniti',                           'RT_SM10Controller@post_pengesahan_kanta_komuniti')->name('rt-sm10.post_pengesahan_kanta_komuniti');
Route::get('/rt/sm10/senarai-kanta-komuniti-ppd',                       'RT_SM10Controller@senarai_kanta_komuniti_ppd')->name('rt-sm10.senarai_kanta_komuniti_ppd');
Route::get('/rt/sm10/senarai-kanta-komuniti-ppd-1/{id}',                'RT_SM10Controller@senarai_kanta_komuniti_ppd_1')->name('rt-sm10.senarai_kanta_komuniti_ppd_1');
Route::get('/rt/sm10/senarai-kanta-komuniti-ppd-2/{id}',                'RT_SM10Controller@senarai_kanta_komuniti_ppd_2')->name('rt-sm10.senarai_kanta_komuniti_ppd_2');
Route::get('/rt/sm10/senarai-kanta-komuniti-ppd-3/{id}',                'RT_SM10Controller@senarai_kanta_komuniti_ppd_3')->name('rt-sm10.senarai_kanta_komuniti_ppd_3');
Route::get('/rt/sm10/senarai-kanta-komuniti-ppd-4/{id}',                'RT_SM10Controller@senarai_kanta_komuniti_ppd_4')->name('rt-sm10.senarai_kanta_komuniti_ppd_4');
Route::get('/rt/sm10/senarai-kanta-komuniti-ppn',                       'RT_SM10Controller@senarai_kanta_komuniti_ppn')->name('rt-sm10.senarai_kanta_komuniti_ppn');
Route::get('/rt/sm10/senarai-kanta-komuniti-ppn-1/{id}',                'RT_SM10Controller@senarai_kanta_komuniti_ppn_1')->name('rt-sm10.senarai_kanta_komuniti_ppn_1');
Route::get('/rt/sm10/senarai-kanta-komuniti-ppn-2/{id}',                'RT_SM10Controller@senarai_kanta_komuniti_ppn_2')->name('rt-sm10.senarai_kanta_komuniti_ppn_2');
Route::get('/rt/sm10/senarai-kanta-komuniti-ppn-3/{id}',                'RT_SM10Controller@senarai_kanta_komuniti_ppn_3')->name('rt-sm10.senarai_kanta_komuniti_ppn_3');
Route::get('/rt/sm10/senarai-kanta-komuniti-ppn-4/{id}',                'RT_SM10Controller@senarai_kanta_komuniti_ppn_4')->name('rt-sm10.senarai_kanta_komuniti_ppn_4');
Route::get('/rt/sm10/senarai-kanta-komuniti-hq',                        'RT_SM10Controller@senarai_kanta_komuniti_hq')->name('rt-sm10.senarai_kanta_komuniti_hq');
Route::get('/rt/sm10/senarai-kanta-komuniti-hq-1/{id}',                 'RT_SM10Controller@senarai_kanta_komuniti_hq_1')->name('rt-sm10.senarai_kanta_komuniti_hq_1');
Route::get('/rt/sm10/senarai-kanta-komuniti-hq-2/{id}',                 'RT_SM10Controller@senarai_kanta_komuniti_hq_2')->name('rt-sm10.senarai_kanta_komuniti_hq_2');
Route::get('/rt/sm10/senarai-kanta-komuniti-hq-3/{id}',                 'RT_SM10Controller@senarai_kanta_komuniti_hq_3')->name('rt-sm10.senarai_kanta_komuniti_hq_3');
Route::get('/rt/sm10/senarai-kanta-komuniti-hq-4/{id}',                 'RT_SM10Controller@senarai_kanta_komuniti_hq_4')->name('rt-sm10.senarai_kanta_komuniti_hq_4');

Route::get('/rt/sm10/rekod-profil-skuad-unit',                          'RT_SM10Controller@rekod_profil_skuad_unit')->name('rt-sm10.rekod_profil_skuad_unit');
Route::get('/rt/sm10/add-profile-skuad-uniti-ppd',                      'RT_SM10Controller@add_profile_skuad_uniti_ppd')->name('rt-sm10.add_profile_skuad_uniti_ppd');
Route::get('/rt/sm10/perancangan-aktivti-uniti',                        'RT_SM10Controller@perancangan_aktivti_uniti')->name('rt-sm10.perancangan_aktivti_uniti');
Route::get('/rt/sm10/add-perancangan-skuad-uniti-ppd',                  'RT_SM10Controller@add_perancangan_skuad_uniti_ppd')->name('rt-sm10.add_perancangan_skuad_uniti_ppd');
Route::get('/rt/sm10/menyemak-perancangan-aktivti-uniti',               'RT_SM10Controller@menyemak_perancangan_aktivti_uniti')->name('rt-sm10.menyemak_perancangan_aktivti_uniti');
Route::get('/rt/sm10/menyemak-perancangan-aktivti-uniti-ppn',           'RT_SM10Controller@menyemak_perancangan_aktivti_uniti_ppn')->name('rt-sm10.menyemak_perancangan_aktivti_uniti_ppn');
Route::get('/rt/sm10/memperakui-perancangan-aktivti-uniti',             'RT_SM10Controller@memperakui_perancangan_aktivti_uniti')->name('rt-sm10.memperakui_perancangan_aktivti_uniti');
Route::get('/rt/sm10/memperakui-perancangan-aktivti-uniti-hq',          'RT_SM10Controller@memperakui_perancangan_aktivti_uniti_hq')->name('rt-sm10.memperakui_perancangan_aktivti_uniti_hq');
Route::get('/rt/sm10/rekod-profil-sejiwa',                              'RT_SM10Controller@rekod_profil_sejiwa')->name('rt-sm10.rekod_profil_sejiwa');
Route::get('/rt/sm10/add-profile-sejiwa-ppd',                           'RT_SM10Controller@add_profile_sejiwa_ppd')->name('rt-sm10.add_profile_sejiwa_ppd');
Route::get('/rt/sm10/add-profile-sejiwa-ppd-1',                         'RT_SM10Controller@add_profile_sejiwa_ppd_1')->name('rt-sm10.add_profile_sejiwa_ppd_1');
Route::get('/rt/sm10/perancangan-aktivti-sejiwa',                       'RT_SM10Controller@perancangan_aktivti_sejiwa')->name('rt-sm10.perancangan_aktivti_sejiwa');
Route::get('/rt/sm10/add-perancangan-sejiwa-ppd',                       'RT_SM10Controller@add_perancangan_sejiwa_ppd')->name('rt-sm10.add_perancangan_sejiwa_ppd');
Route::get('/rt/sm10/menyemak-perancangan-aktivti-sejiwa',              'RT_SM10Controller@menyemak_perancangan_aktivti_sejiwa')->name('rt-sm10.menyemak_perancangan_aktivti_sejiwa');
Route::get('/rt/sm10/menyemak-perancangan-aktivti-sejiwa-ppn',          'RT_SM10Controller@menyemak_perancangan_aktivti_sejiwa_ppn')->name('rt-sm10.menyemak_perancangan_aktivti_sejiwa_ppn');
Route::get('/rt/sm10/menyemak-perancangan-aktivti-sejiwa-ppn-1',        'RT_SM10Controller@menyemak_perancangan_aktivti_sejiwa_ppn_1')->name('rt-sm10.menyemak_perancangan_aktivti_sejiwa_ppn_1');
Route::get('/rt/sm10/memperakui-perancangan-aktivti-sejiwa',            'RT_SM10Controller@memperakui_perancangan_aktivti_sejiwa')->name('rt-sm10.memperakui_perancangan_aktivti_sejiwa');
Route::get('/rt/sm10/memperakui-perancangan-aktivti-sejiwa-ppn',        'RT_SM10Controller@memperakui_perancangan_aktivti_sejiwa_ppn')->name('rt-sm10.memperakui_perancangan_aktivti_sejiwa_ppn');
Route::get('/rt/sm10/memperakui-perancangan-aktivti-sejiwa-ppn-1',      'RT_SM10Controller@memperakui_perancangan_aktivti_sejiwa_ppn_1')->name('rt-sm10.memperakui_perancangan_aktivti_sejiwa_ppn_1');
Route::get('/rt/sm10/senarai-psk',                                      'RT_SM10Controller@senarai_psk')->name('rt-sm10.senarai_psk');
Route::get('/rt/sm10/add-profile-psk',                                  'RT_SM10Controller@add_profile_psk')->name('rt-sm10.add_profile_psk');

/* Modul e-RT - Sub Modul 10 :  Program Outcome Based Budgeting (OBB) / PSK */
Route::get('/rt/sm10/add-profile-psk-1',                                'RT_SM10Controller@add_profile_psk_1')->name('rt-sm10.add_profile_psk_1');
Route::get('/rt/sm10/add-profile-psk-2',                                'RT_SM10Controller@add_profile_psk_2')->name('rt-sm10.add_profile_psk_2');
Route::get('/rt/sm10/add-profile-psk-3',                                'RT_SM10Controller@add_profile_psk_3')->name('rt-sm10.add_profile_psk_3');
Route::get('/rt/sm10/add-profile-psk-4',                                'RT_SM10Controller@add_profile_psk_4')->name('rt-sm10.add_profile_psk_4');
Route::get('/rt/sm10/semakan-senarai-psk',                              'RT_SM10Controller@semakan_senarai_psk')->name('rt-sm10.semakan_senarai_psk');
Route::get('/rt/sm10/menyemak-profile-psk',                             'RT_SM10Controller@menyemak_profile_psk')->name('rt-sm10.menyemak_profile_psk');
Route::get('/rt/sm10/menyemak-profile-psk-1',                           'RT_SM10Controller@menyemak_profile_psk_1')->name('rt-sm10.menyemak_profile_psk_1');
Route::get('/rt/sm10/menyemak-profile-psk-2',                           'RT_SM10Controller@menyemak_profile_psk_2')->name('rt-sm10.menyemak_profile_psk_2');
Route::get('/rt/sm10/pengesahan-senarai-psk',                           'RT_SM10Controller@pengesahan_senarai_psk')->name('rt-sm10.pengesahan_senarai_psk');
Route::get('/rt/sm10/pengesahan-profile-psk',                           'RT_SM10Controller@pengesahan_profile_psk')->name('rt-sm10.pengesahan_profile_psk');
Route::get('/rt/sm10/senarai-laporan-aktivti-psk',                      'RT_SM10Controller@senarai_laporan_aktivti_psk')->name('rt-sm10.senarai_laporan_aktivti_psk');
Route::get('/rt/sm10/add-laporan-aktiviti-psk',                         'RT_SM10Controller@add_laporan_aktiviti_psk')->name('rt-sm10.add_laporan_aktiviti_psk');
Route::get('/rt/sm10/add-laporan-aktiviti-psk-1',                       'RT_SM10Controller@add_laporan_aktiviti_psk_1')->name('rt-sm10.add_laporan_aktiviti_psk_1');
Route::get('/rt/sm10/add-laporan-aktiviti-psk-2',                       'RT_SM10Controller@add_laporan_aktiviti_psk_2')->name('rt-sm10.add_laporan_aktiviti_psk_2');
Route::get('/rt/sm10/add-laporan-aktiviti-psk-3',                       'RT_SM10Controller@add_laporan_aktiviti_psk_3')->name('rt-sm10.add_laporan_aktiviti_psk_3');
Route::get('/rt/sm10/senarai-laporan-aktivti-psk-ppd',                  'RT_SM10Controller@senarai_laporan_aktivti_psk_ppd')->name('rt-sm10.senarai_laporan_aktivti_psk_ppd');
Route::get('/rt/sm10/sah-laporan-aktiviti-psk-ppd',                     'RT_SM10Controller@sah_laporan_aktiviti_psk_ppd')->name('rt-sm10.sah_laporan_aktiviti_psk_ppd');
Route::get('/rt/sm10/sah-laporan-aktiviti-psk-ppd-1',                   'RT_SM10Controller@sah_laporan_aktiviti_psk_ppd_1')->name('rt-sm10.sah_laporan_aktiviti_psk_ppd_1');
Route::get('/rt/sm10/sah-laporan-aktiviti-psk-ppd-2',                   'RT_SM10Controller@sah_laporan_aktiviti_psk_ppd_2')->name('rt-sm10.sah_laporan_aktiviti_psk_ppd_2');
Route::get('/rt/sm10/sah-laporan-aktiviti-psk-ppd-3',                   'RT_SM10Controller@sah_laporan_aktiviti_psk_ppd_3')->name('rt-sm10.sah_laporan_aktiviti_psk_ppd_3');
Route::get('/rt/sm10/senarai-laporan-isu-psk',                          'RT_SM10Controller@senarai_laporan_isu_psk')->name('rt-sm10.senarai_laporan_isu_psk');
Route::get('/rt/sm10/add-laporan-isu-psk',                              'RT_SM10Controller@add_laporan_isu_psk')->name('rt-sm10.add_laporan_isu_psk');
Route::get('/rt/sm10/senarai-laporan-isu-psk-ppd',                      'RT_SM10Controller@senarai_laporan_isu_psk_ppd')->name('rt-sm10.senarai_laporan_isu_psk_ppd');
Route::get('/rt/sm10/semakan-laporan-isu-psk',                          'RT_SM10Controller@semakan_laporan_isu_psk')->name('rt-sm10.semakan_laporan_isu_psk');
Route::get('/rt/sm10/senarai-laporan-isu-psk-ppn',                      'RT_SM10Controller@senarai_laporan_isu_psk_ppn')->name('rt-sm10.senarai_laporan_isu_psk_ppn');
Route::get('/rt/sm10/pengesahan-laporan-isu-psk',                       'RT_SM10Controller@pengesahan_laporan_isu_psk')->name('rt-sm10.pengesahan_laporan_isu_psk');

/* Modul e-RT - Sub Modul 10 :  Program Outcome Based Budgeting (OBB) / Projek Ekonomi RT */
Route::get('/rt/sm10/senarai-projek-ekonomi',                           'RT_SM10Controller@senarai_projek_ekonomi')->name('rt-sm10.senarai_projek_ekonomi');
Route::get('/rt/sm10/add-profile-projek-ekonomi',                       'RT_SM10Controller@add_profile_projek_ekonomi')->name('rt-sm10.add_profile_projek_ekonomi');
Route::get('/rt/sm10/senarai-semakan-projek-ekonomi-ppd',               'RT_SM10Controller@senarai_semakan_projek_ekonomi_ppd')->name('rt-sm10.senarai_semakan_projek_ekonomi_ppd');
Route::get('/rt/sm10/menyemak-projek-ekonomi-ppd',                      'RT_SM10Controller@menyemak_projek_ekonomi_ppd')->name('rt-sm10.menyemak_projek_ekonomi_ppd');
Route::get('/rt/sm10/senarai-pengesahan-projek-ekonomi-ppn',            'RT_SM10Controller@senarai_pengesahan_projek_ekonomi_ppn')->name('rt-sm10.senarai_pengesahan_projek_ekonomi_ppn');
Route::get('/rt/sm10/pengesahan-projek-ekonomi-ppn',                    'RT_SM10Controller@pengesahan_projek_ekonomi_ppn')->name('rt-sm10.pengesahan_projek_ekonomi_ppn');
Route::get('/rt/sm10/senarai-laporan-projek-ekonomi',                   'RT_SM10Controller@senarai_laporan_projek_ekonomi')->name('rt-sm10.senarai_laporan_projek_ekonomi');
Route::get('/rt/sm10/add-laporan-projek-ekonomi',                       'RT_SM10Controller@add_laporan_projek_ekonomi')->name('rt-sm10.add_laporan_projek_ekonomi');
Route::get('/rt/sm10/senarai-semakan-laporan-projek-ekonomi',           'RT_SM10Controller@senarai_semakan_laporan_projek_ekonomi')->name('rt-sm10.senarai_semakan_laporan_projek_ekonomi');
Route::get('/rt/sm10/menyemak-laporan-projek-ekonomi',                  'RT_SM10Controller@menyemak_laporan_projek_ekonomi')->name('rt-sm10.menyemak_laporan_projek_ekonomi');
Route::get('/rt/sm10/senarai-pengesahan-laporan-projek-ekonomi',        'RT_SM10Controller@senarai_pengesahan_laporan_projek_ekonomi')->name('rt-sm10.senarai_pengesahan_laporan_projek_ekonomi');
Route::get('/rt/sm10/pengesahan-laporan-projek-ekonomi',                'RT_SM10Controller@pengesahan_laporan_projek_ekonomi')->name('rt-sm10.pengesahan_laporan_projek_ekonomi');

/* Modul e-RT - Sub Modul 10 :  Program Outcome Based Budgeting (OBB) / Koperasi KRT */
Route::get('/rt/sm10/add-profile-koperasi-krt',                         'RT_SM10Controller@add_profile_koperasi_krt')->name('rt-sm10.add_profile_koperasi_krt');
Route::get('/rt/sm10/senarai-semakan-koperasi-krt',                     'RT_SM10Controller@senarai_semakan_koperasi_krt')->name('rt-sm10.senarai_semakan_koperasi_krt');
Route::get('/rt/sm10/menyemak-koperasi-krt-ppd',                        'RT_SM10Controller@menyemak_koperasi_krt_ppd')->name('rt-sm10.menyemak_koperasi_krt_ppd');
Route::get('/rt/sm10/senarai-pengesahan-koperasi-krt',                  'RT_SM10Controller@senarai_pengesahan_koperasi_krt')->name('rt-sm10.senarai_pengesahan_koperasi_krt');
Route::get('/rt/sm10/pengesahan-koperasi-krt-ppn',                      'RT_SM10Controller@pengesahan_koperasi_krt_ppn')->name('rt-sm10.pengesahan_koperasi_krt_ppn');
Route::get('/rt/sm10/view-profil-koperasi-krt',                         'RT_SM10Controller@view_profil_koperasi_krt')->name('rt-sm10.view_profil_koperasi_krt');
Route::get('/rt/sm10/senarai-laporan-aktif-koperasi-krt',               'RT_SM10Controller@senarai_laporan_aktif_koperasi_krt')->name('rt-sm10.senarai_laporan_aktif_koperasi_krt');
Route::get('/rt/sm10/laporan-aktif-koperasi-krt-ppd',                   'RT_SM10Controller@laporan_aktif_koperasi_krt_ppd')->name('rt-sm10.laporan_aktif_koperasi_krt_ppd');
Route::get('/rt/sm10/senarai-p-laporan-aktif-koperasi-krt',             'RT_SM10Controller@senarai_p_laporan_aktif_koperasi_krt')->name('rt-sm10.senarai_p_laporan_aktif_koperasi_krt');
Route::get('/rt/sm10/p-laporan-aktif-koperasi-krt-ppn',                 'RT_SM10Controller@p_laporan_aktif_koperasi_krt_ppn')->name('rt-sm10.p_laporan_aktif_koperasi_krt_ppn');
Route::get('/rt/sm10/senarai-keaktifan-koperasi-krt',                   'RT_SM10Controller@senarai_keaktifan_koperasi_krt')->name('rt-sm10.senarai_keaktifan_koperasi_krt');

/* Modul e-RT - Sub Modul 11 :  Pemulihan KRT Tidak Aktif */
Route::get('/rt/sm11/keaktifan-krt-ppd',                                'RT_SM11Controller@keaktifan_krt_ppd')->name('rt-sm11.keaktifan_krt_ppd');
Route::get('/rt/sm11/keaktifan-krt-ppd-kunci',                          'RT_SM11Controller@keaktifan_krt_ppd_kunci')->name('rt-sm11.keaktifan_krt_ppd_kunci');
Route::post('add_markah_keaktifan_ppd',                                 'RT_SM11Controller@add_markah_keaktifan_ppd')->name('rt-sm11.add_markah_keaktifan_ppd');
Route::get('/rt/sm11/keaktifan-krt',                                    'RT_SM11Controller@keaktifan_krt')->name('rt-sm11.keaktifan_krt');
Route::get('/rt/sm11/keaktifan-krt-ppn',                                'RT_SM11Controller@keaktifan_krt_ppn')->name('rt-sm11.keaktifan_krt_ppn');
Route::get('/rt/sm11/keaktifan-krt-hqrt',                               'RT_SM11Controller@keaktifan_krt_hqrt')->name('rt-sm11.keaktifan_krt_hqrt');
Route::get('/rt/sm11/pemulihan-krt-ppd',                                'RT_SM11Controller@pemulihan_krt_ppd')->name('rt-sm11.pemulihan_krt_ppd');
Route::get('/rt/sm11/pemulihan-krt-ppd-1/{id}',                         'RT_SM11Controller@pemulihan_krt_ppd_1')->name('rt-sm11.pemulihan_krt_ppd_1');
Route::post('post_laporan_pemulihan',                                   'RT_SM11Controller@post_laporan_pemulihan')->name('rt-sm11.post_laporan_pemulihan');
Route::post('post_laporan_pemulihan2',                                  'RT_SM11Controller@post_laporan_pemulihan2')->name('rt-sm11.post_laporan_pemulihan2');
Route::get('/rt/sm11/pemulihan-krt-ppn',                                'RT_SM11Controller@pemulihan_krt_ppn')->name('rt-sm11.pemulihan_krt_ppn');
Route::get('/rt/sm11/pemulihan-krt-ppn-1/{id}',                         'RT_SM11Controller@pemulihan_krt_ppn_1')->name('rt-sm11.pemulihan_krt_ppn_1');
Route::post('post_semakan_pemulihan_krt',                               'RT_SM11Controller@post_semakan_pemulihan_krt')->name('rt-sm11.post_semakan_pemulihan_krt');

Route::get('/rt/sm11/senarai-laporan-pemulihan-krt-tidak-aktif',        'RT_SM11Controller@senarai_laporan_pemulihan_krt_tidak_aktif')->name('rt-sm11.senarai_laporan_pemulihan_krt_tidak_aktif');
Route::get('/rt/sm11/add-krt-tidak-aktif',                              'RT_SM11Controller@add_krt_tidak_aktif')->name('rt-sm11.add_krt_tidak_aktif');
Route::get('/rt/sm11/senarai-laporan-pemulihan-krt-tidak-aktif-ppn',    'RT_SM11Controller@senarai_laporan_pemulihan_krt_tidak_aktif_ppn')->name('rt-sm11.senarai_laporan_pemulihan_krt_tidak_aktif_ppn');
Route::get('/rt/sm11/pengesahan-krt-tidak-aktif-ppn',                   'RT_SM11Controller@pengesahan_krt_tidak_aktif_ppn')->name('rt-sm11.pengesahan_krt_tidak_aktif_ppn');
Route::get('/rt/sm11/get_excel_file/state/{state}/parlimen/{parlimen}/daerah/{daerah}/dun/{dun}/krt/{krt}/tahun/{tahun}/kunci_ajk/{kunci_ajk}/kunci_aktiviti/{kunci_aktiviti}/kunci_mesyuarat/{kunci_mesyuarat}/kunci_kewangan/{kunci_kewangan}', 'RT_SM11Controller@get_excel_file')->name('rt-sm11.get_excel_file');


/* Modul e-RT - Sub Modul 12 : Penubuhan SRS */
Route::get('/rt/sm12', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm12/senarai-srs',                                        'RT_SM12Controller@list_senarai_srs')->name('rt-sm12.senarai_srs');
Route::post('post_create_permohonan_penubuhan_srs',                     'RT_SM12Controller@create_permohonan_penubuhan_srs')->name('rt-sm12.post_create_permohonan_penubuhan_srs');
Route::get('/rt/sm12/permohonan-penubuhan-srs/{id}',                    'RT_SM12Controller@permohonan_penubuhan_srs')->name('rt-sm12.permohonan_penubuhan_srs');
Route::post('/rt/sm12/update_kemaskini_srs_profile',                    'RT_SM12Controller@update_kemaskini_srs_profile')->name('rt-sm12.update_kemaskini_srs_profile');
Route::get('/rt/sm12/permohonan-penubuhan-srs-1/{id}',                    'RT_SM12Controller@permohonan_penubuhan_srs_1')->name('rt-sm12.permohonan_penubuhan_srs_1');
Route::get('get_senarai_peronda_table/{id}',                            'RT_SM12Controller@senarai_peronda_table')->name('rt-sm12.get_senarai_peronda_table');
Route::post('post_peronda',                                             'RT_SM12Controller@add_peronda')->name('rt-sm12.post_peronda');
Route::get('delete_peronda/{id}',                                       'RT_SM12Controller@delete_peronda')->name('rt-sm12.delete_peronda');
Route::get('get_senarai_peronda_sukarela_table/{id}',                   'RT_SM12Controller@senarai_peronda_sukarela_table')->name('rt-sm12.get_senarai_peronda_sukarela_table');
Route::post('post_peronda_sukarela',                                    'RT_SM12Controller@add_peronda_sukarela')->name('rt-sm12.post_peronda_sukarela');
Route::get('delete_peronda_sukarela/{id}',                              'RT_SM12Controller@delete_peronda_sukarela')->name('rt-sm12.delete_peronda_sukarela');
Route::get('/rt/sm12/permohonan-penubuhan-srs-2/{id}',                    'RT_SM12Controller@permohonan_penubuhan_srs_2')->name('rt-sm12.permohonan_penubuhan_srs_2');
Route::get('get_senarai_minit_meeting_table/{id}',                      'RT_SM12Controller@get_senarai_minit_meeting_table')->name('rt-sm12.get_senarai_minit_meeting_table');
Route::post('post_minit_meeting',                                       'RT_SM12Controller@post_minit_meeting')->name('rt-sm12.post_minit_meeting');
Route::get('delete_senarai_minit_meeting/{id}',                         'RT_SM12Controller@delete_senarai_minit_meeting')->name('rt-sm12.delete_senarai_minit_meeting');
Route::post('post_hantar_permohonan_pertubuhan_srs',                    'RT_SM12Controller@hantar_permohonan_pertubuhan_srs')->name('rt-sm12.post_hantar_permohonan_pertubuhan_srs');

Route::get('/rt/sm12/profile-srs-p-1/{id}',                             'RT_SM12Controller@profile_srs_p_1')->name('rt-sm12.profile_srs_p_1');
Route::get('/rt/sm12/profile-srs-p-2/{id}',                             'RT_SM12Controller@profile_srs_p_2')->name('rt-sm12.profile_srs_p_2');

Route::get('/rt/sm12/semak-permohonan-penubuhan-srs',                    'RT_SM12Controller@semak_permohonan_penubuhan_srs')->name('rt-sm12.semak_permohonan_penubuhan_srs');
Route::get('/rt/sm12/semak-permohonan-penubuhan-srs-ppd/{id}',            'RT_SM12Controller@semak_permohonan_penubuhan_srs_ppd')->name('rt-sm12.semak_permohonan_penubuhan_srs_ppd');
Route::get('/rt/sm12/semak-permohonan-penubuhan-srs-ppd-1/{id}',        'RT_SM12Controller@semak_permohonan_penubuhan_srs_ppd_1')->name('rt-sm12.semak_permohonan_penubuhan_srs_ppd_1');
Route::get('/rt/sm12/semak-permohonan-penubuhan-srs-ppd-2/{id}',        'RT_SM12Controller@semak_permohonan_penubuhan_srs_ppd_2')->name('rt-sm12.semak_permohonan_penubuhan_srs_ppd_2');
Route::get('get_profile_srs_peta_kawasan_table/{id}',                   'RT_SM12Controller@get_profile_srs_peta_kawasan_table')->name('rt-sm12.get_profile_srs_peta_kawasan_table');
Route::post('/rt/sm12/add_profile_srs_peta_kawasan',                    'RT_SM12Controller@add_profile_srs_peta_kawasan')->name('rt-sm12.add_profile_srs_peta_kawasan');
Route::get('get_data_srs_peta_kawasan/{id}',                            'RT_SM12Controller@get_data_srs_peta_kawasan')->name('rt-sm12.get_data_srs_peta_kawasan');
Route::get('delete_profile_srs_peta_kawasan/{id}',                      'RT_SM12Controller@delete_profile_srs_peta_kawasan')->name('rt-sm12.delete_profile_srs_peta_kawasan');
Route::post('post_semak_permohonan_penubuhan_srs',                      'RT_SM12Controller@post_semak_permohonan_penubuhan_srs')->name('rt-sm12.post_semak_permohonan_penubuhan_srs');

Route::get('/rt/sm12/jana-surat-terima-permohonan-srs',                    'RT_SM12Controller@jana_surat_terima_permohonan_srs')->name('rt-sm12.jana_surat_terima_permohonan_srs');
Route::get('/rt/sm12/surat-terima-penubuhan-srs-ppd',                    'RT_SM12Controller@surat_terima_penubuhan_srs_ppd')->name('rt-sm12.surat_terima_penubuhan_srs_ppd');
Route::get('/rt/sm12/surat-terima-penubuhan-srs-ppd-1',                    'RT_SM12Controller@surat_terima_penubuhan_srs_ppd_1')->name('rt-sm12.surat_terima_penubuhan_srs_ppd_1');
Route::get('/rt/sm12/surat-terima-penubuhan-srs-ppd-2',                    'RT_SM12Controller@surat_terima_penubuhan_srs_ppd_2')->name('rt-sm12.surat_terima_penubuhan_srs_ppd_2');

Route::get('/rt/sm12/pengesahan-permohonan-penubuhan-srs',                'RT_SM12Controller@pengesahan_permohonan_penubuhan_srs')->name('rt-sm12.pengesahan_permohonan_penubuhan_srs');
Route::get('/rt/sm12/pengesahan-permohonan-penubuhan-srs-ppn/{id}',     'RT_SM12Controller@pengesahan_permohonan_penubuhan_srs_ppn')->name('rt-sm12.pengesahan_permohonan_penubuhan_srs_ppn');
Route::get('/rt/sm12/pengesahan-permohonan-penubuhan-srs-ppn-1/{id}',   'RT_SM12Controller@pengesahan_permohonan_penubuhan_srs_ppn_1')->name('rt-sm12.pengesahan_permohonan_penubuhan_srs_ppn_1');
Route::get('/rt/sm12/pengesahan-permohonan-penubuhan-srs-ppn-2/{id}',   'RT_SM12Controller@pengesahan_permohonan_penubuhan_srs_ppn_2')->name('rt-sm12.pengesahan_permohonan_penubuhan_srs_ppn_2');
Route::post('post_pengesahan_permohonan_penubuhan_srs',                 'RT_SM12Controller@post_pengesahan_permohonan_penubuhan_srs')->name('rt-sm12.post_pengesahan_permohonan_penubuhan_srs');
Route::get('/rt/sm12/peraku-permohonan-penubuhan-srs',                    'RT_SM12Controller@peraku_permohonan_penubuhan_srs')->name('rt-sm12.peraku_permohonan_penubuhan_srs');
Route::get('/rt/sm12/peraku-permohonan-penubuhan-srs-hq/{id}',            'RT_SM12Controller@peraku_permohonan_penubuhan_srs_hq')->name('rt-sm12.peraku_permohonan_penubuhan_srs_hq');
Route::get('/rt/sm12/peraku-permohonan-penubuhan-srs-hq-1/{id}',        'RT_SM12Controller@peraku_permohonan_penubuhan_srs_hq_1')->name('rt-sm12.peraku_permohonan_penubuhan_srs_hq_1');
Route::get('/rt/sm12/peraku-permohonan-penubuhan-srs-hq-2/{id}',        'RT_SM12Controller@peraku_permohonan_penubuhan_srs_hq_2')->name('rt-sm12.peraku_permohonan_penubuhan_srs_hq_2');
Route::post('post_peraku_permohonan_penubuhan_srs',                     'RT_SM12Controller@post_peraku_permohonan_penubuhan_srs')->name('rt-sm12.post_peraku_permohonan_penubuhan_srs');
Route::get('/rt/sm12/kelulusan-permohonan-penubuhan-srs',                'RT_SM12Controller@kelulusan_permohonan_penubuhan_srs')->name('rt-sm12.kelulusan_permohonan_penubuhan_srs');
Route::get('/rt/sm12/kelulusan-permohonan-penubuhan-srs-hq/{id}',        'RT_SM12Controller@kelulusan_permohonan_penubuhan_srs_hq')->name('rt-sm12.kelulusan_permohonan_penubuhan_srs_hq');
Route::get('/rt/sm12/kelulusan-permohonan-penubuhan-srs-hq-1/{id}',        'RT_SM12Controller@kelulusan_permohonan_penubuhan_srs_hq_1')->name('rt-sm12.kelulusan_permohonan_penubuhan_srs_hq_1');
Route::get('/rt/sm12/kelulusan-permohonan-penubuhan-srs-hq-2/{id}',        'RT_SM12Controller@kelulusan_permohonan_penubuhan_srs_hq_2')->name('rt-sm12.kelulusan_permohonan_penubuhan_srs_hq_2');
Route::post('post_kelulusan_permohonan_penubuhan_srs',                  'RT_SM12Controller@post_kelulusan_permohonan_penubuhan_srs')->name('rt-sm12.post_kelulusan_permohonan_penubuhan_srs');



/* Modul e-RT - Sub Modul 13 : Pendaftaran Ahli Peronda SRS */
Route::get('/rt/sm13', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm13/senarai-pendaftaran-ahli-peronda-srs',                'RT_SM13Controller@senarai_pendaftaran_ahli_peronda_srs')->name('rt-sm13.senarai_pendaftaran_ahli_peronda_srs');
Route::post('post_daftar_ahli_peronda_srs',                             'RT_SM13Controller@post_daftar_ahli_peronda_srs')->name('rt-sm13.post_daftar_ahli_peronda_srs');
Route::get('/rt/sm13/pendaftaran-ahli-peronda-srs/{id}',                'RT_SM13Controller@pendaftaran_ahli_peronda_srs')->name('rt-sm13.pendaftaran_ahli_peronda_srs');
Route::post('post_add_gambar_peronda_srs',                              'RT_SM13Controller@post_add_gambar_peronda_srs')->name('post_add_gambar_peronda_srs');
Route::get('get_senarai_pendidikan_table/{id}',                         'RT_SM13Controller@get_senarai_pendidikan_table')->name('rt-sm13.get_senarai_pendidikan_table');
Route::post('add_pendidikan',                                           'RT_SM13Controller@add_pendidikan')->name('rt-sm13.add_pendidikan');
Route::post('delete_pendidikan',                                        'RT_SM13Controller@delete_pendidikan')->name('rt-sm13.delete_pendidikan');
Route::post('post_pendaftaran_ahli_peronda_srs',                        'RT_SM13Controller@post_pendaftaran_ahli_peronda_srs')->name('rt-sm13.post_pendaftaran_ahli_peronda_srs');
Route::get('/rt/sm13/pendaftaran-ahli-peronda-srs-1/{id}',                'RT_SM13Controller@pendaftaran_ahli_peronda_srs_1')->name('rt-sm13.pendaftaran_ahli_peronda_srs_1');
Route::get('get_senarai_pekerjaan_table/{id}',                          'RT_SM13Controller@get_senarai_pekerjaan_table')->name('rt-sm13.get_senarai_pekerjaan_table');
Route::post('add_pekerjaan',                                            'RT_SM13Controller@add_pekerjaan')->name('rt-sm13.add_pekerjaan');
Route::post('delete_pekerjaan',                                         'RT_SM13Controller@delete_pekerjaan')->name('rt-sm13.delete_pekerjaan');
Route::post('post_pendaftaran_ahli_peronda_srs_1',                      'RT_SM13Controller@post_pendaftaran_ahli_peronda_srs_1')->name('rt-sm13.post_pendaftaran_ahli_peronda_srs_1');
Route::get('/rt/sm13/semak-pendaftaran-ahli-peronda-srs-ppd',           'RT_SM13Controller@semak_pendaftaran_ahli_peronda_srs_ppd')->name('rt-sm13.semak_pendaftaran_ahli_peronda_srs_ppd');
Route::get('/rt/sm13/semak-pendaftaran-ahli-peronda-srs-ppd-1/{id}',    'RT_SM13Controller@semak_pendaftaran_ahli_peronda_srs_ppd_1')->name('rt-sm13.semak_pendaftaran_ahli_peronda_srs_ppd_1');
Route::get('/rt/sm13/semak-pendaftaran-ahli-peronda-srs-ppd-2/{id}',    'RT_SM13Controller@semak_pendaftaran_ahli_peronda_srs_ppd_2')->name('rt-sm13.semak_pendaftaran_ahli_peronda_srs_ppd_2');
Route::post('post_semak_pendaftaran_ahli_peronda',                      'RT_SM13Controller@post_semak_pendaftaran_ahli_peronda')->name('rt-sm13.post_semak_pendaftaran_ahli_peronda');
Route::get('/rt/sm13/senarai-ahli-peronda-srs',                            'RT_SM13Controller@senarai_ahli_peronda_srs')->name('rt-sm13.senarai_ahli_peronda_srs');
Route::get('/rt/sm13/ahli-peronda-srs/{id}',                            'RT_SM13Controller@ahli_peronda_srs')->name('rt-sm13.ahli_peronda_srs');
Route::post('post_edit_gambar_peronda_srs',                             'RT_SM13Controller@post_edit_gambar_peronda_srs')->name('post_edit_gambar_peronda_srs');
Route::get('get_senarai_pendidikan_srs_table/{id}',                     'RT_SM13Controller@get_senarai_pendidikan_srs_table')->name('rt-sm13.get_senarai_pendidikan_srs_table');
Route::post('add_pendidikan_srs',                                       'RT_SM13Controller@add_pendidikan_srs')->name('rt-sm13.add_pendidikan_srs');
Route::get('delete_pendidikan_srs/{id}',                                'RT_SM13Controller@delete_pendidikan_srs')->name('rt-sm13.delete_pendidikan_srs');
Route::post('post_ahli_peronda_srs',                                    'RT_SM13Controller@post_ahli_peronda_srs')->name('rt-sm13.post_ahli_peronda_srs');
Route::get('/rt/sm13/ahli-peronda-srs-1/{id}',                            'RT_SM13Controller@ahli_peronda_srs_1')->name('rt-sm13.ahli_peronda_srs_1');
Route::get('get_senarai_pekerjaan_srs_table/{id}',                      'RT_SM13Controller@get_senarai_pekerjaan_srs_table')->name('rt-sm13.get_senarai_pekerjaan_srs_table');
Route::post('add_pekerjaan_srs',                                        'RT_SM13Controller@add_pekerjaan_srs')->name('rt-sm13.add_pekerjaan_srs');
Route::get('delete_pekerjaan_srs/{id}',                                 'RT_SM13Controller@delete_pekerjaan_srs')->name('rt-sm13.delete_pekerjaan_srs');
Route::post('post_ahli_peronda_srs_1',                                  'RT_SM13Controller@post_ahli_peronda_srs_1')->name('rt-sm13.post_ahli_peronda_srs_1');
Route::get('/rt/sm13/senarai-ahli-peronda-srs-ppd',                     'RT_SM13Controller@senarai_ahli_peronda_srs_ppd')->name('rt-sm13.senarai_ahli_peronda_srs_ppd');
Route::get('/rt/sm13/senarai-ahli-peronda-srs-ppd-1/{id}',              'RT_SM13Controller@senarai_ahli_peronda_srs_ppd_1')->name('rt-sm13.senarai_ahli_peronda_srs_ppd_1');
Route::get('/rt/sm13/senarai-ahli-peronda-srs-ppd-2/{id}',              'RT_SM13Controller@senarai_ahli_peronda_srs_ppd_2')->name('rt-sm13.senarai_ahli_peronda_srs_ppd_2');
Route::get('/rt/sm13/senarai-ahli-peronda-srs-ppn',                     'RT_SM13Controller@senarai_ahli_peronda_srs_ppn')->name('rt-sm13.senarai_ahli_peronda_srs_ppn');
Route::get('/rt/sm13/senarai-ahli-peronda-srs-ppn-1/{id}',              'RT_SM13Controller@senarai_ahli_peronda_srs_ppn_1')->name('rt-sm13.senarai_ahli_peronda_srs_ppn_1');
Route::get('/rt/sm13/senarai-ahli-peronda-srs-ppn-2/{id}',              'RT_SM13Controller@senarai_ahli_peronda_srs_ppn_2')->name('rt-sm13.senarai_ahli_peronda_srs_ppn_2');
Route::get('/rt/sm13/senarai-ahli-peronda-srs-hq',                      'RT_SM13Controller@senarai_ahli_peronda_srs_hq')->name('rt-sm13.senarai_ahli_peronda_srs_hq');
Route::get('/rt/sm13/senarai-ahli-peronda-srs-hq-1/{id}',               'RT_SM13Controller@senarai_ahli_peronda_srs_hq_1')->name('rt-sm13.senarai_ahli_peronda_srs_hq_1');
Route::get('/rt/sm13/senarai-ahli-peronda-srs-hq-2/{id}',               'RT_SM13Controller@senarai_ahli_peronda_srs_hq_2')->name('rt-sm13.senarai_ahli_peronda_srs_hq_2');
Route::get('/rt/sm13/kad-keahlian-hqsrs',                               'RT_SM13Controller@kad_keahlian_hqsrs')->name('rt-sm13.kad_keahlian_hqsrs');

Route::get('/rt/sm13/semak-pendaftaran-ahli-peronda-srs',                'RT_SM13Controller@semak_pendaftaran_ahli_peronda_srs')->name('rt-sm13.semak_pendaftaran_ahli_peronda_srs');
Route::get('/rt/sm13/semak-pendaftaran-ahli-peronda-srs-1',                'RT_SM13Controller@semak_pendaftaran_ahli_peronda_srs_1')->name('rt-sm13.semak_pendaftaran_ahli_peronda_srs_1');
Route::get('/rt/sm13/semak-pendaftaran-ahli-peronda-srs-2',                'RT_SM13Controller@semak_pendaftaran_ahli_peronda_srs_2')->name('rt-sm13.semak_pendaftaran_ahli_peronda_srs_2');
Route::get('/rt/sm13/semak-pendaftaran-ahli-peronda-srs-3',                'RT_SM13Controller@semak_pendaftaran_ahli_peronda_srs_3')->name('rt-sm13.semak_pendaftaran_ahli_peronda_srs_3');
Route::get('/rt/sm13/kad-keahlian-srs',                                    'RT_SM13Controller@kad_keahlian_srs')->name('rt-sm13.kad_keahlian_srs');

/* Modul e-RT - Sub Modul 14 : Pemakluman Operasi Rondaan SRS */
Route::get('/rt/sm14', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm14/pemakluman-ops-rondaan-srs',                        'RT_SM14Controller@pemakluman_ops_rondaan_srs')->name('rt-sm14.pemakluman_ops_rondaan_srs');
Route::post('add_pemakluman_ops_rondaan',                               'RT_SM14Controller@add_pemakluman_ops_rondaan')->name('rt-sm14.add_pemakluman_ops_rondaan');
Route::get('get_view_pemakluman_ops_rondaan_srs/{id}',                  'RT_SM14Controller@get_view_pemakluman_ops_rondaan_srs')->name('rt-sm14.get_view_pemakluman_ops_rondaan_srs');
Route::get('delete_pemakluman_ops_rondaan/{id}',                        'RT_SM14Controller@delete_pemakluman_ops_rondaan')->name('rt-sm14.delete_pemakluman_ops_rondaan');
Route::get('/rt/sm14/paparan-pemakluman-ops-rondaan-p',                    'RT_SM14Controller@paparan_pemakluman_ops_rondaan_p')->name('rt-sm14.paparan_pemakluman_ops_rondaan_p');
Route::get('/rt/sm14/surat-pemakluman-operasi-rondaan-p/{id}',          'RT_SM14Controller@surat_pemakluman_operasi_rondaan_p')->name('rt-sm14.surat_pemakluman_operasi_rondaan_p');
// Route::get('/rt/sm14/surat-pemakluman-operasi-rondaan-p/{id}',          'RT_SM14Controller@surat_pemakluman_operasi_rondaan_p')->name('rt-sm14.surat_pemakluman_operasi_rondaan_p');
Route::get('/rt/sm14/paparan-pemakluman-ops-rondaan-ppd',                'RT_SM14Controller@paparan_pemakluman_ops_rondaan_ppd')->name('rt-sm14.paparan_pemakluman_ops_rondaan_ppd');
Route::get('/rt/sm14/surat-pemakluman-operasi-rondaan-ppd/{id}',        'RT_SM14Controller@surat_pemakluman_operasi_rondaan_ppd')->name('rt-sm14.surat_pemakluman_operasi_rondaan_ppd');
Route::get('/rt/sm14/paparan-pemakluman-ops-rondaan-ppn',                'RT_SM14Controller@paparan_pemakluman_ops_rondaan_ppn')->name('rt-sm14.paparan_pemakluman_ops_rondaan_ppn');
Route::get('/rt/sm14/surat-pemakluman-operasi-rondaan-ppn/{id}',        'RT_SM14Controller@surat_pemakluman_operasi_rondaan_ppn')->name('rt-sm14.surat_pemakluman_operasi_rondaan_ppn');

Route::get('/rt/sm14/pemakluman-operasi-rondaan',                        'RT_SM14Controller@pemakluman_operasi_rondaan')->name('rt-sm14.pemakluman_operasi_rondaan');
Route::get('/rt/sm14/surat-pemakluman-operasi-rondaan',                    'RT_SM14Controller@surat_pemakluman_operasi_rondaan')->name('rt-sm14.surat_pemakluman_operasi_rondaan');
Route::get('/rt/sm14/paparan-pemakluman-operasi-rondaan',                'RT_SM14Controller@paparan_pemakluman_operasi_rondaan')->name('rt-sm14.paparan_pemakluman_operasi_rondaan');

/* Modul e-RT - Sub Modul 15 : Perancangan Aktivti Rondaan SRS */
Route::get('/rt/sm15', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm15/penyediaan-perancangan-rondaan-srs',                'RT_SM15Controller@penyediaan_perancangan_rondaan_srs')->name('rt-sm15.penyediaan_perancangan_rondaan_srs');
Route::post('post_tambah_perancangan_rondaan',                          'RT_SM15Controller@post_tambah_perancangan_rondaan')->name('rt-sm15.post_tambah_perancangan_rondaan');
Route::get('/rt/sm15/penyediaan-perancangan-rondaan-srs-1/{id}',        'RT_SM15Controller@penyediaan_perancangan_rondaan_srs_1')->name('rt-sm15.penyediaan_perancangan_rondaan_srs_1');
Route::get('get_senarai_ahli/{id}',                                     'RT_SM15Controller@get_senarai_ahli')->name('rt-sm15.get_senarai_ahli');
Route::post('add_perancangan_rondaan_ahli',                             'RT_SM15Controller@add_perancangan_rondaan_ahli')->name('rt-sm15.add_perancangan_rondaan_ahli');
Route::get('delete__perancangan_rondaan_ahli/{id}',                     'RT_SM15Controller@delete__perancangan_rondaan_ahli')->name('rt-sm15.delete__perancangan_rondaan_ahli');
Route::post('post_tambah_perancangan_rondaan_1',                        'RT_SM15Controller@post_tambah_perancangan_rondaan_1')->name('rt-sm15.post_tambah_perancangan_rondaan_1');
Route::get('/rt/sm15/jana-jadual-rondaan-k',                            'RT_SM15Controller@jana_jadual_rondaan_k')->name('rt-sm15.jana_jadual_rondaan_k');
Route::get('/rt/sm15/jana-jadual-rondaan-ppd',                            'RT_SM15Controller@jana_jadual_rondaan_ppd')->name('rt-sm15.jana_jadual_rondaan_ppd');
Route::get('/rt/sm15/jana-jadual-rondaan-ppn',                            'RT_SM15Controller@jana_jadual_rondaan_ppn')->name('rt-sm15.jana_jadual_rondaan_ppn');
Route::get('/rt/sm15/laporan-perancangan-rondaan-ppd',                    'RT_SM15Controller@laporan_perancangan_rondaan_ppd')->name('rt-sm15.laporan_perancangan_rondaan_ppd');
Route::get('/rt/sm15/laporan-perancangan-rondaan-ppn',                    'RT_SM15Controller@laporan_perancangan_rondaan_ppn')->name('rt-sm15.laporan_perancangan_rondaan_ppn');

Route::get('/rt/sm15/penyediaan-perancangan-rondaan',                    'RT_SM15Controller@penyediaan_perancangan_rondaan')->name('rt-sm15.penyediaan_perancangan_rondaan');
Route::get('/rt/sm15/jana-jadual-rondaan-srs',                            'RT_SM15Controller@jana_jadual_rondaan_srs')->name('rt-sm15.jana_jadual_rondaan_srs');
Route::get('/rt/sm15/pengesahan-rondaan-srs',                            'RT_SM15Controller@pengesahan_rondaan_srs')->name('rt-sm15.pengesahan_rondaan_srs');
Route::get('/rt/sm15/ringkasan-laporan-perancangan-rondaan',            'RT_SM15Controller@ringkasan_laporan_perancangan_rondaan')->name('rt-sm15.ringkasan_laporan_perancangan_rondaan');
Route::get('/rt/sm15/jana-laporan-kekerapan-rondaan-d',                    'RT_SM15Controller@jana_laporan_kekerapan_rondaan_d')->name('rt-sm15.jana_laporan_kekerapan_rondaan_d');
Route::get('/rt/sm15/jana-laporan-kekerapan-rondaan-n',                    'RT_SM15Controller@jana_laporan_kekerapan_rondaan_n')->name('rt-sm15.jana_laporan_kekerapan_rondaan_n');
Route::get('/rt/sm15/jana-laporan-kekerapan-rondaan-all',                'RT_SM15Controller@jana_laporan_kekerapan_rondaan_all')->name('rt-sm15.jana_laporan_kekerapan_rondaan_all');

/* Modul e-RT - Sub Modul 16 : Pelaksanaan Aktivti Rondaan SRS */
Route::get('/rt/sm16', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm16/penyediaan-pelaksanaan-rondaan-srs',                'RT_SM16Controller@penyediaan_pelaksanaan_rondaan_srs')->name('rt-sm16.penyediaan_pelaksanaan_rondaan_srs');
Route::post('post_tambah_pelaksanaan_rondaan',                          'RT_SM16Controller@post_tambah_pelaksanaan_rondaan')->name('rt-sm16.post_tambah_pelaksanaan_rondaan');
Route::get('/rt/sm16/penyediaan-pelaksanaan-rondaan-srs-1/{id}',        'RT_SM16Controller@penyediaan_pelaksanaan_rondaan_srs_1')->name('rt-sm16.penyediaan_pelaksanaan_rondaan_srs_1');
Route::get('get_senarai_ahli_table/{id}',                               'RT_SM16Controller@get_senarai_ahli_table')->name('rt-sm16.get_senarai_ahli_table');
Route::post('add_pelaksanaan_rondaan_ahli',                             'RT_SM16Controller@add_pelaksanaan_rondaan_ahli')->name('rt-sm16.add_pelaksanaan_rondaan_ahli');
Route::get('delete__pelaksanaan_rondaan_ahli/{id}',                     'RT_SM16Controller@delete__pelaksanaan_rondaan_ahli')->name('rt-sm16.delete__pelaksanaan_rondaan_ahli');
Route::post('post_tambah_pelaksanaan_rondaan_1',                        'RT_SM16Controller@post_tambah_pelaksanaan_rondaan_1')->name('rt-sm16.post_tambah_pelaksanaan_rondaan_1');
Route::post('post_tambah_pelaksanaan_rondaan_2',                        'RT_SM16Controller@post_tambah_pelaksanaan_rondaan_2')->name('rt-sm16.post_tambah_pelaksanaan_rondaan_2');
Route::get('/rt/sm16/penyediaan-pelaksanaan-rondaan-srs-2/{id}',        'RT_SM16Controller@penyediaan_pelaksanaan_rondaan_srs_2')->name('rt-sm16.penyediaan_pelaksanaan_rondaan_srs_2');
Route::get('get_kaum_terlibat_table/{id}',                              'RT_SM16Controller@get_kaum_terlibat_table')->name('rt-sm16.get_kaum_terlibat_table');
Route::post('post_add_kaum_terlibat',                                   'RT_SM16Controller@post_add_kaum_terlibat')->name('rt-sm16.post_add_kaum_terlibat');
Route::get('delete_kaum_terlibat/{id}',                                 'RT_SM16Controller@delete_kaum_terlibat')->name('rt-sm16.delete_kaum_terlibat');
Route::post('post_tambah_pelaksanaan_rondaan_3',                        'RT_SM16Controller@post_tambah_pelaksanaan_rondaan_3')->name('rt-sm16.post_tambah_pelaksanaan_rondaan_3');
Route::get('/rt/sm16/pengesahan-pelaksanaan-rondaan-srs',                'RT_SM16Controller@pengesahan_pelaksanaan_rondaan_srs')->name('rt-sm16.pengesahan_pelaksanaan_rondaan_srs');
Route::get('/rt/sm16/pengesahan-pelaksanaan-rondaan-srs-1/{id}',        'RT_SM16Controller@pengesahan_pelaksanaan_rondaan_srs_1')->name('rt-sm16.pengesahan_pelaksanaan_rondaan_srs_1');
Route::get('get_senarai_ahli_ppd_table/{id}',                           'RT_SM16Controller@get_senarai_ahli_ppd_table')->name('rt-sm16.get_senarai_ahli_ppd_table');
Route::post('post_pengesahan_pelaksanaan_rondaan_srs',                  'RT_SM16Controller@post_pengesahan_pelaksanaan_rondaan_srs')->name('rt-sm16.post_pengesahan_pelaksanaan_rondaan_srs');
Route::get('/rt/sm16/pengesahan-pelaksanaan-rondaan-srs-2/{id}',        'RT_SM16Controller@pengesahan_pelaksanaan_rondaan_srs_2')->name('rt-sm16.pengesahan_pelaksanaan_rondaan_srs_2');
Route::post('post_pengesahan_pelaksanaan_rondaan_srs_2',                'RT_SM16Controller@post_pengesahan_pelaksanaan_rondaan_srs_2')->name('rt-sm16.post_pengesahan_pelaksanaan_rondaan_srs_2');
Route::get('/rt/sm16/laporan-pelaksanaan-rondaan-ppd',                    'RT_SM16Controller@laporan_pelaksanaan_rondaan_ppd')->name('rt-sm16.laporan_pelaksanaan_rondaan_ppd');
Route::get('/rt/sm16/laporan-pelaksanaan-rondaan-ppn',                    'RT_SM16Controller@laporan_pelaksanaan_rondaan_ppn')->name('rt-sm16.laporan_pelaksanaan_rondaan_ppn');

Route::get('/rt/sm16/penyediaan-pelaksanaan-rondaan',                    'RT_SM16Controller@penyediaan_pelaksanaan_rondaan')->name('rt-sm16.penyediaan_pelaksanaan_rondaan');
Route::get('/rt/sm16/laporan-kekerapan-pelaksanaan-rondaan',            'RT_SM16Controller@laporan_kekerapan_pelaksanaan_rondaan')->name('rt-sm16.laporan_kekerapan_pelaksanaan_rondaan');
Route::get('/rt/sm16/laporan-rondaan-srs',                                'RT_SM16Controller@laporan_rondaan_srs')->name('rt-sm16.laporan_rondaan_srs');
Route::get('/rt/sm16/laporan-kekerapan-pelaksanaan-rondaan-d',            'RT_SM16Controller@laporan_kekerapan_pelaksanaan_rondaan_d')->name('rt-sm16.laporan_kekerapan_pelaksanaan_rondaan_d');
Route::get('/rt/sm16/laporan-kekerapan-pelaksanaan-rondaan-n',            'RT_SM16Controller@laporan_kekerapan_pelaksanaan_rondaan_n')->name('rt-sm16.laporan_kekerapan_pelaksanaan_rondaan_n');
Route::get('/rt/sm16/laporan-kekerapan-pelaksanaan-rondaan-all',        'RT_SM16Controller@laporan_kekerapan_pelaksanaan_rondaan_all')->name('rt-sm16.laporan_kekerapan_pelaksanaan_rondaan_all');

/* Modul e-RT - Sub Modul 17 : Pengendalian Kes SRS */
Route::get('/rt/sm17', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm17/penyediaan-pengedalian-kes-srs',                    'RT_SM17Controller@penyediaan_pengedalian_kes_srs')->name('rt-sm17.penyediaan_pengedalian_kes_srs');
Route::get('/rt/sm17/borang-pengedali-kes-k',                            'RT_SM17Controller@borang_pengedali_kes_k')->name('rt-sm17.borang_pengedali_kes_k');
Route::get('/rt/sm17/jana-laporan-pengendalian-kes-srs',                'RT_SM17Controller@jana_laporan_pengendalian_kes_srs')->name('rt-sm17.jana_laporan_pengendalian_kes_srs');
Route::get('/rt/sm17/jana-laporan-pengendalian-kes-srs-d',                'RT_SM17Controller@jana_laporan_pengendalian_kes_srs_d')->name('rt-sm17.jana_laporan_pengendalian_kes_srs_d');
Route::get('/rt/sm17/jana-laporan-pengendalian-kes-srs-n',                'RT_SM17Controller@jana_laporan_pengendalian_kes_srs_n')->name('rt-sm17.jana_laporan_pengendalian_kes_srs_n');
Route::get('/rt/sm17/jana-laporan-pengendalian-kes-srs-all',            'RT_SM17Controller@jana_laporan_pengendalian_kes_srs_all')->name('rt-sm17.jana_laporan_pengendalian_kes_srs_all');
Route::get('/rt/sm17/print-borang-masa-rehat',                            'RT_SM17Controller@print_borang_masa_rehat')->name('rt-sm17.print_borang_masa_rehat');

/* Modul e-RT - Sub Modul 18 : Penarikan Diri Ahli SRS */
Route::get('/rt/sm18', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm18/permohonan-penarikan-diri-ahli-srs',                'RT_SM18Controller@permohonan_penarikan_diri_ahli_srs')->name('rt-sm18.permohonan_penarikan_diri_ahli_srs');
Route::get('get_ahli_peronda/{id}',                                     'RT_SM18Controller@get_ahli_peronda')->name('rt-sm18.get_ahli_peronda');
Route::post('add_penarikan_diri_srs',                                   'RT_SM18Controller@add_penarikan_diri_srs')->name('rt-sm18.add_penarikan_diri_srs');
Route::get('get_view_permohonan_penarikan_diri/{id}',                   'RT_SM18Controller@get_view_permohonan_penarikan_diri')->name('rt-sm18.get_view_permohonan_penarikan_diri');
Route::get('/rt/sm18/pengesahan-penarikan-diri-ahli-srs',                'RT_SM18Controller@pengesahan_penarikan_diri_ahli_srs')->name('rt-sm18.pengesahan_penarikan_diri_ahli_srs');
Route::post('post_sahkan_penarikan_diri_srs',                           'RT_SM18Controller@post_sahkan_penarikan_diri_srs')->name('rt-sm18.post_sahkan_penarikan_diri_srs');

Route::get('/rt/sm18/permohonan-penarikan-diri-srs',                    'RT_SM18Controller@permohonan_penarikan_diri_srs')->name('rt-sm18.permohonan_penarikan_diri_srs');
Route::get('/rt/sm18/pengesahan-penarikan-diri-srs',                    'RT_SM18Controller@pengesahan_penarikan_diri_srs')->name('rt-sm18.pengesahan_penarikan_diri_srs');
Route::get('/rt/sm18/kemaskini-aktif-maklumat-peronda',                    'RT_SM18Controller@kemaskini_aktif_maklumat_peronda')->name('rt-sm18.kemaskini_aktif_maklumat_peronda');

/* Modul e-RT - Sub Modul 19 : Pembatalan SRS */
Route::get('/rt/sm19', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm19/permohonan-pembatalan-srs-p',                        'RT_SM19Controller@permohonan_pembatalan_srs_p')->name('rt-sm19.permohonan_pembatalan_srs_p');
Route::post('post_create_permohonan_pembatalan_srs',                    'RT_SM19Controller@post_create_permohonan_pembatalan_srs')->name('rt-sm19.post_create_permohonan_pembatalan_srs');
Route::get('/rt/sm19/permohonan-pembatalan-srs-p-1/{id}',                'RT_SM19Controller@permohonan_pembatalan_srs_p_1')->name('rt-sm19.permohonan_pembatalan_srs_p_1');
Route::get('get_senarai_minit_meeting_pembatalan_table/{id}',           'RT_SM19Controller@get_senarai_minit_meeting_pembatalan_table')->name('rt-sm19.get_senarai_minit_meeting_pembatalan_table');
Route::post('post_minit_meeting_pembatalan_srs',                        'RT_SM19Controller@post_minit_meeting_pembatalan_srs')->name('rt-sm19.post_minit_meeting_pembatalan_srs');
Route::get('delete_senarai_minit_meeting_pembatalan/{id}',              'RT_SM19Controller@delete_senarai_minit_meeting_pembatalan')->name('rt-sm19.delete_senarai_minit_meeting_pembatalan');
Route::post('post_create_permohonan_pembatalan_srs_1',                  'RT_SM19Controller@post_create_permohonan_pembatalan_srs_1')->name('rt-sm19.post_create_permohonan_pembatalan_srs_1');
Route::get('/rt/sm19/semakan-pembatalan-srs-ppd',                        'RT_SM19Controller@semakan_pembatalan_srs_ppd')->name('rt-sm19.semakan_pembatalan_srs_ppd');
Route::get('/rt/sm19/semakan-pembatalan-srs-ppd-1/{id}',                'RT_SM19Controller@semakan_pembatalan_srs_ppd_1')->name('rt-sm19.semakan_pembatalan_srs_ppd_1');
Route::post('post_semakan_pembatalan_srs',                              'RT_SM19Controller@post_semakan_pembatalan_srs')->name('rt-sm19.post_semakan_pembatalan_srs');
Route::get('/rt/sm19/pengesahan-pembatalan-srs-ppn',                    'RT_SM19Controller@pengesahan_pembatalan_srs_ppn')->name('rt-sm19.pengesahan_pembatalan_srs_ppn');
Route::get('/rt/sm19/pengesahan-pembatalan-srs-ppn-1/{id}',                'RT_SM19Controller@pengesahan_pembatalan_srs_ppn_1')->name('rt-sm19.pengesahan_pembatalan_srs_ppn_1');
Route::post('post_pengesahan_pembatalan_srs',                           'RT_SM19Controller@post_pengesahan_pembatalan_srs')->name('rt-sm19.post_pengesahan_pembatalan_srs');
Route::get('/rt/sm19/kelulusan-pembatalan-srs-hq',                        'RT_SM19Controller@kelulusan_pembatalan_srs_hq')->name('rt-sm19.kelulusan_pembatalan_srs_hq');
Route::get('/rt/sm19/kelulusan-pembatalan-srs-hq-1/{id}',                'RT_SM19Controller@kelulusan_pembatalan_srs_hq_1')->name('rt-sm19.kelulusan_pembatalan_srs_hq_1');
Route::post('post_kelulusan_pembatalan_srs',                            'RT_SM19Controller@post_kelulusan_pembatalan_srs')->name('rt-sm19.post_kelulusan_pembatalan_srs');
Route::get('/rt/sm19/notis-pembatalan-srs-hq',                            'RT_SM19Controller@notis_pembatalan_srs_hq')->name('rt-sm19.notis_pembatalan_srs_hq');

Route::get('/rt/sm19/permohonan-pembatalan-srs',                        'RT_SM19Controller@permohonan_pembatalan_srs')->name('rt-sm19.permohonan_pembatalan_srs');
Route::get('/rt/sm19/borang-pembatalan-srs',                            'RT_SM19Controller@borang_pembatalan_srs')->name('rt-sm19.borang_pembatalan_srs');
Route::get('/rt/sm19/semakan-permohonan-pembatalan-srs',                'RT_SM19Controller@semakan_permohonan_pembatalan_srs')->name('rt-sm19.semakan_permohonan_pembatalan_srs');
Route::get('/rt/sm19/semakan-borang-pembatalan-srs-ppd',                'RT_SM19Controller@semakan_borang_pembatalan_srs_ppd')->name('rt-sm19.semakan_borang_pembatalan_srs_ppd');
Route::get('/rt/sm19/pengesahan-permohonan-pembatalan-srs',                'RT_SM19Controller@pengesahan_permohonan_pembatalan_srs')->name('rt-sm19.pengesahan_permohonan_pembatalan_srs');
Route::get('/rt/sm19/pengesahan-borang-pembatalan-srs-hq',                'RT_SM19Controller@pengesahan_borang_pembatalan_srs_hq')->name('rt-sm19.pengesahan_borang_pembatalan_srs_hq');
Route::get('/rt/sm19/jana-notis-pembatalan-srs',                        'RT_SM19Controller@jana_notis_pembatalan_srs')->name('rt-sm19.jana_notis_pembatalan_srs');
Route::get('/rt/sm19/surat-notis-pembatalan-srs',                        'RT_SM19Controller@surat_notis_pembatalan_srs')->name('rt-sm19.surat_notis_pembatalan_srs');

/* Modul e-RT - Sub Modul 20 : Laporan SRS */
Route::get('/rt/sm20', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm20/laporan-senarai-srs',                                'RT_SM20Controller@laporan_senarai_srs')->name('rt-sm20.laporan_senarai_srs');
Route::get('/rt/sm20/laporan-pembatalan-srs',                            'RT_SM20Controller@laporan_pembatalan_srs')->name('rt-sm20.laporan_pembatalan_srs');
Route::get('/rt/sm20/laporan-senarai-peronda-srs',                        'RT_SM20Controller@laporan_senarai_peronda_srs')->name('rt-sm20.laporan_senarai_peronda_srs');
Route::get('/rt/sm20/laporan-ringkasan-jumlah-peronda-srs',                'RT_SM20Controller@laporan_ringkasan_jumlah_peronda_srs')->name('rt-sm20.laporan_ringkasan_jumlah_peronda_srs');

/* Modul e-Sepakat - Modul 21 : i-Kes */
Route::get('/rt/sm21', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm21/senarai-permohonan-ikes',                            'RT_SM21Controller@senarai_permohonan_ikes')->name('rt-sm21.senarai_permohonan_ikes');
Route::get('/rt/sm21/paparan-pelaporan-ikes/{id}',                        'RT_SM21Controller@paparan_pelaporan_ikes')->name('rt-sm21.paparan_pelaporan_ikes');
Route::get('/rt/sm21/paparan-pelaporan-ikes-1/{id}',                    'RT_SM21Controller@paparan_pelaporan_ikes_1')->name('rt-sm21.paparan_pelaporan_ikes_1');
Route::get('/rt/sm21/paparan-pelaporan-ikes-2/{id}',                    'RT_SM21Controller@paparan_pelaporan_ikes_2')->name('rt-sm21.paparan_pelaporan_ikes_2');
Route::get('/rt/sm21/paparan-pelaporan-ikes-3/{id}',                    'RT_SM21Controller@paparan_pelaporan_ikes_3')->name('rt-sm21.paparan_pelaporan_ikes_3');
Route::post('post_permohonan_ikes',                                     'RT_SM21Controller@post_permohonan_ikes')->name('rt-sm21.post_permohonan_ikes');
Route::get('/rt/sm21/permohonan-ikes/{id}',                                'RT_SM21Controller@permohonan_ikes')->name('rt-sm21.permohonan_ikes');
Route::post('post_permohonan_ikes_1',                                   'RT_SM21Controller@post_permohonan_ikes_1')->name('rt-sm21.post_permohonan_ikes_1');
Route::get('/rt/sm21/permohonan-ikes-1/{id}',                            'RT_SM21Controller@permohonan_ikes_1')->name('rt-sm21.permohonan_ikes_1');
Route::get('get_ikes_bilangan_terlibat/{id}',                           'RT_SM21Controller@get_ikes_bilangan_terlibat')->name('rt-sm21.get_ikes_bilangan_terlibat');
Route::post('add_add_bilangan_terlibat',                                'RT_SM21Controller@add_add_bilangan_terlibat')->name('rt-sm21.add_add_bilangan_terlibat');
Route::get('delete_ikes_bilangan_terlibat/{id}',                        'RT_SM21Controller@delete_ikes_bilangan_terlibat')->name('rt-sm21.delete_ikes_bilangan_terlibat');
Route::get('get_ikes_bilangan_cedera/{id}',                             'RT_SM21Controller@get_ikes_bilangan_cedera')->name('rt-sm21.get_ikes_bilangan_cedera');
Route::post('add_bilangan_cedera',                                      'RT_SM21Controller@add_bilangan_cedera')->name('rt-sm21.add_bilangan_cedera');
Route::get('delete_ikes_bilangan_cedera_ringan/{id}',                   'RT_SM21Controller@delete_ikes_bilangan_cedera_ringan')->name('rt-sm21.delete_ikes_bilangan_cedera_ringan');
Route::get('get_ikes_bilangan_cedera_parah/{id}',                       'RT_SM21Controller@get_ikes_bilangan_cedera_parah')->name('rt-sm21.get_ikes_bilangan_cedera_parah');
Route::post('add_bilangan_cedera_parah',                                'RT_SM21Controller@add_bilangan_cedera_parah')->name('rt-sm21.add_bilangan_cedera_parah');
Route::get('delete_ikes_bilangan_cedera_parah/{id}',                    'RT_SM21Controller@delete_ikes_bilangan_cedera_parah')->name('rt-sm21.delete_ikes_bilangan_cedera_parah');
Route::get('get_ikes_bilangan_kematian/{id}',                           'RT_SM21Controller@get_ikes_bilangan_kematian')->name('rt-sm21.get_ikes_bilangan_kematian');
Route::post('add_bilangan_kematian',                                    'RT_SM21Controller@add_bilangan_kematian')->name('rt-sm21.add_bilangan_kematian');
Route::get('delete_ikes_bilangan_kematian/{id}',                        'RT_SM21Controller@delete_ikes_bilangan_kematian')->name('rt-sm21.delete_ikes_bilangan_kematian');
Route::post('post_permohonan_ikes_2',                                   'RT_SM21Controller@post_permohonan_ikes_2')->name('rt-sm21.post_permohonan_ikes_2');
Route::get('/rt/sm21/permohonan-ikes-2/{id}',                            'RT_SM21Controller@permohonan_ikes_2')->name('rt-sm21.permohonan_ikes_2');
Route::get('get_bentuk_tindakan_table/{id}',                            'RT_SM21Controller@get_bentuk_tindakan_table')->name('rt-sm21.get_bentuk_tindakan_table');
Route::get('get_bentuk_tindakan_table2/{id}',                           'RT_SM21Controller@get_bentuk_tindakan_table2')->name('rt-sm21.get_bentuk_tindakan_table2');
Route::post('post_ikes_tindakan',                                       'RT_SM21Controller@post_ikes_tindakan')->name('rt-sm21.post_ikes_tindakan');
Route::post('post_delete_ikes_tindakan',                                'RT_SM21Controller@post_delete_ikes_tindakan')->name('rt-sm21.post_delete_ikes_tindakan');
//Route::get('get_bentuk_terlibat_table/{id}',                            'RT_SM21Co���ntroller@get_bentuk_terlibat_table')->name('rt-sm21.get_bentuk_terlibat_table');
Route::post('post_ikes_terlibat',                                       'RT_SM21Controller@post_ikes_terlibat')->name('rt-sm21.post_ikes_terlibat');
Route::post('post_delete_ikes_terlibat',                                'RT_SM21Controller@post_delete_ikes_terlibat')->name('rt-sm21.post_delete_ikes_terlibat');
Route::post('post_permohonan_ikes_3',                                   'RT_SM21Controller@post_permohonan_ikes_3')->name('rt-sm21.post_permohonan_ikes_3');
Route::get('/rt/sm21/permohonan-ikes-3/{id}',                            'RT_SM21Controller@permohonan_ikes_3')->name('rt-sm21.permohonan_ikes_3');
Route::get('delete_laporan_ikes/{id}',                                  'RT_SM21Controller@delete_laporan_ikes')->name('rt-sm21.delete_laporan_ikes');
Route::get('get_ikes_kedudukan/{id}',                                   'RT_SM21Controller@get_ikes_kedudukan')->name('rt-sm21.get_ikes_kedudukan');
Route::post('add_kedudukan_kes',                                        'RT_SM21Controller@add_kedudukan_kes')->name('rt-sm21.add_kedudukan_kes');
Route::get('delete_kedudukan_kes/{id}',                                 'RT_SM21Controller@delete_kedudukan_kes')->name('rt-sm21.delete_kedudukan_kes');
Route::get('get_dokument_kes_table/{id}',                               'RT_SM21Controller@get_dokument_kes_table')->name('rt-sm21.get_dokument_kes_table');
Route::post('add_spk_ikes_dokument',                                    'RT_SM21Controller@add_spk_ikes_dokument')->name('rt-sm21.add_spk_ikes_dokument');
Route::get('get_data_ikes_dokument/{id}',                               'RT_SM21Controller@get_data_ikes_dokument')->name('rt-sm21.get_data_ikes_dokument');
Route::get('delete_dokument_kes/{id}',                                  'RT_SM21Controller@delete_dokument_kes')->name('rt-sm21.delete_dokument_kes');
Route::post('post_permohonan_ikes_4_back',                              'RT_SM21Controller@post_permohonan_ikes_4_back')->name('rt-sm21.post_permohonan_ikes_4_back');
Route::post('post_permohonan_ikes_4',                                   'RT_SM21Controller@post_permohonan_ikes_4')->name('rt-sm21.post_permohonan_ikes_4');
Route::get('/rt/sm21/senarai-akuan-permohonan-ikes-ppn',                'RT_SM21Controller@senarai_akuan_permohonan_ikes_ppn')->name('rt-sm21.senarai_akuan_permohonan_ikes_ppn');
Route::get('/rt/sm21/akuan-permohonan-ikes-ppn/{id}',                    'RT_SM21Controller@akuan_permohonan_ikes_ppn')->name('rt-sm21.akuan_permohonan_ikes_ppn');
Route::get('/rt/sm21/akuan-permohonan-ikes-ppn-1/{id}',                    'RT_SM21Controller@akuan_permohonan_ikes_ppn_1')->name('rt-sm21.akuan_permohonan_ikes_ppn_1');
Route::get('/rt/sm21/akuan-permohonan-ikes-ppn-2/{id}',                    'RT_SM21Controller@akuan_permohonan_ikes_ppn_2')->name('rt-sm21.akuan_permohonan_ikes_ppn_2');
Route::get('/rt/sm21/akuan-permohonan-ikes-ppn-3/{id}',                    'RT_SM21Controller@akuan_permohonan_ikes_ppn_3')->name('rt-sm21.akuan_permohonan_ikes_ppn_3');
Route::post('post_akui_permohonan_ikes',                                'RT_SM21Controller@post_akui_permohonan_ikes')->name('rt-sm21.post_akui_permohonan_ikes');
Route::get('/rt/sm21/senarai-semakan-permohonan-ikes-bpp',                'RT_SM21Controller@senarai_semakan_permohonan_ikes_bpp')->name('rt-sm21.senarai_semakan_permohonan_ikes_bpp');
Route::get('/rt/sm21/semakan-permohonan-ikes-bpp/{id}',                    'RT_SM21Controller@semakan_permohonan_ikes_bpp')->name('rt-sm21.semakan_permohonan_ikes_bpp');
Route::get('/rt/sm21/semakan-permohonan-ikes-bpp-1/{id}',                'RT_SM21Controller@semakan_permohonan_ikes_bpp_1')->name('rt-sm21.semakan_permohonan_ikes_bpp_1');
Route::get('/rt/sm21/semakan-permohonan-ikes-bpp-2/{id}',                'RT_SM21Controller@semakan_permohonan_ikes_bpp_2')->name('rt-sm21.semakan_permohonan_ikes_bpp_2');
Route::get('/rt/sm21/semakan-permohonan-ikes-bpp-3/{id}',                'RT_SM21Controller@semakan_permohonan_ikes_bpp_3')->name('rt-sm21.semakan_permohonan_ikes_bpp_3');
Route::post('post_semakan_permohonan_ikes',                             'RT_SM21Controller@post_semakan_permohonan_ikes')->name('rt-sm21.post_semakan_permohonan_ikes');
Route::get('/rt/sm21/senarai-sahkan-permohonan-ikes-p',                    'RT_SM21Controller@senarai_sahkan_permohonan_ikes_p')->name('rt-sm21.senarai_sahkan_permohonan_ikes_p');
Route::get('/rt/sm21/sahkan-permohonan-ikes-p/{id}',                    'RT_SM21Controller@sahkan_permohonan_ikes_p')->name('rt-sm21.sahkan_permohonan_ikes_p');
Route::get('/rt/sm21/sahkan-permohonan-ikes-p-1/{id}',                    'RT_SM21Controller@sahkan_permohonan_ikes_p_1')->name('rt-sm21.sahkan_permohonan_ikes_p_1');
Route::get('/rt/sm21/sahkan-permohonan-ikes-p-2/{id}',                    'RT_SM21Controller@sahkan_permohonan_ikes_p_2')->name('rt-sm21.sahkan_permohonan_ikes_p_2');
Route::get('/rt/sm21/sahkan-permohonan-ikes-p-3/{id}',                    'RT_SM21Controller@sahkan_permohonan_ikes_p_3')->name('rt-sm21.sahkan_permohonan_ikes_p_3');
Route::post('post_pengesahan_permohonan_ikes',                          'RT_SM21Controller@post_pengesahan_permohonan_ikes')->name('rt-sm21.post_pengesahan_permohonan_ikes');
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/rt/sm21/senarai-permohonan-ikes-ppn',                        'RT_SM21Controller@senarai_permohonan_ikes_ppn')->name('rt-sm21.senarai_permohonan_ikes_ppn');
Route::post('post_permohonan_ikes_ppn',                                 'RT_SM21Controller@post_permohonan_ikes_ppn')->name('rt-sm21.post_permohonan_ikes_ppn');
Route::get('/rt/sm21/permohonan-ikes-ppn/{id}',                            'RT_SM21Controller@permohonan_ikes_ppn')->name('rt-sm21.permohonan_ikes_ppn');
Route::post('post_permohonan_ikes_ppn_1',                               'RT_SM21Controller@post_permohonan_ikes_ppn_1')->name('rt-sm21.post_permohonan_ikes_ppn_1');
Route::get('/rt/sm21/permohonan-ikes-ppn-1/{id}',                        'RT_SM21Controller@permohonan_ikes_ppn_1')->name('rt-sm21.permohonan_ikes_ppn_1');
Route::post('post_permohonan_ikes_ppn_2',                               'RT_SM21Controller@post_permohonan_ikes_ppn_2')->name('rt-sm21.post_permohonan_ikes_ppn_2');
Route::get('/rt/sm21/permohonan-ikes-ppn-2/{id}',                        'RT_SM21Controller@permohonan_ikes_ppn_2')->name('rt-sm21.permohonan_ikes_ppn_2');
Route::post('post_permohonan_ikes_ppn_3',                               'RT_SM21Controller@post_permohonan_ikes_ppn_3')->name('rt-sm21.post_permohonan_ikes_ppn_3');
Route::get('/rt/sm21/permohonan-ikes-ppn-3/{id}',                        'RT_SM21Controller@permohonan_ikes_ppn_3')->name('rt-sm21.permohonan_ikes_ppn_3');
Route::post('add_spk_ikes_dokument_ppn',                                'RT_SM21Controller@add_spk_ikes_dokument_ppn')->name('rt-sm21.add_spk_ikes_dokument_ppn');
Route::post('post_permohonan_ikes_ppn_4',                               'RT_SM21Controller@post_permohonan_ikes_ppn_4')->name('rt-sm21.post_permohonan_ikes_ppn_4');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/rt/sm21/senarai-permohonan-ikes-bpp',                        'RT_SM21Controller@senarai_permohonan_ikes_bpp')->name('rt-sm21.senarai_permohonan_ikes_bpp');
Route::post('post_permohonan_ikes_bpp',                                 'RT_SM21Controller@post_permohonan_ikes_bpp')->name('rt-sm21.post_permohonan_ikes_bpp');
Route::get('/rt/sm21/permohonan-ikes-bpp/{id}',                            'RT_SM21Controller@permohonan_ikes_bpp')->name('rt-sm21.permohonan_ikes_bpp');
Route::post('post_permohonan_ikes_bpp_1',                               'RT_SM21Controller@post_permohonan_ikes_bpp_1')->name('rt-sm21.post_permohonan_ikes_bpp_1');
Route::get('/rt/sm21/permohonan-ikes-bpp-1/{id}',                        'RT_SM21Controller@permohonan_ikes_bpp_1')->name('rt-sm21.permohonan_ikes_bpp_1');
Route::post('post_permohonan_ikes_bpp_2',                               'RT_SM21Controller@post_permohonan_ikes_bpp_2')->name('rt-sm21.post_permohonan_ikes_bpp_2');
Route::get('/rt/sm21/permohonan-ikes-bpp-2/{id}',                        'RT_SM21Controller@permohonan_ikes_bpp_2')->name('rt-sm21.permohonan_ikes_bpp_2');
Route::post('post_permohonan_ikes_bpp_3',                               'RT_SM21Controller@post_permohonan_ikes_bpp_3')->name('rt-sm21.post_permohonan_ikes_bpp_3');
Route::get('/rt/sm21/permohonan-ikes-bpp-3/{id}',                        'RT_SM21Controller@permohonan_ikes_bpp_3')->name('rt-sm21.permohonan_ikes_bpp_3');
Route::post('add_spk_ikes_dokument_bpp',                                'RT_SM21Controller@add_spk_ikes_dokument_bpp')->name('rt-sm21.add_spk_ikes_dokument_bpp');
Route::post('post_permohonan_ikes_bpp_4',                               'RT_SM21Controller@post_permohonan_ikes_bpp_4')->name('rt-sm21.post_permohonan_ikes_bpp_4');

Route::get('/rt/sm21/senarai-at-ikes-p',                                'RT_SM21Controller@senarai_at_ikes_p')->name('rt-sm21.senarai_at_ikes_p');
Route::get('/rt/sm21/paparan-pelaporan-ikes-p/{id}',                    'RT_SM21Controller@paparan_pelaporan_ikes_p')->name('rt-sm21.paparan_pelaporan_ikes_p');
Route::get('/rt/sm21/paparan-pelaporan-ikes-p-1/{id}',                    'RT_SM21Controller@paparan_pelaporan_ikes_p_1')->name('rt-sm21.paparan_pelaporan_ikes_p_1');
Route::get('/rt/sm21/paparan-pelaporan-ikes-p-2/{id}',                    'RT_SM21Controller@paparan_pelaporan_ikes_p_2')->name('rt-sm21.paparan_pelaporan_ikes_p_2');
Route::get('/rt/sm21/paparan-pelaporan-ikes-p-3/{id}',                    'RT_SM21Controller@paparan_pelaporan_ikes_p_3')->name('rt-sm21.paparan_pelaporan_ikes_p_3');
Route::post('post_add_arahan_tindakan_p',                               'RT_SM21Controller@post_add_arahan_tindakan_p')->name('rt-sm21.post_add_arahan_tindakan_p');
Route::get('/rt/sm21/senarai-ts-ikes-p',                                'RT_SM21Controller@senarai_ts_ikes_p')->name('rt-sm21.senarai_ts_ikes_p');
Route::get('/rt/sm21/paparan-pelaporan-ikes-ts-p/{id}',                    'RT_SM21Controller@paparan_pelaporan_ikes_ts_p')->name('rt-sm21.paparan_pelaporan_ikes_ts_p');
Route::get('/rt/sm21/paparan-pelaporan-ikes-ts-p-1/{id}',                'RT_SM21Controller@paparan_pelaporan_ikes_ts_p_1')->name('rt-sm21.paparan_pelaporan_ikes_ts_p_1');
Route::get('/rt/sm21/paparan-pelaporan-ikes-ts-p-2/{id}',                'RT_SM21Controller@paparan_pelaporan_ikes_ts_p_2')->name('rt-sm21.paparan_pelaporan_ikes_ts_p_2');
Route::get('/rt/sm21/paparan-pelaporan-ikes-ts-p-3/{id}',                'RT_SM21Controller@paparan_pelaporan_ikes_ts_p_3')->name('rt-sm21.paparan_pelaporan_ikes_ts_p_3');
Route::get('get_view_ts_ikes/{id}',                                     'RT_SM21Controller@get_view_ts_ikes')->name('rt-sm21.get_view_ts_ikes');
Route::get('get_view_tindakan_susulan/{id}',                            'RT_SM21Controller@get_view_tindakan_susulan')->name('rt-sm21.get_view_tindakan_susulan');

Route::get('/rt/sm21/senarai-ts-ikes-ppd',                                'RT_SM21Controller@senarai_ts_ikes_ppd')->name('rt-sm21.senarai_ts_ikes_ppd');
Route::get('/rt/sm21/paparan-pelaporan-ikes-ts-ppd/{id}',                'RT_SM21Controller@paparan_pelaporan_ikes_ts_ppd')->name('rt-sm21.paparan_pelaporan_ikes_ts_ppd');
Route::get('/rt/sm21/paparan-pelaporan-ikes-ts-ppd-1/{id}',                'RT_SM21Controller@paparan_pelaporan_ikes_ts_ppd_1')->name('rt-sm21.paparan_pelaporan_ikes_ts_ppd_1');
Route::get('/rt/sm21/paparan-pelaporan-ikes-ts-ppd-2/{id}',                'RT_SM21Controller@paparan_pelaporan_ikes_ts_ppd_2')->name('rt-sm21.paparan_pelaporan_ikes_ts_ppd_2');
Route::get('/rt/sm21/paparan-pelaporan-ikes-ts-ppd-3/{id}',                'RT_SM21Controller@paparan_pelaporan_ikes_ts_ppd_3')->name('rt-sm21.paparan_pelaporan_ikes_ts_ppd_3');
Route::get('get_tindakan_susulan/{id}',                                 'RT_SM21Controller@get_tindakan_susulan')->name('rt-sm21.get_tindakan_susulan');
Route::post('post_add_ts_ikes_ppd',                                     'RT_SM21Controller@post_add_ts_ikes_ppd')->name('rt-sm21.post_add_ts_ikes_ppd');

Route::get('/rt/sm21/senarai-ts-ikes-ppn',                                'RT_SM21Controller@senarai_ts_ikes_ppn')->name('rt-sm21.senarai_ts_ikes_ppn');
Route::get('/rt/sm21/paparan-pelaporan-ikes-ts-ppn/{id}',                'RT_SM21Controller@paparan_pelaporan_ikes_ts_ppn')->name('rt-sm21.paparan_pelaporan_ikes_ts_ppn');
Route::get('/rt/sm21/paparan-pelaporan-ikes-ts-ppn-1/{id}',                'RT_SM21Controller@paparan_pelaporan_ikes_ts_ppn_1')->name('rt-sm21.paparan_pelaporan_ikes_ts_ppn_1');
Route::get('/rt/sm21/paparan-pelaporan-ikes-ts-ppn-2/{id}',                'RT_SM21Controller@paparan_pelaporan_ikes_ts_ppn_2')->name('rt-sm21.paparan_pelaporan_ikes_ts_ppn_2');
Route::get('/rt/sm21/paparan-pelaporan-ikes-ts-ppn-3/{id}',                'RT_SM21Controller@paparan_pelaporan_ikes_ts_ppn_3')->name('rt-sm21.paparan_pelaporan_ikes_ts_ppn_3');
Route::get('get_tindakan_susulan_ppn/{id}',                             'RT_SM21Controller@get_tindakan_susulan_ppn')->name('rt-sm21.get_tindakan_susulan_ppn');
Route::post('post_add_ts_ikes_ppn',                                     'RT_SM21Controller@post_add_ts_ikes_ppn')->name('rt-sm21.post_add_ts_ikes_ppn');

Route::get('/rt/sm21/senarai-permohonan-insiden-admin',                    'RT_SM21Controller@senarai_permohonan_insiden_admin')->name('rt-sm21.senarai_permohonan_insiden_admin');
Route::get('/rt/sm21/permohonan-insiden-admin',                            'RT_SM21Controller@permohonan_insiden_admin')->name('rt-sm21.permohonan_insiden_admin');
Route::get('/rt/sm21/permohonan-insiden-admin-1',                        'RT_SM21Controller@permohonan_insiden_admin_1')->name('rt-sm21.permohonan_insiden_admin_1');
Route::get('/rt/sm21/permohonan-insiden-admin-2',                        'RT_SM21Controller@permohonan_insiden_admin_2')->name('rt-sm21.permohonan_insiden_admin_2');
Route::get('/rt/sm21/permohonan-insiden-admin-3',                        'RT_SM21Controller@permohonan_insiden_admin_3')->name('rt-sm21.permohonan_insiden_admin_3');
Route::get('/rt/sm21/akuan-permohonan-insiden-admin',                    'RT_SM21Controller@akuan_permohonan_insiden_admin')->name('rt-sm21.akuan_permohonan_insiden_admin');
Route::get('/rt/sm21/akuan-permohonan-insiden-admin-1',                    'RT_SM21Controller@akuan_permohonan_insiden_admin_1')->name('rt-sm21.akuan_permohonan_insiden_admin_1');
Route::get('/rt/sm21/akuan-permohonan-insiden-admin-2',                    'RT_SM21Controller@akuan_permohonan_insiden_admin_2')->name('rt-sm21.akuan_permohonan_insiden_admin_2');
Route::get('/rt/sm21/akuan-permohonan-insiden-admin-3',                    'RT_SM21Controller@akuan_permohonan_insiden_admin_3')->name('rt-sm21.akuan_permohonan_insiden_admin_3');
Route::get('/rt/sm21/akuan-permohonan-insiden-admin-4',                    'RT_SM21Controller@akuan_permohonan_insiden_admin_4')->name('rt-sm21.akuan_permohonan_insiden_admin_4');
Route::get('/rt/sm21/semakan-permohonan-insiden-admin',                    'RT_SM21Controller@semakan_permohonan_insiden_admin')->name('rt-sm21.semakan_permohonan_insiden_admin');
Route::get('/rt/sm21/semakan-permohonan-insiden-admin-1',                'RT_SM21Controller@semakan_permohonan_insiden_admin_1')->name('rt-sm21.semakan_permohonan_insiden_admin_1');
Route::get('/rt/sm21/semakan-permohonan-insiden-admin-2',                'RT_SM21Controller@semakan_permohonan_insiden_admin_2')->name('rt-sm21.semakan_permohonan_insiden_admin_2');
Route::get('/rt/sm21/semakan-permohonan-insiden-admin-3',                'RT_SM21Controller@semakan_permohonan_insiden_admin_3')->name('rt-sm21.semakan_permohonan_insiden_admin_3');
Route::get('/rt/sm21/semakan-permohonan-insiden-admin-4',                'RT_SM21Controller@semakan_permohonan_insiden_admin_4')->name('rt-sm21.semakan_permohonan_insiden_admin_4');
Route::get('/rt/sm21/pengesahan-permohonan-insiden-admin',                'RT_SM21Controller@pengesahan_permohonan_insiden_admin')->name('rt-sm21.pengesahan_permohonan_insiden_admin');
Route::get('/rt/sm21/pengesahan-permohonan-insiden-admin-1',            'RT_SM21Controller@pengesahan_permohonan_insiden_admin_1')->name('rt-sm21.pengesahan_permohonan_insiden_admin_1');
Route::get('/rt/sm21/pengesahan-permohonan-insiden-admin-2',            'RT_SM21Controller@pengesahan_permohonan_insiden_admin_2')->name('rt-sm21.pengesahan_permohonan_insiden_admin_2');
Route::get('/rt/sm21/pengesahan-permohonan-insiden-admin-3',            'RT_SM21Controller@pengesahan_permohonan_insiden_admin_3')->name('rt-sm21.pengesahan_permohonan_insiden_admin_3');
Route::get('/rt/sm21/pengesahan-permohonan-insiden-admin-4',            'RT_SM21Controller@pengesahan_permohonan_insiden_admin_4')->name('rt-sm21.pengesahan_permohonan_insiden_admin_4');

/* Modul e-Sepakat - Modul 22 : i-Ramal */
Route::get('/rt/sm22', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm22/senarai-permohonan-muhibbah-ppd',                    'RT_SM22Controller@senarai_permohonan_muhibbah_ppd')->name('rt-sm22.senarai_permohonan_muhibbah_ppd');
Route::post('post_permohonan_imuhibbah',                                'RT_SM22Controller@post_permohonan_imuhibbah')->name('rt-sm22.post_permohonan_imuhibbah');
Route::get('/rt/sm22/permohonan-muhibbah-ppd/{id}',                        'RT_SM22Controller@permohonan_muhibbah_ppd')->name('rt-sm22.permohonan_muhibbah_ppd');
Route::post('post_permohonan_imuhibbah_1',                              'RT_SM22Controller@post_permohonan_imuhibbah_1')->name('rt-sm22.post_permohonan_imuhibbah_1');
Route::get('/rt/sm22/senarai-akuan-permohonan-muhibbah-ppn',            'RT_SM22Controller@senarai_akuan_permohonan_muhibbah_ppn')->name('rt-sm22.senarai_akuan_permohonan_muhibbah_ppn');
Route::get('/rt/sm22/akuan-permohonan-muhibbah-ppn/{id}',                'RT_SM22Controller@akuan_permohonan_muhibbah_ppn')->name('rt-sm22.akuan_permohonan_muhibbah_ppn');
Route::post('post_akui_permohonan_imuhibbah',                           'RT_SM22Controller@post_akui_permohonan_imuhibbah')->name('rt-sm22.post_akui_permohonan_imuhibbah');
Route::get('/rt/sm22/senarai-semakan-permohonan-muhibbah-bpp',            'RT_SM22Controller@senarai_semakan_permohonan_muhibbah_bpp')->name('rt-sm22.senarai_semakan_permohonan_muhibbah_bpp');
Route::get('/rt/sm22/semakan-permohonan-muhibbah-bpp/{id}',                'RT_SM22Controller@semakan_permohonan_muhibbah_bpp')->name('rt-sm22.semakan_permohonan_muhibbah_bpp');
Route::post('post_semakan_permohonan_imuhibbah',                        'RT_SM22Controller@post_semakan_permohonan_imuhibbah')->name('rt-sm22.post_semakan_permohonan_imuhibbah');
Route::get('/rt/sm22/senarai-sahkan-permohonan-muhibbah-p',                'RT_SM22Controller@senarai_sahkan_permohonan_muhibbah_p')->name('rt-sm22.senarai_sahkan_permohonan_muhibbah_p');
Route::get('/rt/sm22/sahkan-permohonan-muhibbah-p/{id}',                'RT_SM22Controller@sahkan_permohonan_muhibbah_p')->name('rt-sm22.sahkan_permohonan_muhibbah_p');
Route::post('post_sahkan_permohonan_imuhibbah',                         'RT_SM22Controller@post_sahkan_permohonan_imuhibbah')->name('rt-sm22.post_sahkan_permohonan_imuhibbah');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/rt/sm22/senarai-permohonan-muhibbah-ppn',                    'RT_SM22Controller@senarai_permohonan_muhibbah_ppn')->name('rt-sm22.senarai_permohonan_muhibbah_ppn');
Route::post('post_permohonan_imuhibbah_ppn',                            'RT_SM22Controller@post_permohonan_imuhibbah_ppn')->name('rt-sm22.post_permohonan_imuhibbah_ppn');
Route::get('/rt/sm22/permohonan-muhibbah-ppn/{id}',                        'RT_SM22Controller@permohonan_muhibbah_ppn')->name('rt-sm22.permohonan_muhibbah_ppn');
Route::post('post_permohonan_imuhibbah_ppn_1',                          'RT_SM22Controller@post_permohonan_imuhibbah_ppn_1')->name('rt-sm22.post_permohonan_imuhibbah_ppn_1');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/rt/sm22/senarai-permohonan-muhibbah-bpp',                    'RT_SM22Controller@senarai_permohonan_muhibbah_bpp')->name('rt-sm22.senarai_permohonan_muhibbah_bpp');
Route::post('post_permohonan_imuhibbah_bpp',                            'RT_SM22Controller@post_permohonan_imuhibbah_bpp')->name('rt-sm22.post_permohonan_imuhibbah_bpp');
Route::get('/rt/sm22/permohonan-muhibbah-bpp/{id}',                        'RT_SM22Controller@permohonan_muhibbah_bpp')->name('rt-sm22.permohonan_muhibbah_bpp');
Route::post('post_permohonan_imuhibbah_bpp_1',                          'RT_SM22Controller@post_permohonan_imuhibbah_bpp_1')->name('rt-sm22.post_permohonan_imuhibbah_bpp_1');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/rt/sm22/senarai-at-imuhibbah-p',                            'RT_SM22Controller@senarai_at_imuhibbah_p')->name('rt-sm22.senarai_at_imuhibbah_p');
Route::get('/rt/sm22/paparan-pelaporan-imuhibbah-p/{id}',                'RT_SM22Controller@paparan_pelaporan_imuhibbah_p')->name('rt-sm22.paparan_pelaporan_imuhibbah_p');
Route::post('post_add_at_imuhibbah_p',                                  'RT_SM22Controller@post_add_at_imuhibbah_p')->name('rt-sm22.post_add_at_imuhibbah_p');
Route::get('/rt/sm22/senarai-ts-imuhibbah-p',                            'RT_SM22Controller@senarai_ts_imuhibbah_p')->name('rt-sm22.senarai_ts_imuhibbah_p');
Route::get('/rt/sm22/paparan-pelaporan-imuhibbah-ts-p/{id}',            'RT_SM22Controller@paparan_pelaporan_imuhibbah_ts_p')->name('rt-sm22.paparan_pelaporan_imuhibbah_ts_p');
Route::get('get_view_ts_imuhibbah_p/{id}',                              'RT_SM22Controller@get_view_ts_imuhibbah_p')->name('rt-sm22.get_view_ts_imuhibbah_p');
Route::get('get_view_ts_table/{id}',                                    'RT_SM22Controller@get_view_ts_table')->name('rt-sm22.get_view_ts_table');
Route::get('/rt/sm22/senarai-ts-imuhibbah-ppd',                            'RT_SM22Controller@senarai_ts_imuhibbah_ppd')->name('rt-sm22.senarai_ts_imuhibbah_ppd');
Route::get('/rt/sm22/paparan-pelaporan-imuhibbah-ts-ppd/{id}',            'RT_SM22Controller@paparan_pelaporan_imuhibbah_ts_ppd')->name('rt-sm22.paparan_pelaporan_imuhibbah_ts_ppd');
Route::get('get_ts_imuhibbah_ppd/{id}',                                 'RT_SM22Controller@get_ts_imuhibbah_ppd')->name('rt-sm22.get_ts_imuhibbah_ppd');
Route::post('post_add_ts_imuhibbah_ppd',                                'RT_SM22Controller@post_add_ts_imuhibbah_ppd')->name('rt-sm22.post_add_ts_imuhibbah_ppd');
Route::get('/rt/sm22/senarai-ts-imuhibbah-ppn',                            'RT_SM22Controller@senarai_ts_imuhibbah_ppn')->name('rt-sm22.senarai_ts_imuhibbah_ppn');
Route::get('/rt/sm22/paparan-pelaporan-imuhibbah-ts-ppn/{id}',            'RT_SM22Controller@paparan_pelaporan_imuhibbah_ts_ppn')->name('rt-sm22.paparan_pelaporan_imuhibbah_ts_ppn');
Route::get('get_ts_imuhibbah_ppn/{id}',                                 'RT_SM22Controller@get_ts_imuhibbah_ppn')->name('rt-sm22.get_ts_imuhibbah_ppn');
Route::post('post_add_ts_imuhibbah_ppn',                                'RT_SM22Controller@post_add_ts_imuhibbah_ppn')->name('rt-sm22.post_add_ts_imuhibbah_ppn');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/rt/sm22/permohonan-muhibbah-admin',                        'RT_SM22Controller@permohonan_muhibbah_admin')->name('rt-sm22.permohonan_muhibbah_admin');
Route::get('/rt/sm22/permohonan-muhibbah-admin-1',                        'RT_SM22Controller@permohonan_muhibbah_admin_1')->name('rt-sm22.permohonan_muhibbah_admin_1');
Route::get('/rt/sm22/memperakui-muhibbah-admin',                        'RT_SM22Controller@memperakui_muhibbah_admin')->name('rt-sm22.memperakui_muhibbah_admin');
Route::get('/rt/sm22/memperakui-muhibbah-admin-1',                        'RT_SM22Controller@memperakui_muhibbah_admin_1')->name('rt-sm22.memperakui_muhibbah_admin_1');
Route::get('/rt/sm22/menyemak-muhibbah-admin',                            'RT_SM22Controller@menyemak_muhibbah_admin')->name('rt-sm22.menyemak_muhibbah_admin');
Route::get('/rt/sm22/menyemak-muhibbah-admin-1',                        'RT_SM22Controller@menyemak_muhibbah_admin_1')->name('rt-sm22.menyemak_muhibbah_admin_1');
Route::get('/rt/sm22/mengesahkan-muhibbah-admin',                        'RT_SM22Controller@mengesahkan_muhibbah_admin')->name('rt-sm22.mengesahkan_muhibbah_admin');
Route::get('/rt/sm22/mengesahkan-muhibbah-admin-1',                        'RT_SM22Controller@mengesahkan_muhibbah_admin_1')->name('rt-sm22.mengesahkan_muhibbah_admin_1');

/* Modul e-Sepakat - Modul 23 : i-Mediator */
Route::get('/rt/sm23', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm23/senarai-pra-pendaftaran-mkp-upmk',                    'RT_SM23Controller@senarai_pra_pendaftaran_mkp_upmk')->name('rt-sm23.senarai_pra_pendaftaran_mkp_upmk');
Route::get('get_profile_user/{id}',                                     'RT_SM23Controller@get_profile_user')->name('rt-sm23.get_profile_user');
Route::post('post_add_pendaftaran_mkp',                                 'RT_SM23Controller@post_add_pendaftaran_mkp')->name('rt-sm23.post_add_pendaftaran_mkp');
Route::get('get_pra_pendaftaran_mkp/{id}',                              'RT_SM23Controller@get_pra_pendaftaran_mkp')->name('rt-sm23.get_pra_pendaftaran_mkp');
Route::post('post_edit_pendaftaran_mkp',                                'RT_SM23Controller@post_edit_pendaftaran_mkp')->name('rt-sm23.post_edit_pendaftaran_mkp');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/rt/sm23/mohon-pendaftaran-mkp',                            'RT_SM23Controller@mohon_pendaftaran_mkp')->name('rt-sm23.mohon_pendaftaran_mkp');
Route::get('get_senarai_kursus_mkp_table/{id}',                         'RT_SM23Controller@get_senarai_kursus_mkp_table')->name('rt-sm23.get_senarai_kursus_mkp_table');
Route::post('post_imediator_kursus_mkp',                                'RT_SM23Controller@post_imediator_kursus_mkp')->name('rt-sm23.post_imediator_kursus_mkp');
Route::get('get_download_dokument_kursus/{id}',                         'RT_SM23Controller@get_download_dokument_kursus')->name('rt-sm23.get_download_dokument_kursus');
Route::post('/rt/sm23/post_edit_gambar_mkp',                            'RT_SM23Controller@post_edit_gambar_mkp')->name('rt-sm23.post_edit_gambar_mkp');
Route::post('post_mohon_mkp',                                           'RT_SM23Controller@post_mohon_mkp')->name('rt-sm23.post_mohon_mkp');
Route::get('/rt/sm23/senarai-permohonan-mkp-ppd',                        'RT_SM23Controller@senarai_permohonan_mkp_ppd')->name('rt-sm23.senarai_permohonan_mkp_ppd');
Route::get('/rt/sm23/sokongan-permohonan-mkp-ppd/{id}',                    'RT_SM23Controller@sokongan_permohonan_mkp_ppd')->name('rt-sm23.sokongan_permohonan_mkp_ppd');
Route::post('post_sokongan_permohonan_mkp_ppd',                         'RT_SM23Controller@post_sokongan_permohonan_mkp_ppd')->name('rt-sm23.post_sokongan_permohonan_mkp_ppd');
Route::get('/rt/sm23/senarai-permohonan-mkp-ppmk',                        'RT_SM23Controller@senarai_permohonan_mkp_ppmk')->name('rt-sm23.senarai_permohonan_mkp_ppmk');
Route::get('/rt/sm23/sokongan-permohonan-mkp-ppmk/{id}',                'RT_SM23Controller@sokongan_permohonan_mkp_ppmk')->name('rt-sm23.sokongan_permohonan_mkp_ppmk');
Route::post('post_sokongan_permohonan_mkp_ppmk',                        'RT_SM23Controller@post_sokongan_permohonan_mkp_ppmk')->name('rt-sm23.post_sokongan_permohonan_mkp_ppmk');
Route::get('/rt/sm23/senarai-permohonan-mkp-ppn',                        'RT_SM23Controller@senarai_permohonan_mkp_ppn')->name('rt-sm23.senarai_permohonan_mkp_ppn');
Route::get('/rt/sm23/pengesahan-permohonan-mkp-ppn/{id}',                'RT_SM23Controller@pengesahan_permohonan_mkp_ppn')->name('rt-sm23.pengesahan_permohonan_mkp_ppn');
Route::post('post_pengesahan_permohonan_mkp_ppn',                       'RT_SM23Controller@post_pengesahan_permohonan_mkp_ppn')->name('rt-sm23.post_pengesahan_permohonan_mkp_ppn');
Route::get('/rt/sm23/senarai-permohonan-mkp-upmk',                        'RT_SM23Controller@senarai_permohonan_mkp_upmk')->name('rt-sm23.senarai_permohonan_mkp_upmk');
Route::get('/rt/sm23/semakan-permohonan-mkp-upmk/{id}',                    'RT_SM23Controller@semakan_permohonan_mkp_upmk')->name('rt-sm23.semakan_permohonan_mkp_upmk');
Route::post('post_semakan_permohonan_mkp_upmk',                         'RT_SM23Controller@post_semakan_permohonan_mkp_upmk')->name('rt-sm23.post_semakan_permohonan_mkp_upmk');
Route::get('/rt/sm23/senarai-permohonan-mkp-ppp',                        'RT_SM23Controller@senarai_permohonan_mkp_ppp')->name('rt-sm23.senarai_permohonan_mkp_ppp');
Route::get('/rt/sm23/kelulusan-permohonan-mkp-ppp/{id}',                'RT_SM23Controller@kelulusan_permohonan_mkp_ppp')->name('rt-sm23.kelulusan_permohonan_mkp_ppp');
Route::post('post_kelulusan_permohonan_mkp_ppp',                        'RT_SM23Controller@post_kelulusan_permohonan_mkp_ppp')->name('rt-sm23.post_kelulusan_permohonan_mkp_ppp');
Route::get('/rt/sm23/senarai-permohonan-mkp-kp',                        'RT_SM23Controller@senarai_permohonan_mkp_kp')->name('rt-sm23.senarai_permohonan_mkp_kp');
Route::get('/rt/sm23/pelantikan-permohonan-mkp-kp/{id}',                'RT_SM23Controller@pelantikan_permohonan_mkp_kp')->name('rt-sm23.pelantikan_permohonan_mkp_kp');
Route::post('post_pelantikan_permohonan_mkp_kp',                        'RT_SM23Controller@post_pelantikan_permohonan_mkp_kp')->name('rt-sm23.post_pelantikan_permohonan_mkp_kp');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/rt/sm23/senarai-mkp-dilantik-ppd',                            'RT_SM23Controller@senarai_mkp_dilantik_ppd')->name('rt-sm23.senarai_mkp_dilantik_ppd');
Route::get('/rt/sm23/profile-mkp-ppd/{id}',                                'RT_SM23Controller@profile_mkp_ppd')->name('rt-sm23.profile_mkp_ppd');
Route::get('/rt/sm23/senarai-mkp-dilantik-ppmk',                        'RT_SM23Controller@senarai_mkp_dilantik_ppmk')->name('rt-sm23.senarai_mkp_dilantik_ppmk');
Route::get('/rt/sm23/profile-mkp-ppmk/{id}',                            'RT_SM23Controller@profile_mkp_ppmk')->name('rt-sm23.profile_mkp_ppmk');
Route::get('/rt/sm23/senarai-mkp-dilantik-ppn',                            'RT_SM23Controller@senarai_mkp_dilantik_ppn')->name('rt-sm23.senarai_mkp_dilantik_ppn');
Route::get('/rt/sm23/profile-mkp-ppn/{id}',                                'RT_SM23Controller@profile_mkp_ppn')->name('rt-sm23.profile_mkp_ppn');
Route::get('/rt/sm23/senarai-mkp-dilantik-upmk',                        'RT_SM23Controller@senarai_mkp_dilantik_upmk')->name('rt-sm23.senarai_mkp_dilantik_upmk');
Route::get('/rt/sm23/profile-mkp-upmk/{id}',                            'RT_SM23Controller@profile_mkp_upmk')->name('rt-sm23.profile_mkp_upmk');
Route::get('/rt/sm23/senarai-mkp-dilantik-ppp',                            'RT_SM23Controller@senarai_mkp_dilantik_ppp')->name('rt-sm23.senarai_mkp_dilantik_ppp');
Route::get('/rt/sm23/profile-mkp-ppp/{id}',                                'RT_SM23Controller@profile_mkp_ppp')->name('rt-sm23.profile_mkp_ppp');
Route::get('/rt/sm23/senarai-mkp-dilantik-kp',                            'RT_SM23Controller@senarai_mkp_dilantik_kp')->name('rt-sm23.senarai_mkp_dilantik_kp');
Route::get('/rt/sm23/profile-mkp-kp/{id}',                                'RT_SM23Controller@profile_mkp_kp')->name('rt-sm23.profile_mkp_kp');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/rt/sm23/senarai-permohonan-laporan-mediasi',                'RT_SM23Controller@senarai_permohonan_laporan_mediasi')->name('rt-sm23.senarai_permohonan_laporan_mediasi');
Route::post('/rt/sm23/post_permohonan_laporan_mediasi',                 'RT_SM23Controller@post_permohonan_laporan_mediasi')->name('rt-sm23.post_permohonan_laporan_mediasi');
Route::get('/rt/sm23/permohonan-laporan-mediasi-mkp/{id}',                'RT_SM23Controller@permohonan_laporan_mediasi_mkp')->name('rt-sm23.permohonan_laporan_mediasi_mkp');
Route::get('get_laporan_mediasi_terlibat_table/{id}',                   'RT_SM23Controller@get_laporan_mediasi_terlibat_table')->name('rt-sm23.get_laporan_mediasi_terlibat_table');
Route::post('post_add_pihak_terlibat_laporan_mediasi',                  'RT_SM23Controller@post_add_pihak_terlibat_laporan_mediasi')->name('rt-sm23.post_add_pihak_terlibat_laporan_mediasi');
Route::get('delete_laporan_mediasi_terlibat/{id}',                      'RT_SM23Controller@delete_laporan_mediasi_terlibat')->name('rt-sm23.delete_laporan_mediasi_terlibat');
Route::post('/rt/sm23/post_permohonan_laporan_mediasi_1',               'RT_SM23Controller@post_permohonan_laporan_mediasi_1')->name('rt-sm23.post_permohonan_laporan_mediasi_1');
Route::get('/rt/sm23/senarai-semakan-laporan-mediasi-ppd',                'RT_SM23Controller@senarai_semakan_laporan_mediasi_ppd')->name('rt-sm23.senarai_semakan_laporan_mediasi_ppd');
Route::get('/rt/sm23/semakan-laporan-mediasi-mkp-ppd/{id}',                'RT_SM23Controller@semakan_laporan_mediasi_mkp_ppd')->name('rt-sm23.semakan_laporan_mediasi_mkp_ppd');
Route::post('/rt/sm23/post_semakan_laporan_mediasi_ppd',                'RT_SM23Controller@post_semakan_laporan_mediasi_ppd')->name('rt-sm23.post_semakan_laporan_mediasi_ppd');
Route::get('/rt/sm23/senarai-semakan-laporan-mediasi-ppmk',                'RT_SM23Controller@senarai_semakan_laporan_mediasi_ppmk')->name('rt-sm23.senarai_semakan_laporan_mediasi_ppmk');
Route::get('/rt/sm23/semakan-laporan-mediasi-mkp-ppmk/{id}',            'RT_SM23Controller@semakan_laporan_mediasi_mkp_ppmk')->name('rt-sm23.semakan_laporan_mediasi_mkp_ppmk');
Route::post('/rt/sm23/post_semakan_laporan_mediasi_ppmk',               'RT_SM23Controller@post_semakan_laporan_mediasi_ppmk')->name('rt-sm23.post_semakan_laporan_mediasi_ppmk');
Route::get('/rt/sm23/senarai-pengesahan-laporan-mediasi-ppn',            'RT_SM23Controller@senarai_pengesahan_laporan_mediasi_ppn')->name('rt-sm23.senarai_pengesahan_laporan_mediasi_ppn');
Route::get('/rt/sm23/pengesahan-laporan-mediasi-mkp-ppn/{id}',            'RT_SM23Controller@pengesahan_laporan_mediasi_mkp_ppn')->name('rt-sm23.pengesahan_laporan_mediasi_mkp_ppn');
Route::post('/rt/sm23/post_pengesahan_laporan_mediasi_ppn',             'RT_SM23Controller@post_pengesahan_laporan_mediasi_ppn')->name('rt-sm23.post_pengesahan_laporan_mediasi_ppn');
Route::get('/rt/sm23/senarai-semakan-laporan-mediasi-upmk',                'RT_SM23Controller@senarai_semakan_laporan_mediasi_upmk')->name('rt-sm23.senarai_semakan_laporan_mediasi_upmk');
Route::get('/rt/sm23/semakan-laporan-kes-mkp-upmk/{id}',                'RT_SM23Controller@semakan_laporan_kes_mkp_upmk')->name('rt-sm23.semakan_laporan_kes_mkp_upmk');
Route::post('/rt/sm23/post_semakan_laporan_mediasi_upmk',               'RT_SM23Controller@post_semakan_laporan_mediasi_upmk')->name('rt-sm23.post_semakan_laporan_mediasi_upmk');
Route::get('/rt/sm23/senarai-lulus-laporan-mediasi-pp',                    'RT_SM23Controller@senarai_lulus_laporan_mediasi_pp')->name('rt-sm23.senarai_lulus_laporan_mediasi_pp');
Route::get('/rt/sm23/kelulusan-laporan-kes-mkp-pp/{id}',                'RT_SM23Controller@kelulusan_laporan_kes_mkp_pp')->name('rt-sm23.kelulusan_laporan_kes_mkp_pp');
Route::post('/rt/sm23/post_lulus_laporan_mediasi_pp',                   'RT_SM23Controller@post_lulus_laporan_mediasi_pp')->name('rt-sm23.post_lulus_laporan_mediasi_pp');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/rt/sm23/senarai-laporan-kes-upmk',                            'RT_SM23Controller@senarai_laporan_kes_upmk')->name('rt-sm23.senarai_laporan_kes_upmk');
Route::get('/rt/sm23/laporan-kes-mkp-upmk/{id}',                        'RT_SM23Controller@laporan_kes_mkp_upmk')->name('rt-sm23.laporan_kes_mkp_upmk');
Route::get('/rt/sm23/senarai-laporan-kes-pp',                            'RT_SM23Controller@senarai_laporan_kes_pp')->name('rt-sm23.senarai_laporan_kes_pp');
Route::get('/rt/sm23/laporan-kes-mkp-pp/{id}',                            'RT_SM23Controller@laporan_kes_mkp_pp')->name('rt-sm23.laporan_kes_mkp_pp');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/rt/sm23/mohon-keaktifan-mkp',                                'RT_SM23Controller@mohon_keaktifan_mkp')->name('rt-sm23.mohon_keaktifan_mkp');
Route::get('get_kes_mediasi_mkp_table/{id}',                            'RT_SM23Controller@get_kes_mediasi_mkp_table')->name('rt-sm23.get_kes_mediasi_mkp_table');
Route::get('get_keaktifan_aktiviti_mkp_table/{id}',                     'RT_SM23Controller@get_keaktifan_aktiviti_mkp_table')->name('rt-sm23.get_keaktifan_aktiviti_mkp_table');
Route::post('post_add_keaktifan_aktiviti_mkp',                          'RT_SM23Controller@post_add_keaktifan_aktiviti_mkp')->name('rt-sm23.post_add_keaktifan_aktiviti_mkp');
Route::get('delete_keaktifan_aktiviti_mkp/{id}',                        'RT_SM23Controller@delete_keaktifan_aktiviti_mkp')->name('rt-sm23.delete_keaktifan_aktiviti_mkp');
Route::get('/rt/sm23/mohon-keaktifan-mkp-1',                            'RT_SM23Controller@mohon_keaktifan_mkp_1')->name('rt-sm23.mohon_keaktifan_mkp_1');
Route::get('get_keaktifan_latihan_table_mkp/{id}',                      'RT_SM23Controller@get_keaktifan_latihan_table_mkp')->name('rt-sm23.get_keaktifan_latihan_table_mkp');
Route::post('post_add_keaktifan_latihan_mkp',                           'RT_SM23Controller@post_add_keaktifan_latihan_mkp')->name('rt-sm23.post_add_keaktifan_latihan_mkp');
Route::get('delete_keaktifan_latihan_mkp/{id}',                         'RT_SM23Controller@delete_keaktifan_latihan_mkp')->name('rt-sm23.delete_keaktifan_latihan_mkp');
Route::get('get_keaktifan_sumbangan_mkp_table/{id}',                    'RT_SM23Controller@get_keaktifan_sumbangan_mkp_table')->name('rt-sm23.get_keaktifan_sumbangan_mkp_table');
Route::post('post_add_keaktifan_sumbangan_mkp',                         'RT_SM23Controller@post_add_keaktifan_sumbangan_mkp')->name('rt-sm23.post_add_keaktifan_sumbangan_mkp');
Route::get('delete_keaktifan_sumbangan_mkp/{id}',                       'RT_SM23Controller@delete_keaktifan_sumbangan_mkp')->name('rt-sm23.delete_keaktifan_sumbangan_mkp');
Route::post('post_permohonan_keaktifan_mkp',                            'RT_SM23Controller@post_permohonan_keaktifan_mkp')->name('rt-sm23.post_permohonan_keaktifan_mkp');
Route::post('post_edit_permohonan_keaktifan_mkp',                       'RT_SM23Controller@post_edit_permohonan_keaktifan_mkp')->name('rt-sm23.post_edit_permohonan_keaktifan_mkp');
Route::get('/rt/sm23/senarai-permohonan-mkp-keaktifan-ppd',                'RT_SM23Controller@senarai_permohonan_mkp_keaktifan_ppd')->name('rt-sm23.senarai_permohonan_mkp_keaktifan_ppd');
Route::get('/rt/sm23/sokongan-keaktifan-mkp-ppd/{id}',                    'RT_SM23Controller@sokongan_keaktifan_mkp_ppd')->name('rt-sm23.sokongan_keaktifan_mkp_ppd');
Route::post('post_sokongan_mkp_keaktifan_ppd',                          'RT_SM23Controller@post_sokongan_mkp_keaktifan_ppd')->name('rt-sm23.post_sokongan_mkp_keaktifan_ppd');
Route::get('/rt/sm23/senarai-permohonan-mkp-keaktifan-ppmk',            'RT_SM23Controller@senarai_permohonan_mkp_keaktifan_ppmk')->name('rt-sm23.senarai_permohonan_mkp_keaktifan_ppmk');
Route::get('/rt/sm23/sokongan-keaktifan-mkp-ppmk/{id}',                    'RT_SM23Controller@sokongan_keaktifan_mkp_ppmk')->name('rt-sm23.sokongan_keaktifan_mkp_ppmk');
Route::post('post_sokongan_mkp_keaktifan_ppmk',                         'RT_SM23Controller@post_sokongan_mkp_keaktifan_ppmk')->name('rt-sm23.post_sokongan_mkp_keaktifan_ppmk');
Route::get('/rt/sm23/senarai-permohonan-mkp-keaktifan-ppn',                'RT_SM23Controller@senarai_permohonan_mkp_keaktifan_ppn')->name('rt-sm23.senarai_permohonan_mkp_keaktifan_ppn');
Route::get('/rt/sm23/sahkan-keaktifan-mkp-ppn/{id}',                    'RT_SM23Controller@sahkan_keaktifan_mkp_ppn')->name('rt-sm23.sahkan_keaktifan_mkp_ppn');
Route::post('post_sahkan_mkp_keaktifan_ppn',                            'RT_SM23Controller@post_sahkan_mkp_keaktifan_ppn')->name('rt-sm23.post_sahkan_mkp_keaktifan_ppn');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/rt/sm23/senarai-mkp-keaktifan-ppd',                        'RT_SM23Controller@senarai_mkp_keaktifan_ppd')->name('rt-sm23.senarai_mkp_keaktifan_ppd');
Route::get('/rt/sm23/keaktifan-mkp-ppd/{id}',                            'RT_SM23Controller@keaktifan_mkp_ppd')->name('rt-sm23.keaktifan_mkp_ppd');
Route::get('/rt/sm23/senarai-mkp-keaktifan-ppmk',                        'RT_SM23Controller@senarai_mkp_keaktifan_ppmk')->name('rt-sm23.senarai_mkp_keaktifan_ppmk');
Route::get('/rt/sm23/keaktifan-mkp-ppmk/{id}',                            'RT_SM23Controller@keaktifan_mkp_ppmk')->name('rt-sm23.keaktifan_mkp_ppmk');
Route::get('/rt/sm23/senarai-mkp-keaktifan-ppn',                        'RT_SM23Controller@senarai_mkp_keaktifan_ppn')->name('rt-sm23.senarai_mkp_keaktifan_ppn');
Route::get('/rt/sm23/keaktifan-mkp-ppn/{id}',                            'RT_SM23Controller@keaktifan_mkp_ppn')->name('rt-sm23.keaktifan_mkp_ppn');
Route::get('/rt/sm23/senarai-mkp-keaktifan-upmk',                        'RT_SM23Controller@senarai_mkp_keaktifan_upmk')->name('rt-sm23.senarai_mkp_keaktifan_upmk');
Route::get('/rt/sm23/keaktifan-mkp-upmk/{id}',                            'RT_SM23Controller@keaktifan_mkp_upmk')->name('rt-sm23.keaktifan_mkp_upmk');
Route::get('/rt/sm23/senarai-mkp-keaktifan-p',                            'RT_SM23Controller@senarai_mkp_keaktifan_p')->name('rt-sm23.senarai_mkp_keaktifan_p');
Route::get('/rt/sm23/keaktifan-mkp-p/{id}',                                'RT_SM23Controller@keaktifan_mkp_p')->name('rt-sm23.keaktifan_mkp_p');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/rt/sm23/permohonan-pelanjutan-mkp',                        'RT_SM23Controller@permohonan_pelanjutan_mkp')->name('rt-sm23.permohonan_pelanjutan_mkp');
Route::post('post_imediator_kursus',                                    'RT_SM23Controller@post_imediator_kursus')->name('rt-sm23.post_imediator_kursus');
Route::get('delete_kursus_mkp/{id}',                                    'RT_SM23Controller@delete_kursus_mkp')->name('rt-sm23.delete_kursus_mkp');
Route::post('post_mohon_pelanjutan_mkp',                                'RT_SM23Controller@post_mohon_pelanjutan_mkp')->name('rt-sm23.post_mohon_pelanjutan_mkp');
Route::get('/rt/sm23/senarai-sokongan-pelanjutan-mkp-ppd',                'RT_SM23Controller@senarai_sokongan_pelanjutan_mkp_ppd')->name('rt-sm23.senarai_sokongan_pelanjutan_mkp_ppd');
Route::get('/rt/sm23/sokongan-pelanjuatan-mkp-ppd/{id}',                'RT_SM23Controller@sokongan_pelanjuatan_mkp_ppd')->name('rt-sm23.sokongan_pelanjuatan_mkp_ppd');
Route::post('post_sokongan_pelanjutan_mkp_ppd',                         'RT_SM23Controller@post_sokongan_pelanjutan_mkp_ppd')->name('rt-sm23.post_sokongan_pelanjutan_mkp_ppd');
Route::get('/rt/sm23/senarai-sokongan-pelanjutan-mkp-ppmk',                'RT_SM23Controller@senarai_sokongan_pelanjutan_mkp_ppmk')->name('rt-sm23.senarai_sokongan_pelanjutan_mkp_ppmk');
Route::get('/rt/sm23/sokongan-pelanjuatan-mkp-ppmk/{id}',                'RT_SM23Controller@sokongan_pelanjuatan_mkp_ppmk')->name('rt-sm23.sokongan_pelanjuatan_mkp_ppmk');
Route::post('post_sokongan_pelanjutan_mkp_ppmk',                        'RT_SM23Controller@post_sokongan_pelanjutan_mkp_ppmk')->name('rt-sm23.post_sokongan_pelanjutan_mkp_ppmk');
Route::get('/rt/sm23/senarai-sahkan-pelanjutan-mkp-ppn',                'RT_SM23Controller@senarai_sahkan_pelanjutan_mkp_ppn')->name('rt-sm23.senarai_sahkan_pelanjutan_mkp_ppn');
Route::get('/rt/sm23/sahkan-pelanjuatan-mkp-ppn/{id}',                    'RT_SM23Controller@sahkan_pelanjuatan_mkp_ppn')->name('rt-sm23.sahkan_pelanjuatan_mkp_ppn');
Route::post('post_sahkan_pelanjutan_mkp_ppn',                           'RT_SM23Controller@post_sahkan_pelanjutan_mkp_ppn')->name('rt-sm23.post_sahkan_pelanjutan_mkp_ppn');
Route::get('/rt/sm23/senarai-semakan-pelanjutan-mkp-upmk',                'RT_SM23Controller@senarai_semakan_pelanjutan_mkp_upmk')->name('rt-sm23.senarai_semakan_pelanjutan_mkp_upmk');
Route::get('/rt/sm23/semakan-pelanjuatan-mkp-upmk/{id}',                'RT_SM23Controller@semakan_pelanjuatan_mkp_upmk')->name('rt-sm23.semakan_pelanjuatan_mkp_upmk');
Route::post('post_semakan_pelanjutan_mkp_upmk',                         'RT_SM23Controller@post_semakan_pelanjutan_mkp_upmk')->name('rt-sm23.post_semakan_pelanjutan_mkp_upmk');
Route::get('/rt/sm23/senarai-kelulusan-pelanjutan-mkp-ppp',                'RT_SM23Controller@senarai_kelulusan_pelanjutan_mkp_ppp')->name('rt-sm23.senarai_kelulusan_pelanjutan_mkp_ppp');
Route::get('/rt/sm23/kelulusan-pelanjuatan-mkp-ppp/{id}',                'RT_SM23Controller@kelulusan_pelanjuatan_mkp_ppp')->name('rt-sm23.kelulusan_pelanjuatan_mkp_ppp');
Route::post('post_kelulusan_pelanjutan_mkp_ppp',                        'RT_SM23Controller@post_kelulusan_pelanjutan_mkp_ppp')->name('rt-sm23.post_kelulusan_pelanjutan_mkp_ppp');
Route::get('/rt/sm23/senarai-lantikan-pelanjutan-mkp-kp',                'RT_SM23Controller@senarai_lantikan_pelanjutan_mkp_kp')->name('rt-sm23.senarai_lantikan_pelanjutan_mkp_kp');
Route::get('/rt/sm23/lantikan-pelanjuatan-mkp-kp/{id}',                    'RT_SM23Controller@lantikan_pelanjuatan_mkp_kp')->name('rt-sm23.lantikan_pelanjuatan_mkp_kp');
Route::post('post_lantikan_pelanjutan_mkp_kp',                          'RT_SM23Controller@post_lantikan_pelanjutan_mkp_kp')->name('rt-sm23.post_lantikan_pelanjutan_mkp_kp');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/rt/sm23/permohonan-mkp-admin',                                'RT_SM23Controller@permohonan_mkp_admin')->name('rt-sm23.permohonan_mkp_admin');
Route::get('/rt/sm23/permohonan-mkp-admin-1',                            'RT_SM23Controller@permohonan_mkp_admin_1')->name('rt-sm23.permohonan_mkp_admin_1');
Route::get('/rt/sm23/sokongan-mkp-admin-ppd',                            'RT_SM23Controller@sokongan_mkp_admin_ppd')->name('rt-sm23.sokongan_mkp_admin_ppd');
Route::get('/rt/sm23/sokongan-mkp-admin-ppd-1',                            'RT_SM23Controller@sokongan_mkp_admin_ppd_1')->name('rt-sm23.sokongan_mkp_admin_ppd_1');
Route::get('/rt/sm23/sokongan-mkp-admin-ppmk',                            'RT_SM23Controller@sokongan_mkp_admin_ppmk')->name('rt-sm23.sokongan_mkp_admin_ppmk');
Route::get('/rt/sm23/sokongan-mkp-admin-ppmk-1',                        'RT_SM23Controller@sokongan_mkp_admin_ppmk_1')->name('rt-sm23.sokongan_mkp_admin_ppmk_1');
Route::get('/rt/sm23/pengesahan-mkp-admin-ppn',                            'RT_SM23Controller@pengesahan_mkp_admin_ppn')->name('rt-sm23.pengesahan_mkp_admin_ppn');
Route::get('/rt/sm23/pengesahan-mkp-admin-ppn-1',                        'RT_SM23Controller@pengesahan_mkp_admin_ppn_1')->name('rt-sm23.pengesahan_mkp_admin_ppn_1');
Route::get('/rt/sm23/menyemak-mkp-admin-hq',                            'RT_SM23Controller@menyemak_mkp_admin_hq')->name('rt-sm23.menyemak_mkp_admin_hq');
Route::get('/rt/sm23/menyemak-mkp-admin-hq-1',                            'RT_SM23Controller@menyemak_mkp_admin_hq_1')->name('rt-sm23.menyemak_mkp_admin_hq_1');
Route::get('/rt/sm23/kelulusan-mkp-admin-hq',                            'RT_SM23Controller@kelulusan_mkp_admin_hq')->name('rt-sm23.kelulusan_mkp_admin_hq');
Route::get('/rt/sm23/kelulusan-mkp-admin-hq-1',                            'RT_SM23Controller@kelulusan_mkp_admin_hq_1')->name('rt-sm23.kelulusan_mkp_admin_hq_1');
Route::get('/rt/sm23/senarai-mkp-admin',                                'RT_SM23Controller@senarai_mkp_admin')->name('rt-sm23.senarai_mkp_admin');
Route::get('/rt/sm23/statistik-mkp-admin',                                'RT_SM23Controller@statistik_mkp_admin')->name('rt-sm23.statistik_mkp_admin');

/* Modul e-Sepakat - Modul 24 : Penilaian Keaktifan MKP **/
Route::get('/rt/sm24', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm24/borang-keaktifan-mkp-admin',                        'RT_SM24Controller@borang_keaktifan_mkp_admin')->name('rt-sm24.borang_keaktifan_mkp_admin');
Route::get('/rt/sm24/borang-keaktifan-mkp-admin-1',                        'RT_SM24Controller@borang_keaktifan_mkp_admin_1')->name('rt-sm24.borang_keaktifan_mkp_admin_1');
Route::get('/rt/sm24/senarai-keaktifan-mkp-admin',                        'RT_SM24Controller@senarai_keaktifan_mkp_admin')->name('rt-sm24.senarai_keaktifan_mkp_admin');
Route::get('/rt/sm24/senarai-keaktifan-mkp-admin-1',                    'RT_SM24Controller@senarai_keaktifan_mkp_admin_1')->name('rt-sm24.senarai_keaktifan_mkp_admin_1');


/* Modul e-Sepakat - Modul 26 : Pelaporan Mediasi */
Route::get('/rt/sm26', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm26/permohonan-laporan-kes-mediasi-admin',                'RT_SM26Controller@permohonan_laporan_kes_mediasi_admin')->name('rt-sm26.permohonan_laporan_kes_mediasi_admin');
Route::get('/rt/sm26/permohonan-laporan-kes-mediasi-admin-1',            'RT_SM26Controller@permohonan_laporan_kes_mediasi_admin_1')->name('rt-sm26.permohonan_laporan_kes_mediasi_admin_1');
Route::get('/rt/sm26/perakuan-laporan-kes-mediasi-admin',                'RT_SM26Controller@perakuan_laporan_kes_mediasi_admin')->name('rt-sm26.perakuan_laporan_kes_mediasi_admin');
Route::get('/rt/sm26/perakuan-laporan-kes-mediasi-admin-1',                'RT_SM26Controller@perakuan_laporan_kes_mediasi_admin_1')->name('rt-sm26.perakuan_laporan_kes_mediasi_admin_1');
Route::get('/rt/sm26/perakuan-laporan-kes-mediasi-admin-p',                'RT_SM26Controller@perakuan_laporan_kes_mediasi_admin_p')->name('rt-sm26.perakuan_laporan_kes_mediasi_admin_p');
Route::get('/rt/sm26/perakuan-laporan-kes-mediasi-admin-p-1',            'RT_SM26Controller@perakuan_laporan_kes_mediasi_admin_p_1')->name('rt-sm26.perakuan_laporan_kes_mediasi_admin_p_1');
Route::get('/rt/sm26/pengesahan-laporan-kes-mediasi-admin',                'RT_SM26Controller@pengesahan_laporan_kes_mediasi_admin')->name('rt-sm26.pengesahan_laporan_kes_mediasi_admin');
Route::get('/rt/sm26/pengesahan-laporan-kes-mediasi-admin-1',            'RT_SM26Controller@pengesahan_laporan_kes_mediasi_admin_1')->name('rt-sm26.pengesahan_laporan_kes_mediasi_admin_1');

/* Modul e-Tabika - Modul 27 : e-Tabika */
Route::get('/rt/sm27/senarai-permohonan-student-tp-p',                    'RT_SM27Controller@senarai_permohonan_student_tp_p')->name('rt-sm27.senarai_permohonan_student_tp_p');
Route::post('post_permohonan_student_tp',                               'RT_SM27Controller@post_permohonan_student_tp')->name('rt-sm27.post_permohonan_student_tp');
Route::get('/rt/sm27/mohon-student-tp-p/{id}',                            'RT_SM27Controller@mohon_student_tp_p')->name('rt-sm27.mohon_student_tp_p');
Route::post('post_permohonan_student_tp_1',                             'RT_SM27Controller@post_permohonan_student_tp_1')->name('rt-sm27.post_permohonan_student_tp_1');
Route::get('/rt/sm27/mohon-student-tp-p-1/{id}',                        'RT_SM27Controller@mohon_student_tp_p_1')->name('rt-sm27.mohon_student_tp_p_1');
Route::get('get_pengesahan_penjaga_table/{id}',                         'RT_SM27Controller@get_pengesahan_penjaga_table')->name('rt-sm27.get_pengesahan_penjaga_table');
Route::post('post_pengesahan_penjaga',                                  'RT_SM27Controller@post_pengesahan_penjaga')->name('rt-sm27.post_pengesahan_penjaga');
Route::post('post_delete_pengesahan_penjaga',                           'RT_SM27Controller@post_delete_pengesahan_penjaga')->name('rt-sm27.post_delete_pengesahan_penjaga');
Route::get('get_dokument_student_table/{id}',                           'RT_SM27Controller@get_dokument_student_table')->name('rt-sm27.get_dokument_student_table');
Route::post('add_tbk_student_dokument',                                 'RT_SM27Controller@add_tbk_student_dokument')->name('rt-sm27.add_tbk_student_dokument');
Route::get('get_download_dokument_student/{id}',                        'RT_SM27Controller@get_download_dokument_student')->name('rt-sm27.get_download_dokument_student');
Route::get('delete_dokument_student/{id}',                              'RT_SM27Controller@delete_dokument_student')->name('rt-sm27.delete_dokument_student');
Route::post('post_permohonan_student_tp_2_back',                        'RT_SM27Controller@post_permohonan_student_tp_2_back')->name('rt-sm27.post_permohonan_student_tp_2_back');
Route::post('post_permohonan_student_tp_2',                             'RT_SM27Controller@post_permohonan_student_tp_2')->name('rt-sm27.post_permohonan_student_tp_2');
Route::get('/rt/sm27/senarai-sah-mohon-student-tp-g',                    'RT_SM27Controller@senarai_sah_mohon_student_tp_g')->name('rt-sm27.senarai_sah_mohon_student_tp_g');
Route::get('/rt/sm27/sah-mohon-student-tp-g/{id}',                        'RT_SM27Controller@sah_mohon_student_tp_g')->name('rt-sm27.sah_mohon_student_tp_g');
Route::get('/rt/sm27/sah-mohon-student-tp-g-1/{id}',                    'RT_SM27Controller@sah_mohon_student_tp_g_1')->name('rt-sm27.sah_mohon_student_tp_g_1');
Route::post('post_sah_permohonan_student',                              'RT_SM27Controller@post_sah_permohonan_student')->name('rt-sm27.post_sah_permohonan_student');
Route::get('/rt/sm27/senarai-lulus-mohon-student-tp-ppd',                'RT_SM27Controller@senarai_lulus_mohon_student_tp_ppd')->name('rt-sm27.senarai_lulus_mohon_student_tp_ppd');
Route::get('/rt/sm27/lulus-mohon-student-tp-ppd/{id}',                    'RT_SM27Controller@lulus_mohon_student_tp_ppd')->name('rt-sm27.lulus_mohon_student_tp_ppd');
Route::get('/rt/sm27/lulus-mohon-student-tp-ppd-1/{id}',                'RT_SM27Controller@lulus_mohon_student_tp_ppd_1')->name('rt-sm27.lulus_mohon_student_tp_ppd_1');
Route::post('post_lulus_permohonan_student',                            'RT_SM27Controller@post_lulus_permohonan_student')->name('rt-sm27.post_lulus_permohonan_student');
Route::get('/rt/sm27/senarai-student-tp-p',                                'RT_SM27Controller@senarai_student_tp_p')->name('rt-sm27.senarai_student_tp_p');
Route::get('/rt/sm27/student-tp-p/{id}',                                'RT_SM27Controller@student_tp_p')->name('rt-sm27.student_tp_p');
Route::get('/rt/sm27/student-tp-p-1/{id}',                                'RT_SM27Controller@student_tp_p_1')->name('rt-sm27.student_tp_p_1');
Route::get('/rt/sm27/senarai-student-tp-g',                                'RT_SM27Controller@senarai_student_tp_g')->name('rt-sm27.senarai_student_tp_g');
Route::get('/rt/sm27/student-tp-g/{id}',                                'RT_SM27Controller@student_tp_g')->name('rt-sm27.student_tp_g');
Route::get('/rt/sm27/student-tp-g-1/{id}',                                'RT_SM27Controller@student_tp_g_1')->name('rt-sm27.student_tp_g_1');
Route::get('/rt/sm27/senarai-student-tp-ppd',                            'RT_SM27Controller@senarai_student_tp_ppd')->name('rt-sm27.senarai_student_tp_ppd');
Route::get('/rt/sm27/student-tp-ppd/{id}',                                'RT_SM27Controller@student_tp_ppd')->name('rt-sm27.student_tp_ppd');
Route::get('/rt/sm27/student-tp-ppd-1/{id}',                            'RT_SM27Controller@student_tp_ppd_1')->name('rt-sm27.student_tp_ppd_1');
Route::get('/rt/sm27/senarai-student-tp-hqtp',                            'RT_SM27Controller@senarai_student_tp_hqtp')->name('rt-sm27.senarai_student_tp_hqtp');
Route::get('/rt/sm27/student-tp-hqtp/{id}',                                'RT_SM27Controller@student_tp_hqtp')->name('rt-sm27.student_tp_hqtp');
Route::get('/rt/sm27/student-tp-hqtp-1/{id}',                            'RT_SM27Controller@student_tp_hqtp_1')->name('rt-sm27.student_tp_hqtp_1');
Route::get('/rt/sm27/senarai-student-tp-pksin',                            'RT_SM27Controller@senarai_student_tp_pksin')->name('rt-sm27.senarai_student_tp_pksin');
Route::get('/rt/sm27/student-tp-pksin/{id}',                            'RT_SM27Controller@student_tp_pksin')->name('rt-sm27.student_tp_pksin');
Route::get('/rt/sm27/student-tp-pksin-1/{id}',                            'RT_SM27Controller@student_tp_pksin_1')->name('rt-sm27.student_tp_pksin_1');

Route::get('/rt/sm27/senarai-mohon-masuk-tabika-admin',                    'RT_SM27Controller@senarai_mohon_masuk_tabika_admin')->name('rt-sm27.senarai_mohon_masuk_tabika_admin');
Route::get('/rt/sm27/mohon-masuk-tabika-admin',                            'RT_SM27Controller@mohon_masuk_tabika_admin')->name('rt-sm27.mohon_masuk_tabika_admin');
Route::get('/rt/sm27/mohon-masuk-tabika-admin-1',                        'RT_SM27Controller@mohon_masuk_tabika_admin_1')->name('rt-sm27.mohon_masuk_tabika_admin_1');
Route::get('/rt/sm27/senarai-sah-mohon-masuk-tabika-admin',                'RT_SM27Controller@senarai_sah_mohon_masuk_tabika_admin')->name('rt-sm27.senarai_sah_mohon_masuk_tabika_admin');
Route::get('/rt/sm27/sah-mohon-masuk-tabika-admin',                        'RT_SM27Controller@sah_mohon_masuk_tabika_admin')->name('rt-sm27.sah_mohon_masuk_tabika_admin');
Route::get('/rt/sm27/sah-mohon-masuk-tabika-admin-1',                    'RT_SM27Controller@sah_mohon_masuk_tabika_admin_1')->name('rt-sm27.sah_mohon_masuk_tabika_admin_1');
Route::get('/rt/sm27/senarai-lulus-mohon-masuk-tabika-admin',            'RT_SM27Controller@senarai_lulus_mohon_masuk_tabika_admin')->name('rt-sm27.senarai_lulus_mohon_masuk_tabika_admin');
Route::get('/rt/sm27/lulus-mohon-masuk-tabika-admin',                    'RT_SM27Controller@lulus_mohon_masuk_tabika_admin')->name('rt-sm27.lulus_mohon_masuk_tabika_admin');
Route::get('/rt/sm27/lulus-mohon-masuk-tabika-admin-1',                    'RT_SM27Controller@lulus_mohon_masuk_tabika_admin_1')->name('rt-sm27.lulus_mohon_masuk_tabika_admin_1');
Route::get('/rt/sm27/senarai-masuk-tabika-admin',                        'RT_SM27Controller@senarai_masuk_tabika_admin')->name('rt-sm27.senarai_masuk_tabika_admin');
Route::get('/rt/sm27/laporan-bil-murid-negeri-admin',                    'RT_SM27Controller@laporan_bil_murid_negeri_admin')->name('rt-sm27.laporan_bil_murid_negeri_admin');
Route::get('/rt/sm27/laporan-bil-murid-kaum-admin',                        'RT_SM27Controller@laporan_bil_murid_kaum_admin')->name('rt-sm27.laporan_bil_murid_kaum_admin');

/* Modul Laporan - Modul 30 : Laporan KRT */
Route::get('/rt/sm30/laporan-maklumat-asas-krt-ppd',                    'RT_SM30Controller@laporan_maklumat_asas_krt_ppd')->name('rt-sm30.laporan_maklumat_asas_krt_ppd');
Route::get('/rt/sm30/laporan-maklumat-asas-krt-ppn',                    'RT_SM30Controller@laporan_maklumat_asas_krt_ppn')->name('rt-sm30.laporan_maklumat_asas_krt_ppn');
Route::get('/rt/sm30/laporan-maklumat-asas-krt-hqrt',                    'RT_SM30Controller@laporan_maklumat_asas_krt_hqrt')->name('rt-sm30.laporan_maklumat_asas_krt_hqrt');
Route::get('/rt/sm30/laporan-maklumat-asas-krt-kp',                        'RT_SM30Controller@laporan_maklumat_asas_krt_kp')->name('rt-sm30.laporan_maklumat_asas_krt_kp');

Route::get('/rt/sm30/laporan-maklumat-asas-krt-2-ppd',                    'RT_SM30Controller@laporan_maklumat_asas_krt_2_ppd')->name('rt-sm30.laporan_maklumat_asas_krt_2_ppd');
Route::get('/rt/sm30/laporan-maklumat-asas-krt-2-ppn',                    'RT_SM30Controller@laporan_maklumat_asas_krt_2_ppn')->name('rt-sm30.laporan_maklumat_asas_krt_2_ppn');
Route::get('/rt/sm30/laporan-maklumat-asas-krt-2-hqrt',                    'RT_SM30Controller@laporan_maklumat_asas_krt_2_hqrt')->name('rt-sm30.laporan_maklumat_asas_krt_2_hqrt');
Route::get('/rt/sm30/laporan-maklumat-asas-krt-2-kp',                    'RT_SM30Controller@laporan_maklumat_asas_krt_2_kp')->name('rt-sm30.laporan_maklumat_asas_krt_2_kp');

Route::get('/rt/sm30/laporan-maklumat-asas-krt-3-ppd',                    'RT_SM30Controller@laporan_maklumat_asas_krt_3_ppd')->name('rt-sm30.laporan_maklumat_asas_krt_3_ppd');
Route::get('/rt/sm30/laporan-maklumat-asas-krt-3-ppn',                    'RT_SM30Controller@laporan_maklumat_asas_krt_3_ppn')->name('rt-sm30.laporan_maklumat_asas_krt_3_ppn');
Route::get('/rt/sm30/laporan-maklumat-asas-krt-3-hqrt',                    'RT_SM30Controller@laporan_maklumat_asas_krt_3_hqrt')->name('rt-sm30.laporan_maklumat_asas_krt_3_hqrt');
Route::get('/rt/sm30/laporan-maklumat-asas-krt-3-kp',                    'RT_SM30Controller@laporan_maklumat_asas_krt_3_kp')->name('rt-sm30.laporan_maklumat_asas_krt_3_kp');

Route::get('/rt/sm30/laporan-maklumat-asas-krt-4-ppd',                    'RT_SM30Controller@laporan_maklumat_asas_krt_4_ppd')->name('rt-sm30.laporan_maklumat_asas_krt_4_ppd');
Route::get('/rt/sm30/laporan-maklumat-asas-krt-4-ppn',                    'RT_SM30Controller@laporan_maklumat_asas_krt_4_ppn')->name('rt-sm30.laporan_maklumat_asas_krt_4_ppn');
Route::get('/rt/sm30/laporan-maklumat-asas-krt-4-hqrt',                    'RT_SM30Controller@laporan_maklumat_asas_krt_4_hqrt')->name('rt-sm30.laporan_maklumat_asas_krt_4_hqrt');
Route::get('/rt/sm30/laporan-maklumat-asas-krt-4-kp',                    'RT_SM30Controller@laporan_maklumat_asas_krt_4_kp')->name('rt-sm30.laporan_maklumat_asas_krt_4_kp');

Route::get('/rt/sm30/laporan-aktiviti-rt-ppd',                            'RT_SM30Controller@laporan_aktiviti_rt_ppd')->name('rt-sm30.laporan_aktiviti_rt_ppd');
Route::get('/rt/sm30/laporan-aktiviti-rt-ppn',                            'RT_SM30Controller@laporan_aktiviti_rt_ppn')->name('rt-sm30.laporan_aktiviti_rt_ppn');
Route::get('/rt/sm30/laporan-aktiviti-rt-hqrt',                            'RT_SM30Controller@laporan_aktiviti_rt_hqrt')->name('rt-sm30.laporan_aktiviti_rt_hqrt');
Route::get('/rt/sm30/laporan-aktiviti-rt-kp',                            'RT_SM30Controller@laporan_aktiviti_rt_kp')->name('rt-sm30.laporan_aktiviti_rt_kp');

Route::get('/rt/sm30/laporan-aktiviti-rt-2-ppd',                        'RT_SM30Controller@laporan_aktiviti_rt_2_ppd')->name('rt-sm30.laporan_aktiviti_rt_2_ppd');
Route::get('/rt/sm30/laporan-aktiviti-rt-2-ppn',                        'RT_SM30Controller@laporan_aktiviti_rt_2_ppn')->name('rt-sm30.laporan_aktiviti_rt_2_ppn');
Route::get('/rt/sm30/laporan-aktiviti-rt-2-hqrt',                        'RT_SM30Controller@laporan_aktiviti_rt_2_hqrt')->name('rt-sm30.laporan_aktiviti_rt_2_hqrt');
Route::get('/rt/sm30/laporan-aktiviti-rt-2-kp',                            'RT_SM30Controller@laporan_aktiviti_rt_2_kp')->name('rt-sm30.laporan_aktiviti_rt_2_kp');

Route::get('/rt/sm30/laporan-ajk-krt-pengerusi',                        'RT_SM30Controller@laporan_ajk_krt_pengerusi')->name('rt-sm30.laporan_ajk_krt_pengerusi');
Route::get('/rt/sm30/laporan-ajk-krt-setiausaha',                        'RT_SM30Controller@laporan_ajk_krt_setiausaha')->name('rt-sm30.laporan_ajk_krt_setiausaha');
Route::get('/rt/sm30/laporan-ajk-krt-ppd',                                'RT_SM30Controller@laporan_ajk_krt_ppd')->name('rt-sm30.laporan_ajk_krt_ppd');
Route::get('/rt/sm30/laporan-ajk-krt-ppn',                                'RT_SM30Controller@laporan_ajk_krt_ppn')->name('rt-sm30.laporan_ajk_krt_ppn');
Route::get('/rt/sm30/laporan-ajk-krt-hqrt',                                'RT_SM30Controller@laporan_ajk_krt_hqrt')->name('rt-sm30.laporan_ajk_krt_hqrt');
Route::get('/rt/sm30/laporan-ajk-krt-kp',                                'RT_SM30Controller@laporan_ajk_krt_kp')->name('rt-sm30.laporan_ajk_krt_kp');

Route::get('/rt/sm30/laporan-ajk-krt-umur-pengerusi',                    'RT_SM30Controller@laporan_ajk_krt_umur_pengerusi')->name('rt-sm30.laporan_ajk_krt_umur_pengerusi');
Route::get('/rt/sm30/laporan-ajk-krt-umur-setiausaha',                    'RT_SM30Controller@laporan_ajk_krt_umur_setiausaha')->name('rt-sm30.laporan_ajk_krt_umur_setiausaha');
Route::get('/rt/sm30/laporan-ajk-krt-umur-ppd',                            'RT_SM30Controller@laporan_ajk_krt_umur_ppd')->name('rt-sm30.laporan_ajk_krt_umur_ppd');
Route::get('/rt/sm30/laporan-ajk-krt-umur-ppn',                            'RT_SM30Controller@laporan_ajk_krt_umur_ppn')->name('rt-sm30.laporan_ajk_krt_umur_ppn');
Route::get('/rt/sm30/laporan-ajk-krt-umur-hqrt',                        'RT_SM30Controller@laporan_ajk_krt_umur_hqrt')->name('rt-sm30.laporan_ajk_krt_umur_hqrt');
Route::get('/rt/sm30/laporan-ajk-krt-umur-kp',                            'RT_SM30Controller@laporan_ajk_krt_umur_kp')->name('rt-sm30.laporan_ajk_krt_umur_kp');

Route::get('/rt/sm30/laporan-bilangan-ajk-umur-pengerusi',                'RT_SM30Controller@laporan_bilangan_ajk_umur_pengerusi')->name('rt-sm30.laporan_bilangan_ajk_umur_pengerusi');
Route::get('/rt/sm30/laporan-bilangan-ajk-umur-setiausaha',                'RT_SM30Controller@laporan_bilangan_ajk_umur_setiausaha')->name('rt-sm30.laporan_bilangan_ajk_umur_setiausaha');
Route::get('/rt/sm30/laporan-bilangan-ajk-umur-ppd',                    'RT_SM30Controller@laporan_bilangan_ajk_umur_ppd')->name('rt-sm30.laporan_bilangan_ajk_umur_ppd');
Route::get('/rt/sm30/laporan-bilangan-ajk-umur-ppn',                    'RT_SM30Controller@laporan_bilangan_ajk_umur_ppn')->name('rt-sm30.laporan_bilangan_ajk_umur_ppn');
Route::get('/rt/sm30/laporan-bilangan-ajk-umur-hqrt',                    'RT_SM30Controller@laporan_bilangan_ajk_umur_hqrt')->name('rt-sm30.laporan_bilangan_ajk_umur_hqrt');
Route::get('/rt/sm30/laporan-bilangan-ajk-umur-kp',                        'RT_SM30Controller@laporan_bilangan_ajk_umur_kp')->name('rt-sm30.laporan_bilangan_ajk_umur_kp');

Route::get('/rt/sm30/laporan-bilangan-ajk-jawatan-pengerusi',            'RT_SM30Controller@laporan_bilangan_ajk_jawatan_pengerusi')->name('rt-sm30.laporan_bilangan_ajk_jawatan_pengerusi');
Route::get('/rt/sm30/laporan-bilangan-ajk-jawatan-setiausaha',            'RT_SM30Controller@laporan_bilangan_ajk_jawatan_setiausaha')->name('rt-sm30.laporan_bilangan_ajk_jawatan_setiausaha');
Route::get('/rt/sm30/laporan-bilangan-ajk-jawatan-ppd',                    'RT_SM30Controller@laporan_bilangan_ajk_jawatan_ppd')->name('rt-sm30.laporan_bilangan_ajk_jawatan_ppd');
Route::get('get_total_ajk_jawatan_pengerusi_ppd',                        'RT_SM30Controller@get_total_ajk_jawatan_pengerusi_ppd')->name('rt-sm30.get_total_ajk_jawatan_pengerusi_ppd');
Route::get('get_total_ajk_jawatan_tpengerusi_ppd',                        'RT_SM30Controller@get_total_ajk_jawatan_tpengerusi_ppd')->name('rt-sm30.get_total_ajk_jawatan_tpengerusi_ppd');
Route::get('get_total_ajk_jawatan_setiausaha_ppd',                        'RT_SM30Controller@get_total_ajk_jawatan_setiausaha_ppd')->name('rt-sm30.get_total_ajk_jawatan_setiausaha_ppd');
Route::get('get_total_ajk_jawatan_bendahari_ppd',                        'RT_SM30Controller@get_total_ajk_jawatan_bendahari_ppd')->name('rt-sm30.get_total_ajk_jawatan_bendahari_ppd');
Route::get('get_total_ajk_jawatan_psetiausaha_ppd',                        'RT_SM30Controller@get_total_ajk_jawatan_psetiausaha_ppd')->name('rt-sm30.get_total_ajk_jawatan_psetiausaha_ppd');
Route::get('get_total_ajk_jawatan_ajk_ppd',                                'RT_SM30Controller@get_total_ajk_jawatan_ajk_ppd')->name('rt-sm30.get_total_ajk_jawatan_ajk_ppd');
Route::get('/rt/sm30/laporan-bilangan-ajk-jawatan-ppn',                    'RT_SM30Controller@laporan_bilangan_ajk_jawatan_ppn')->name('rt-sm30.laporan_bilangan_ajk_jawatan_ppn');
Route::get('get_total_ajk_jawatan_pengerusi_ppn',                        'RT_SM30Controller@get_total_ajk_jawatan_pengerusi_ppn')->name('rt-sm30.get_total_ajk_jawatan_pengerusi_ppn');
Route::get('get_total_ajk_jawatan_tpengerusi_ppn',                        'RT_SM30Controller@get_total_ajk_jawatan_tpengerusi_ppn')->name('rt-sm30.get_total_ajk_jawatan_tpengerusi_ppn');
Route::get('get_total_ajk_jawatan_setiausaha_ppn',                        'RT_SM30Controller@get_total_ajk_jawatan_setiausaha_ppn')->name('rt-sm30.get_total_ajk_jawatan_setiausaha_ppn');
Route::get('get_total_ajk_jawatan_bendahari_ppn',                        'RT_SM30Controller@get_total_ajk_jawatan_bendahari_ppn')->name('rt-sm30.get_total_ajk_jawatan_bendahari_ppn');
Route::get('get_total_ajk_jawatan_psetiausaha_ppn',                        'RT_SM30Controller@get_total_ajk_jawatan_psetiausaha_ppn')->name('rt-sm30.get_total_ajk_jawatan_psetiausaha_ppn');
Route::get('get_total_ajk_jawatan_ajk_ppn',                                'RT_SM30Controller@get_total_ajk_jawatan_ajk_ppn')->name('rt-sm30.get_total_ajk_jawatan_ajk_ppn');
Route::get('/rt/sm30/laporan-bilangan-ajk-jawatan-hqrt',                'RT_SM30Controller@laporan_bilangan_ajk_jawatan_hqrt')->name('rt-sm30.laporan_bilangan_ajk_jawatan_hqrt');
Route::get('get_total_ajk_jawatan_pengerusi_hqrt',                        'RT_SM30Controller@get_total_ajk_jawatan_pengerusi_hqrt')->name('rt-sm30.get_total_ajk_jawatan_pengerusi_hqrt');
Route::get('get_total_ajk_jawatan_tpengerusi_hqrt',                        'RT_SM30Controller@get_total_ajk_jawatan_tpengerusi_hqrt')->name('rt-sm30.get_total_ajk_jawatan_tpengerusi_hqrt');
Route::get('get_total_ajk_jawatan_setiausaha_hqrt',                        'RT_SM30Controller@get_total_ajk_jawatan_setiausaha_hqrt')->name('rt-sm30.get_total_ajk_jawatan_setiausaha_hqrt');
Route::get('get_total_ajk_jawatan_bendahari_hqrt',                        'RT_SM30Controller@get_total_ajk_jawatan_bendahari_hqrt')->name('rt-sm30.get_total_ajk_jawatan_bendahari_hqrt');
Route::get('get_total_ajk_jawatan_psetiausaha_hqrt',                    'RT_SM30Controller@get_total_ajk_jawatan_psetiausaha_hqrt')->name('rt-sm30.get_total_ajk_jawatan_psetiausaha_hqrt');
Route::get('get_total_ajk_jawatan_ajk_hqrt',                            'RT_SM30Controller@get_total_ajk_jawatan_ajk_hqrt')->name('rt-sm30.get_total_ajk_jawatan_ajk_hqrt');
Route::get('/rt/sm30/laporan-bilangan-ajk-jawatan-kp',                    'RT_SM30Controller@laporan_bilangan_ajk_jawatan_kp')->name('rt-sm30.laporan_bilangan_ajk_jawatan_kp');
Route::get('get_total_ajk_jawatan_pengerusi_kp',                        'RT_SM30Controller@get_total_ajk_jawatan_pengerusi_kp')->name('rt-sm30.get_total_ajk_jawatan_pengerusi_kp');
Route::get('get_total_ajk_jawatan_tpengerusi_kp',                        'RT_SM30Controller@get_total_ajk_jawatan_tpengerusi_kp')->name('rt-sm30.get_total_ajk_jawatan_tpengerusi_kp');
Route::get('get_total_ajk_jawatan_setiausaha_kp',                        'RT_SM30Controller@get_total_ajk_jawatan_setiausaha_kp')->name('rt-sm30.get_total_ajk_jawatan_setiausaha_kp');
Route::get('get_total_ajk_jawatan_bendahari_kp',                        'RT_SM30Controller@get_total_ajk_jawatan_bendahari_kp')->name('rt-sm30.get_total_ajk_jawatan_bendahari_kp');
Route::get('get_total_ajk_jawatan_psetiausaha_kp',                        'RT_SM30Controller@get_total_ajk_jawatan_psetiausaha_kp')->name('rt-sm30.get_total_ajk_jawatan_psetiausaha_kp');
Route::get('get_total_ajk_jawatan_ajk_kp',                                'RT_SM30Controller@get_total_ajk_jawatan_ajk_kp')->name('rt-sm30.get_total_ajk_jawatan_ajk_kp');

Route::get('/rt/sm30/laporan-ajk-pendidikan-pengerusi',                    'RT_SM30Controller@laporan_ajk_pendidikan_pengerusi')->name('rt-sm30.laporan_ajk_pendidikan_pengerusi');
Route::get('/rt/sm30/laporan-ajk-pendidikan-setiausaha',                'RT_SM30Controller@laporan_ajk_pendidikan_setiausaha')->name('rt-sm30.laporan_ajk_pendidikan_setiausaha');
Route::get('/rt/sm30/laporan-ajk-pendidikan-ppd',                        'RT_SM30Controller@laporan_ajk_pendidikan_ppd')->name('rt-sm30.laporan_ajk_pendidikan_ppd');
Route::get('/rt/sm30/laporan-ajk-pendidikan-ppn',                        'RT_SM30Controller@laporan_ajk_pendidikan_ppn')->name('rt-sm30.laporan_ajk_pendidikan_ppn');
Route::get('/rt/sm30/laporan-ajk-pendidikan-hqrt',                        'RT_SM30Controller@laporan_ajk_pendidikan_hqrt')->name('rt-sm30.laporan_ajk_pendidikan_hqrt');
Route::get('/rt/sm30/laporan-ajk-pendidikan-kp',                        'RT_SM30Controller@laporan_ajk_pendidikan_kp')->name('rt-sm30.laporan_ajk_pendidikan_kp');

Route::get('/rt/sm30/laporan-ajk-kaum-pengerusi',                        'RT_SM30Controller@laporan_ajk_kaum_pengerusi')->name('rt-sm30.laporan_ajk_kaum_pengerusi');
Route::get('/rt/sm30/laporan-ajk-kaum-setiausaha',                        'RT_SM30Controller@laporan_ajk_kaum_setiausaha')->name('rt-sm30.laporan_ajk_kaum_setiausaha');
Route::get('/rt/sm30/laporan-ajk-kaum-ppd',                                'RT_SM30Controller@laporan_ajk_kaum_ppd')->name('rt-sm30.laporan_ajk_kaum_ppd');
Route::get('/rt/sm30/laporan-ajk-kaum-ppn',                                'RT_SM30Controller@laporan_ajk_kaum_ppn')->name('rt-sm30.laporan_ajk_kaum_ppn');
Route::get('/rt/sm30/laporan-ajk-kaum-hqrt',                            'RT_SM30Controller@laporan_ajk_kaum_hqrt')->name('rt-sm30.laporan_ajk_kaum_hqrt');
Route::get('/rt/sm30/laporan-ajk-kaum-kp',                                'RT_SM30Controller@laporan_ajk_kaum_kp')->name('rt-sm30.laporan_ajk_kaum_kp');

Route::get('/rt/sm30/laporan-ajk-pekerjaan-pengerusi',                    'RT_SM30Controller@laporan_ajk_pekerjaan_pengerusi')->name('rt-sm30.laporan_ajk_pekerjaan_pengerusi');
Route::get('/rt/sm30/laporan-ajk-pekerjaan-setiausaha',                    'RT_SM30Controller@laporan_ajk_pekerjaan_setiausaha')->name('rt-sm30.laporan_ajk_pekerjaan_setiausaha');
Route::get('/rt/sm30/laporan-ajk-pekerjaan-ppd',                        'RT_SM30Controller@laporan_ajk_pekerjaan_ppd')->name('rt-sm30.laporan_ajk_pekerjaan_ppd');
Route::get('/rt/sm30/laporan-ajk-pekerjaan-ppn',                        'RT_SM30Controller@laporan_ajk_pekerjaan_ppn')->name('rt-sm30.laporan_ajk_pekerjaan_ppn');
Route::get('/rt/sm30/laporan-ajk-pekerjaan-hqrt',                        'RT_SM30Controller@laporan_ajk_pekerjaan_hqrt')->name('rt-sm30.laporan_ajk_pekerjaan_hqrt');
Route::get('/rt/sm30/laporan-ajk-pekerjaan-kp',                            'RT_SM30Controller@laporan_ajk_pekerjaan_kp')->name('rt-sm30.laporan_ajk_pekerjaan_kp');

Route::get('/rt/sm30/laporan-ajk-jantina-pengerusi',                    'RT_SM30Controller@laporan_ajk_jantina_pengerusi')->name('rt-sm30.laporan_ajk_jantina_pengerusi');
Route::get('/rt/sm30/laporan-ajk-jantina-setiausaha',                    'RT_SM30Controller@laporan_ajk_jantina_setiausaha')->name('rt-sm30.laporan_ajk_jantina_setiausaha');
Route::get('/rt/sm30/laporan-ajk-jantina-ppd',                            'RT_SM30Controller@laporan_ajk_jantina_ppd')->name('rt-sm30.laporan_ajk_jantina_ppd');
Route::get('/rt/sm30/laporan-ajk-jantina-ppn',                            'RT_SM30Controller@laporan_ajk_jantina_ppn')->name('rt-sm30.laporan_ajk_jantina_ppn');
Route::get('/rt/sm30/laporan-ajk-jantina-hqrt',                            'RT_SM30Controller@laporan_ajk_jantina_hqrt')->name('rt-sm30.laporan_ajk_jantina_hqrt');
Route::get('/rt/sm30/laporan-ajk-jantina-kp',                            'RT_SM30Controller@laporan_ajk_jantina_kp')->name('rt-sm30.laporan_ajk_jantina_kp');

Route::get('/rt/sm30/laporan-mesyuarat-krt-ppd',                        'RT_SM30Controller@laporan_mesyuarat_krt_ppd')->name('rt-sm30.laporan_mesyuarat_krt_ppd');
Route::get('/rt/sm30/laporan-mesyuarat-krt-ppn',                        'RT_SM30Controller@laporan_mesyuarat_krt_ppn')->name('rt-sm30.laporan_mesyuarat_krt_ppn');
Route::get('/rt/sm30/laporan-mesyuarat-krt-hqrt',                        'RT_SM30Controller@laporan_mesyuarat_krt_hqrt')->name('rt-sm30.laporan_mesyuarat_krt_hqrt');
Route::get('/rt/sm30/laporan-mesyuarat-krt-kp',                            'RT_SM30Controller@laporan_mesyuarat_krt_kp')->name('rt-sm30.laporan_mesyuarat_krt_kp');

Route::get('/rt/sm30/laporan-skuad-uniti-hqrt',                            'RT_SM30Controller@laporan_skuad_uniti_hqrt')->name('rt-sm30.laporan_skuad_uniti_hqrt');


Route::get('/rt/sm30/laporan-penduduk-rt-kaum-hqrt',                    'RT_SM30Controller@laporan_penduduk_rt_kaum_hqrt')->name('rt-sm30.laporan_penduduk_rt_kaum_hqrt');
Route::get('/rt/sm30/laporan-sosio-ekonomi-rt-hqrt',                    'RT_SM30Controller@laporan_sosio_ekonomi_rt_hqrt')->name('rt-sm30.laporan_sosio_ekonomi_rt_hqrt');
Route::get('/rt/sm30/laporan-kategori-rumah-rt-hqrt',                    'RT_SM30Controller@laporan_kategori_rumah_rt_hqrt')->name('rt-sm30.laporan_kategori_rumah_rt_hqrt');
Route::get('/rt/sm30/laporan-kemudahan-rt-hqrt',                        'RT_SM30Controller@laporan_kemudahan_rt_hqrt')->name('rt-sm30.laporan_kemudahan_rt_hqrt');
Route::get('/rt/sm30/laporan-binaan-jabatan-rt-hqrt',                    'RT_SM30Controller@laporan_binaan_jabatan_rt_hqrt')->name('rt-sm30.laporan_binaan_jabatan_rt_hqrt');
Route::get('/rt/sm30/laporan-binaan-tumpang-rt-hqrt',                    'RT_SM30Controller@laporan_binaan_tumpang_rt_hqrt')->name('rt-sm30.laporan_binaan_tumpang_rt_hqrt');
Route::get('/rt/sm30/laporan-binaan-sewa-rt-hqrt',                        'RT_SM30Controller@laporan_binaan_sewa_rt_hqrt')->name('rt-sm30.laporan_binaan_sewa_rt_hqrt');
Route::get('/rt/szm30/laporan-kabin-rt-hqrt',                            'RT_SM30Controller@laporan_kabin_rt_hqrt')->name('rt-sm30.laporan_kabin_rt_hqrt');
Route::get('/rt/sm30/laporan-kekerapan-mesyuarat-rt-hqrt',                'RT_SM30Controller@laporan_kekerapan_mesyuarat_rt_hqrt')->name('rt-sm30.laporan_kekerapan_mesyuarat_rt_hqrt');
Route::get('/rt/sm30/laporan-maklumat-perbankan-rt-hqrt',                'RT_SM30Controller@laporan_maklumat_perbankan_rt_hqrt')->name('rt-sm30.laporan_maklumat_perbankan_rt_hqrt');

Route::get('/rt/sm30/get_excel_file2/negeri/{negeri}/daerah/{daerah}/agenda/{agenda}/bidang/{bidang}/kategori/{kategori}/jenis/{jenis}', 'RT_SM30Controller@get_excel_file2')->name('rt-sm30.get_excel_file2');

/* Modul Laporan - Modul 31 : Laporan SRS */
Route::get('/rt/sm31', function () {
    return redirect('dashboard/index');
});
Route::get('/rt/sm31/laporan-srs-ppd',                                    'RT_SM31Controller@laporan_srs_ppd')->name('rt-sm31.laporan_srs_ppd');
Route::get('/rt/sm31/laporan-srs-ppn',                                    'RT_SM31Controller@laporan_srs_ppn')->name('rt-sm31.laporan_srs_ppn');
Route::get('/rt/sm31/laporan-srs-hqsrs',                                'RT_SM31Controller@laporan_srs_hqsrs')->name('rt-sm31.laporan_srs_hqsrs');
Route::get('/rt/sm31/laporan-srs-hqrt',                                    'RT_SM31Controller@laporan_srs_hqrt')->name('rt-sm31.laporan_srs_hqrt');
Route::get('/rt/sm31/laporan-srs-kp',                                    'RT_SM31Controller@laporan_srs_kp')->name('rt-sm31.laporan_srs_kp');

Route::get('/rt/sm31/laporan-pembantalan-srs-ppd',                        'RT_SM31Controller@laporan_pembantalan_srs_ppd')->name('rt-sm31.laporan_pembantalan_srs_ppd');
Route::get('/rt/sm31/laporan-pembantalan-srs-ppn',                        'RT_SM31Controller@laporan_pembantalan_srs_ppn')->name('rt-sm31.laporan_pembantalan_srs_ppn');
Route::get('/rt/sm31/laporan-pembantalan-srs-hqsrs',                    'RT_SM31Controller@laporan_pembantalan_srs_hqsrs')->name('rt-sm31.laporan_pembantalan_srs_hqsrs');
Route::get('/rt/sm31/laporan-pembantalan-srs-kp',                        'RT_SM31Controller@laporan_pembantalan_srs_kp')->name('rt-sm31.laporan_pembantalan_srs_kp');

Route::get('/rt/sm31/laporan-peronda-srs-ppd',                            'RT_SM31Controller@laporan_peronda_srs_ppd')->name('rt-sm31.laporan_peronda_srs_ppd');
Route::get('/rt/sm31/laporan-peronda-srs-ppn',                            'RT_SM31Controller@laporan_peronda_srs_ppn')->name('rt-sm31.laporan_peronda_srs_ppn');
Route::get('/rt/sm31/laporan-peronda-srs-hqsrs',                        'RT_SM31Controller@laporan_peronda_srs_hqsrs')->name('rt-sm31.laporan_peronda_srs_hqsrs');
Route::get('/rt/sm31/laporan-peronda-srs-kp',                            'RT_SM31Controller@laporan_peronda_srs_kp')->name('rt-sm31.laporan_peronda_srs_kp');

Route::get('/rt/sm31/laporan-ringkasan-peronda-srs-ppd',                'RT_SM31Controller@laporan_ringkasan_peronda_srs_ppd')->name('rt-sm31.laporan_ringkasan_peronda_srs_ppd');
Route::get('/rt/sm31/laporan-ringkasan-peronda-srs-ppn',                'RT_SM31Controller@laporan_ringkasan_peronda_srs_ppn')->name('rt-sm31.laporan_ringkasan_peronda_srs_ppn');
Route::get('/rt/sm31/laporan-ringkasan-peronda-srs-hqsrs',                'RT_SM31Controller@laporan_ringkasan_peronda_srs_hqsrs')->name('rt-sm31.laporan_ringkasan_peronda_srs_hqsrs');
Route::get('/rt/sm31/laporan-ringkasan-peronda-srs-kp',                    'RT_SM31Controller@laporan_ringkasan_peronda_srs_kp')->name('rt-sm31.laporan_ringkasan_peronda_srs_kp');

Route::get('/rt/sm31/laporan-rondaan-srs-ppd',                            'RT_SM31Controller@laporan_rondaan_srs_ppd')->name('rt-sm31.laporan_rondaan_srs_ppd');
Route::get('/rt/sm31/laporan-rondaan-srs-ppn',                            'RT_SM31Controller@laporan_rondaan_srs_ppn')->name('rt-sm31.laporan_rondaan_srs_ppn');
Route::get('laporan_rondaan_srs_ppn_filter/{id}',                        'RT_SM31Controller@laporan_rondaan_srs_ppn_filter')->name('rt-sm31.laporan_rondaan_srs_ppn_filter');
Route::get('/rt/sm31/laporan-rondaan-srs-hqsrs',                        'RT_SM31Controller@laporan_rondaan_srs_hqsrs')->name('rt-sm31.laporan_rondaan_srs_hqsrs');
Route::get('laporan_rondaan_srs_hqsrs_filter/{id}',                        'RT_SM31Controller@laporan_rondaan_srs_hqsrs_filter')->name('rt-sm31.laporan_rondaan_srs_hqsrs_filter');
Route::get('/rt/sm31/laporan-rondaan-srs-kp',                            'RT_SM31Controller@laporan_rondaan_srs_kp')->name('rt-sm31.laporan_rondaan_srs_kp');
Route::get('laporan_rondaan_srs_kp_filter/{id}',                        'RT_SM31Controller@laporan_rondaan_srs_kp_filter')->name('rt-sm31.laporan_rondaan_srs_kp_filter');

Route::get('/rt/sm31/laporan-pengendalian-kes-srs-ppd',                    'RT_SM31Controller@laporan_pengendalian_kes_srs_ppd')->name('rt-sm31.laporan_pengendalian_kes_srs_ppd');
Route::get('/rt/sm31/laporan-pengendalian-kes-srs-ppn',                    'RT_SM31Controller@laporan_pengendalian_kes_srs_ppn')->name('rt-sm31.laporan_pengendalian_kes_srs_ppn');
Route::get('laporan_pengendalian_kes_srs_ppn_filter/{id}',                'RT_SM31Controller@laporan_pengendalian_kes_srs_ppn_filter')->name('rt-sm31.laporan_pengendalian_kes_srs_ppn_filter');
Route::get('/rt/sm31/laporan-pengendalian-kes-srs-hqsrs',                'RT_SM31Controller@laporan_pengendalian_kes_srs_hqsrs')->name('rt-sm31.laporan_pengendalian_kes_srs_hqsrs');
Route::get('laporan_pengendalian_kes_srs_hqsrs_filter/{id}',            'RT_SM31Controller@laporan_pengendalian_kes_srs_hqsrs_filter')->name('rt-sm31.laporan_pengendalian_kes_srs_hqsrs_filter');
Route::get('/rt/sm31/laporan-pengendalian-kes-srs-kp',                    'RT_SM31Controller@laporan_pengendalian_kes_srs_kp')->name('rt-sm31.laporan_pengendalian_kes_srs_kp');
Route::get('laporan_pengendalian_kes_srs_kp_filter/{id}',                'RT_SM31Controller@laporan_pengendalian_kes_srs_kp_filter')->name('rt-sm31.laporan_pengendalian_kes_srs_kp_filter');

/* Modul Laporan - Modul 32 : Laporan Espakat */
Route::get('/rt/sm32/laporan-ikes-isu-semasa-ppd',                        'RT_SM32Controller@laporan_ikes_isu_semasa_ppd')->name('rt-sm32.laporan_ikes_isu_semasa_ppd');
Route::get('/rt/sm32/laporan-ikes-isu-semasa-ppmk',                        'RT_SM32Controller@laporan_ikes_isu_semasa_ppmk')->name('rt-sm32.laporan_ikes_isu_semasa_ppmk');
Route::get('/rt/sm32/laporan-ikes-isu-semasa-ppn',                        'RT_SM32Controller@laporan_ikes_isu_semasa_ppn')->name('rt-sm32.laporan_ikes_isu_semasa_ppn');
Route::get('/rt/sm32/laporan-ikes-isu-semasa-bpp',                        'RT_SM32Controller@laporan_ikes_isu_semasa_bpp')->name('rt-sm32.laporan_ikes_isu_semasa_bpp');
Route::get('/rt/sm32/laporan-ikes-isu-semasa-p',                        'RT_SM32Controller@laporan_ikes_isu_semasa_p')->name('rt-sm32.laporan_ikes_isu_semasa_p');
Route::get('/rt/sm32/laporan-ikes-isu-semasa-tkpp',                        'RT_SM32Controller@laporan_ikes_isu_semasa_tkpp')->name('rt-sm32.laporan_ikes_isu_semasa_tkpp');
Route::get('/rt/sm32/laporan-ikes-isu-semasa-kp',                        'RT_SM32Controller@laporan_ikes_isu_semasa_kp')->name('rt-sm32.laporan_ikes_isu_semasa_kp');
Route::get('/rt/sm32/laporan-ikes-isu-semasa-kpn',                        'RT_SM32Controller@laporan_ikes_isu_semasa_kpn')->name('rt-sm32.laporan_ikes_isu_semasa_kpn');

Route::get('/rt/sm32/laporan-ikes-ppd',                                    'RT_SM32Controller@laporan_ikes_ppd')->name('rt-sm32.laporan_ikes_ppd');
Route::get('/rt/sm32/laporan-ikes-ppmk',                                'RT_SM32Controller@laporan_ikes_ppmk')->name('rt-sm32.laporan_ikes_ppmk');
Route::get('/rt/sm32/laporan-ikes-ppn',                                    'RT_SM32Controller@laporan_ikes_ppn')->name('rt-sm32.laporan_ikes_ppn');
Route::get('/rt/sm32/laporan-ikes-bpp',                                    'RT_SM32Controller@laporan_ikes_bpp')->name('rt-sm32.laporan_ikes_bpp');
Route::get('/rt/sm32/laporan-ikes-p',                                    'RT_SM32Controller@laporan_ikes_p')->name('rt-sm32.laporan_ikes_p');
Route::get('/rt/sm32/laporan-ikes-tkpp',                                'RT_SM32Controller@laporan_ikes_tkpp')->name('rt-sm32.laporan_ikes_tkpp');
Route::get('/rt/sm32/laporan-ikes-kp',                                    'RT_SM32Controller@laporan_ikes_kp')->name('rt-sm32.laporan_ikes_kp');
Route::get('/rt/sm32/laporan-ikes-kpn',                                    'RT_SM32Controller@laporan_ikes_kpn')->name('rt-sm32.laporan_ikes_kpn');

Route::get('/rt/sm32/laporan-imuhibbah-ppd',                            'RT_SM32Controller@laporan_imuhibbah_ppd')->name('rt-sm32.laporan_imuhibbah_ppd');
Route::get('/rt/sm32/laporan-imuhibbah-ppmk',                            'RT_SM32Controller@laporan_imuhibbah_ppmk')->name('rt-sm32.laporan_imuhibbah_ppmk');
Route::get('/rt/sm32/laporan-imuhibbah-ppn',                            'RT_SM32Controller@laporan_imuhibbah_ppn')->name('rt-sm32.laporan_imuhibbah_ppn');
Route::get('/rt/sm32/laporan-imuhibbah-bpp',                            'RT_SM32Controller@laporan_imuhibbah_bpp')->name('rt-sm32.laporan_imuhibbah_bpp');
Route::get('/rt/sm32/laporan-imuhibbah-p',                                'RT_SM32Controller@laporan_imuhibbah_p')->name('rt-sm32.laporan_imuhibbah_p');
Route::get('/rt/sm32/laporan-imuhibbah-tkpp',                            'RT_SM32Controller@laporan_imuhibbah_tkpp')->name('rt-sm32.laporan_imuhibbah_tkpp');
Route::get('/rt/sm32/laporan-imuhibbah-kp',                                'RT_SM32Controller@laporan_imuhibbah_kp')->name('rt-sm32.laporan_imuhibbah_kp');
Route::get('/rt/sm32/laporan-imuhibbah-kpn',                            'RT_SM32Controller@laporan_imuhibbah_kpn')->name('rt-sm32.laporan_imuhibbah_kpn');

Route::get('/rt/sm32/laporan-bulanan-ikes-ppd',                            'RT_SM32Controller@laporan_bulanan_ikes_ppd')->name('rt-sm32.laporan_bulanan_ikes_ppd');
Route::get('/rt/sm32/laporan-bulanan-ikes-ppn',                            'RT_SM32Controller@laporan_bulanan_ikes_ppn')->name('rt-sm32.laporan_bulanan_ikes_ppn');
Route::get('/rt/sm32/laporan-bulanan-ikes-bpp',                            'RT_SM32Controller@laporan_bulanan_ikes_bpp')->name('rt-sm32.laporan_bulanan_ikes_bpp');
Route::get('/rt/sm32/laporan-bulanan-ikes-p',                            'RT_SM32Controller@laporan_bulanan_ikes_p')->name('rt-sm32.laporan_bulanan_ikes_p');
Route::get('/rt/sm32/laporan-bulanan-ikes-tkpp',                        'RT_SM32Controller@laporan_bulanan_ikes_tkpp')->name('rt-sm32.laporan_bulanan_ikes_tkpp');
Route::get('/rt/sm32/laporan-bulanan-ikes-kp',                            'RT_SM32Controller@laporan_bulanan_ikes_kp')->name('rt-sm32.laporan_bulanan_ikes_kp');
Route::get('/rt/sm32/laporan-bulanan-ikes-kpn',                            'RT_SM32Controller@laporan_bulanan_ikes_kpn')->name('rt-sm32.laporan_bulanan_ikes_kpn');

Route::get('/rt/sm32/laporan-ikes-kategori-s-ppd',                        'RT_SM32Controller@laporan_ikes_kategori_s_ppd')->name('rt-sm32.laporan_ikes_kategori_s_ppd');
Route::get('/rt/sm32/laporan-ikes-kategori-s-ppn',                        'RT_SM32Controller@laporan_ikes_kategori_s_ppn')->name('rt-sm32.laporan_ikes_kategori_s_ppn');
Route::get('/rt/sm32/laporan-ikes-kategori-s-bpp',                        'RT_SM32Controller@laporan_ikes_kategori_s_bpp')->name('rt-sm32.laporan_ikes_kategori_s_bpp');
Route::get('/rt/sm32/laporan-ikes-kategori-s-p',                        'RT_SM32Controller@laporan_ikes_kategori_s_p')->name('rt-sm32.laporan_ikes_kategori_s_p');
Route::get('/rt/sm32/laporan-ikes-kategori-s-tkpp',                        'RT_SM32Controller@laporan_ikes_kategori_s_tkpp')->name('rt-sm32.laporan_ikes_kategori_s_tkpp');
Route::get('/rt/sm32/laporan-ikes-kategori-s-kp',                        'RT_SM32Controller@laporan_ikes_kategori_s_kp')->name('rt-sm32.laporan_ikes_kategori_s_kp');
Route::get('/rt/sm32/laporan-ikes-kategori-s-kpn',                        'RT_SM32Controller@laporan_ikes_kategori_s_kpn')->name('rt-sm32.laporan_ikes_kategori_s_kpn');

Route::get('/rt/sm32/laporan-ikes-chart-ppd',                            'RT_SM32Controller@laporan_ikes_chart_ppd')->name('rt-sm32.laporan_ikes_chart_ppd');
//ss
Route::get('laporan_ikes_chart_ppd_filter/{months}',                    'RT_SM32Controller@laporan_ikes_chart_ppd_filter')->name('rt-sm32.laporan_ikes_chart_ppd_filter');
Route::get('/rt/sm32/laporan-ikes-chart-ppn',                            'RT_SM32Controller@laporan_ikes_chart_ppn')->name('rt-sm32.laporan_ikes_chart_ppn');
Route::get('laporan_ikes_chart_ppn_filter/{months}',                    'RT_SM32Controller@laporan_ikes_chart_ppn_filter')->name('rt-sm32.laporan_ikes_chart_ppn_filter');
Route::get('/rt/sm32/laporan-ikes-chart-bpp',                            'RT_SM32Controller@laporan_ikes_chart_bpp')->name('rt-sm32.laporan_ikes_chart_bpp');
Route::get('laporan_ikes_chart_bpp_filter/{months}',                    'RT_SM32Controller@laporan_ikes_chart_bpp_filter')->name('rt-sm32.laporan_ikes_chart_bpp_filter');
Route::get('/rt/sm32/laporan-ikes-chart-p',                                'RT_SM32Controller@laporan_ikes_chart_p')->name('rt-sm32.laporan_ikes_chart_p');
Route::get('laporan_ikes_chart_p_filter/{months}',                        'RT_SM32Controller@laporan_ikes_chart_p_filter')->name('rt-sm32.laporan_ikes_chart_p_filter');
Route::get('/rt/sm32/laporan-ikes-chart-tkpp',                            'RT_SM32Controller@laporan_ikes_chart_tkpp')->name('rt-sm32.laporan_ikes_chart_tkpp');
Route::get('laporan_ikes_chart_tkpp_filter/{months}',                    'RT_SM32Controller@laporan_ikes_chart_tkpp_filter')->name('rt-sm32.laporan_ikes_chart_tkpp_filter');
Route::get('/rt/sm32/laporan-ikes-chart-kp',                            'RT_SM32Controller@laporan_ikes_chart_kp')->name('rt-sm32.laporan_ikes_chart_kp');
Route::get('laporan_ikes_chart_kp_filter/{months}',                        'RT_SM32Controller@laporan_ikes_chart_kp_filter')->name('rt-sm32.laporan_ikes_chart_kp_filter');
Route::get('/rt/sm32/laporan-ikes-chart-kpn',                            'RT_SM32Controller@laporan_ikes_chart_kpn')->name('rt-sm32.laporan_ikes_chart_kpn');
Route::get('laporan_ikes_chart_kpn_filter/{months}',                    'RT_SM32Controller@laporan_ikes_chart_kpn_filter')->name('rt-sm32.laporan_ikes_chart_kpn_filter');

Route::get('/rt/sm32/laporan-berisiko-ikes-ppd',                        'RT_SM32Controller@laporan_berisiko_ikes_ppd')->name('rt-sm32.laporan_berisiko_ikes_ppd');
Route::get('laporan_berisiko_ikes_2_ppd',                                'RT_SM32Controller@laporan_berisiko_ikes_2_ppd')->name('rt-sm32.laporan_berisiko_ikes_2_ppd');
Route::get('laporan_berisiko_ikes_3_ppd',                                'RT_SM32Controller@laporan_berisiko_ikes_3_ppd')->name('rt-sm32.laporan_berisiko_ikes_3_ppd');

Route::get('/rt/sm32/laporan-berisiko-ikes-ppn',                        'RT_SM32Controller@laporan_berisiko_ikes_ppn')->name('rt-sm32.laporan_berisiko_ikes_ppn');
Route::get('laporan_berisiko_ikes_2_ppn',                                'RT_SM32Controller@laporan_berisiko_ikes_2_ppn')->name('rt-sm32.laporan_berisiko_ikes_2_ppn');
Route::get('laporan_berisiko_ikes_3_ppn',                                'RT_SM32Controller@laporan_berisiko_ikes_3_ppn')->name('rt-sm32.laporan_berisiko_ikes_3_ppn');

Route::get('/rt/sm32/laporan-berisiko-ikes-bpp',                        'RT_SM32Controller@laporan_berisiko_ikes_bpp')->name('rt-sm32.laporan_berisiko_ikes_bpp');
Route::get('laporan_berisiko_ikes_2_bpp',                                'RT_SM32Controller@laporan_berisiko_ikes_2_bpp')->name('rt-sm32.laporan_berisiko_ikes_2_bpp');
Route::get('laporan_berisiko_ikes_3_bpp',                                'RT_SM32Controller@laporan_berisiko_ikes_3_bpp')->name('rt-sm32.laporan_berisiko_ikes_3_bpp');

Route::get('/rt/sm32/laporan-berisiko-ikes-p',                            'RT_SM32Controller@laporan_berisiko_ikes_p')->name('rt-sm32.laporan_berisiko_ikes_p');
Route::get('laporan_berisiko_ikes_2_p',                                    'RT_SM32Controller@laporan_berisiko_ikes_2_p')->name('rt-sm32.laporan_berisiko_ikes_2_p');
Route::get('laporan_berisiko_ikes_3_p',                                    'RT_SM32Controller@laporan_berisiko_ikes_3_p')->name('rt-sm32.laporan_berisiko_ikes_3_p');

Route::get('/rt/sm32/laporan-berisiko-ikes-tkpp',                        'RT_SM32Controller@laporan_berisiko_ikes_tkpp')->name('rt-sm32.laporan_berisiko_ikes_tkpp');
Route::get('laporan_berisiko_ikes_2_tkpp',                                'RT_SM32Controller@laporan_berisiko_ikes_2_tkpp')->name('rt-sm32.laporan_berisiko_ikes_2_tkpp');
Route::get('laporan_berisiko_ikes_3_tkpp',                                'RT_SM32Controller@laporan_berisiko_ikes_3_tkpp')->name('rt-sm32.laporan_berisiko_ikes_3_tkpp');

Route::get('/rt/sm32/laporan-berisiko-ikes-kp',                            'RT_SM32Controller@laporan_berisiko_ikes_kp')->name('rt-sm32.laporan_berisiko_ikes_kp');
Route::get('laporan_berisiko_ikes_2_kp',                                'RT_SM32Controller@laporan_berisiko_ikes_2_kp')->name('rt-sm32.laporan_berisiko_ikes_2_kp');
Route::get('laporan_berisiko_ikes_3_kp',                                'RT_SM32Controller@laporan_berisiko_ikes_3_kp')->name('rt-sm32.laporan_berisiko_ikes_3_kp');

Route::get('/rt/sm32/laporan-berisiko-ikes-kpn',                        'RT_SM32Controller@laporan_berisiko_ikes_knp')->name('rt-sm32.laporan_berisiko_ikes_kpn');
Route::get('laporan_berisiko_ikes_2_kpn',                                'RT_SM32Controller@laporan_berisiko_ikes_2_kpn')->name('rt-sm32.laporan_berisiko_ikes_2_kpn');
Route::get('laporan_berisiko_ikes_3_kpn',                                'RT_SM32Controller@laporan_berisiko_ikes_3_kpn')->name('rt-sm32.laporan_berisiko_ikes_3_kpn');

Route::get('/rt/sm32/laporan-ikes-kluster-ppd',                            'RT_SM32Controller@laporan_ikes_kluster_ppd')->name('rt-sm32.laporan_ikes_kluster_ppd');
Route::get('/rt/sm32/laporan-ikes-kluster-ppn',                            'RT_SM32Controller@laporan_ikes_kluster_ppn')->name('rt-sm32.laporan_ikes_kluster_ppn');
Route::get('/rt/sm32/laporan-ikes-kluster-bpp',                            'RT_SM32Controller@laporan_ikes_kluster_bpp')->name('rt-sm32.laporan_ikes_kluster_bpp');
Route::get('/rt/sm32/laporan-ikes-kluster-p',                            'RT_SM32Controller@laporan_ikes_kluster_p')->name('rt-sm32.laporan_ikes_kluster_p');
Route::get('/rt/sm32/laporan-ikes-kluster-tkpp',                        'RT_SM32Controller@laporan_ikes_kluster_tkpp')->name('rt-sm32.laporan_ikes_kluster_tkpp');
Route::get('/rt/sm32/laporan-ikes-kluster-kp',                            'RT_SM32Controller@laporan_ikes_kluster_kp')->name('rt-sm32.laporan_ikes_kluster_kp');
Route::get('/rt/sm32/laporan-ikes-kluster-kpn',                            'RT_SM32Controller@laporan_ikes_kluster_kpn')->name('rt-sm32.laporan_ikes_kluster_kpn');

Route::get('/rt/sm32/laporan-ikes-kluster-bulan-ppd',                    'RT_SM32Controller@laporan_ikes_kluster_bulan_ppd')->name('rt-sm32.laporan_ikes_kluster_bulan_ppd');
Route::get('/rt/sm32/laporan-ikes-kluster-bulan-ppn',                    'RT_SM32Controller@laporan_ikes_kluster_bulan_ppn')->name('rt-sm32.laporan_ikes_kluster_bulan_ppn');
Route::get('/rt/sm32/laporan-ikes-kluster-bulan-bpp',                    'RT_SM32Controller@laporan_ikes_kluster_bulan_bpp')->name('rt-sm32.laporan_ikes_kluster_bulan_bpp');
Route::get('/rt/sm32/laporan-ikes-kluster-bulan-p',                        'RT_SM32Controller@laporan_ikes_kluster_bulan_p')->name('rt-sm32.laporan_ikes_kluster_bulan_p');
Route::get('/rt/sm32/laporan-ikes-kluster-bulan-tkpp',                    'RT_SM32Controller@laporan_ikes_kluster_bulan_tkpp')->name('rt-sm32.laporan_ikes_kluster_bulan_tkpp');
Route::get('/rt/sm32/laporan-ikes-kluster-bulan-kp',                    'RT_SM32Controller@laporan_ikes_kluster_bulan_kp')->name('rt-sm32.laporan_ikes_kluster_bulan_kp');
Route::get('/rt/sm32/laporan-ikes-kluster-bulan-kpn',                    'RT_SM32Controller@laporan_ikes_kluster_bulan_kpn')->name('rt-sm32.laporan_ikes_kluster_bulan_kpn');

Route::get('/rt/sm32/laporan-ikes-5-ppd',                                'RT_SM32Controller@laporan_ikes_5_ppd')->name('rt-sm32.laporan_ikes_5_ppd');
Route::get('/rt/sm32/laporan-ikes-5-ppn',                                'RT_SM32Controller@laporan_ikes_5_ppn')->name('rt-sm32.laporan_ikes_5_ppn');
Route::get('/rt/sm32/laporan-ikes-5-bpp',                                'RT_SM32Controller@laporan_ikes_5_bpp')->name('rt-sm32.laporan_ikes_5_bpp');
Route::get('/rt/sm32/laporan-ikes-5-p',                                    'RT_SM32Controller@laporan_ikes_5_p')->name('rt-sm32.laporan_ikes_5_p');

Route::get('/rt/sm32/laporan-ikes-6-ppd',                                'RT_SM32Controller@laporan_ikes_6_ppd')->name('rt-sm32.laporan_ikes_6_ppd');
Route::get('/rt/sm32/laporan-ikes-6-ppn',                                'RT_SM32Controller@laporan_ikes_6_ppn')->name('rt-sm32.laporan_ikes_6_ppn');
Route::get('/rt/sm32/laporan-ikes-6-bpp',                                'RT_SM32Controller@laporan_ikes_6_bpp')->name('rt-sm32.laporan_ikes_6_bpp');
Route::get('/rt/sm32/laporan-ikes-6-p',                                    'RT_SM32Controller@laporan_ikes_6_p')->name('rt-sm32.laporan_ikes_6_p');

Route::get('/rt/sm32/laporan-ikes-7-ppd',                                'RT_SM32Controller@laporan_ikes_7_ppd')->name('rt-sm32.laporan_ikes_7_ppd');
Route::get('/rt/sm32/laporan-ikes-7-ppn',                                'RT_SM32Controller@laporan_ikes_7_ppn')->name('rt-sm32.laporan_ikes_7_ppn');
Route::get('/rt/sm32/laporan-ikes-7-bpp',                                'RT_SM32Controller@laporan_ikes_7_bpp')->name('rt-sm32.laporan_ikes_7_bpp');
Route::get('/rt/sm32/laporan-ikes-7-p',                                    'RT_SM32Controller@laporan_ikes_7_p')->name('rt-sm32.laporan_ikes_7_p');

Route::get('/rt/sm32/statistik-mk-state-ppd',                            'RT_SM32Controller@statistik_mk_state_ppd')->name('rt-sm32.statistik_mk_state_ppd');
Route::get('/rt/sm32/statistik-mk-state-ppmk',                            'RT_SM32Controller@statistik_mk_state_ppmk')->name('rt-sm32.statistik_mk_state_ppmk');
Route::get('/rt/sm32/statistik-mk-state-ppn',                            'RT_SM32Controller@statistik_mk_state_ppn')->name('rt-sm32.statistik_mk_state_ppn');
Route::get('/rt/sm32/statistik-mk-state-p',                                'RT_SM32Controller@statistik_mk_state_p')->name('rt-sm32.statistik_mk_state_p');
Route::get('/rt/sm32/statistik-mk-state-upmk',                            'RT_SM32Controller@statistik_mk_state_upmk')->name('rt-sm32.statistik_mk_state_upmk');

Route::get('/rt/sm32/statistik-mk-jantina-ppd',                            'RT_SM32Controller@statistik_mk_jantina_ppd')->name('rt-sm32.statistik_mk_jantina_ppd');
Route::get('/rt/sm32/statistik-mk-jantina-ppmk',                        'RT_SM32Controller@statistik_mk_jantina_ppmk')->name('rt-sm32.statistik_mk_jantina_ppmk');
Route::get('/rt/sm32/statistik-mk-jantina-ppn',                            'RT_SM32Controller@statistik_mk_jantina_ppn')->name('rt-sm32.statistik_mk_jantina_ppn');
Route::get('/rt/sm32/statistik-mk-jantina-p',                            'RT_SM32Controller@statistik_mk_jantina_p')->name('rt-sm32.statistik_mk_jantina_p');
Route::get('/rt/sm32/statistik-mk-jantina-upmk',                        'RT_SM32Controller@statistik_mk_jantina_upmk')->name('rt-sm32.statistik_mk_jantina_upmk');

Route::get('/rt/sm32/statistik-mk-kaum-ppd',                            'RT_SM32Controller@statistik_mk_kaum_ppd')->name('rt-sm32.statistik_mk_kaum_ppd');
Route::get('/rt/sm32/statistik-mk-kaum-ppmk',                            'RT_SM32Controller@statistik_mk_kaum_ppmk')->name('rt-sm32.statistik_mk_kaum_ppmk');
Route::get('/rt/sm32/statistik-mk-kaum-ppn',                            'RT_SM32Controller@statistik_mk_kaum_ppn')->name('rt-sm32.statistik_mk_kaum_ppn');
Route::get('/rt/sm32/statistik-mk-kaum-p',                                'RT_SM32Controller@statistik_mk_kaum_p')->name('rt-sm32.statistik_mk_kaum_p');
Route::get('/rt/sm32/statistik-mk-kaum-upmk',                            'RT_SM32Controller@statistik_mk_kaum_upmk')->name('rt-sm32.statistik_mk_kaum_upmk');

Route::get('/rt/sm32/statistik-mk-pendidikan-ppd',                        'RT_SM32Controller@statistik_mk_pendidikan_ppd')->name('rt-sm32.statistik_mk_pendidikan_ppd');
Route::get('/rt/sm32/statistik-mk-pendidikan-ppmk',                        'RT_SM32Controller@statistik_mk_pendidikan_ppmk')->name('rt-sm32.statistik_mk_pendidikan_ppmk');
Route::get('/rt/sm32/statistik-mk-pendidikan-ppn',                        'RT_SM32Controller@statistik_mk_pendidikan_ppn')->name('rt-sm32.statistik_mk_pendidikan_ppn');
Route::get('/rt/sm32/statistik-mk-pendidikan-p',                        'RT_SM32Controller@statistik_mk_pendidikan_p')->name('rt-sm32.statistik_mk_pendidikan_p');
Route::get('/rt/sm32/statistik-mk-pendidikan-upmk',                        'RT_SM32Controller@statistik_mk_pendidikan_upmk')->name('rt-sm32.statistik_mk_pendidikan_upmk');

Route::get('/rt/sm32/statistik-mk-umur-ppd',                            'RT_SM32Controller@statistik_mk_umur_ppd')->name('rt-sm32.statistik_mk_umur_ppd');
Route::get('/rt/sm32/statistik-mk-umur-ppmk',                            'RT_SM32Controller@statistik_mk_umur_ppmk')->name('rt-sm32.statistik_mk_umur_ppmk');
Route::get('/rt/sm32/statistik-mk-umur-ppn',                            'RT_SM32Controller@statistik_mk_umur_ppn')->name('rt-sm32.statistik_mk_umur_ppn');
Route::get('/rt/sm32/statistik-mk-umur-p',                                'RT_SM32Controller@statistik_mk_umur_p')->name('rt-sm32.statistik_mk_umur_p');
Route::get('/rt/sm32/statistik-mk-umur-upmk',                            'RT_SM32Controller@statistik_mk_umur_upmk')->name('rt-sm32.statistik_mk_umur_upmk');

Route::get('/rt/sm32/laporan-mk-ppd',                                    'RT_SM32Controller@laporan_mk_ppd')->name('rt-sm32.laporan_mk_ppd');
Route::get('/rt/sm32/laporan-mk-ppmk',                                    'RT_SM32Controller@laporan_mk_ppmk')->name('rt-sm32.laporan_mk_ppmk');
Route::get('/rt/sm32/laporan-mk-ppn',                                    'RT_SM32Controller@laporan_mk_ppn')->name('rt-sm32.laporan_mk_ppn');
Route::get('/rt/sm32/laporan-mk-p',                                        'RT_SM32Controller@laporan_mk_p')->name('rt-sm32.laporan_mk_p');
Route::get('/rt/sm32/laporan-mk-upmk',                                    'RT_SM32Controller@laporan_mk_upmk')->name('rt-sm32.laporan_mk_upmk');

Route::get('/rt/sm32/laporan-keaktifan-mk-ppd',                            'RT_SM32Controller@laporan_keaktifan_mk_ppd')->name('rt-sm32.laporan_keaktifan_mk_ppd');
Route::get('/rt/sm32/laporan-keaktifan-mk-ppmk',                        'RT_SM32Controller@laporan_keaktifan_mk_ppmk')->name('rt-sm32.laporan_keaktifan_mk_ppmk');
Route::get('/rt/sm32/laporan-keaktifan-mk-ppn',                            'RT_SM32Controller@laporan_keaktifan_mk_ppn')->name('rt-sm32.laporan_keaktifan_mk_ppn');
Route::get('/rt/sm32/laporan-keaktifan-mk-p',                            'RT_SM32Controller@laporan_keaktifan_mk_p')->name('rt-sm32.laporan_keaktifan_mk_p');
Route::get('/rt/sm32/laporan-keaktifan-mk-upmk',                        'RT_SM32Controller@laporan_keaktifan_mk_upmk')->name('rt-sm32.laporan_keaktifan_mk_upmk');
Route::get('/rt/sm32/laporan-keaktifan-mk-kp',                            'RT_SM32Controller@laporan_keaktifan_mk_kp')->name('rt-sm32.laporan_keaktifan_mk_kp');

Route::get('/rt/sm32/keaktifan-mkp-individu-ppd/{id}',                    'RT_SM32Controller@keaktifan_mkp_individu_ppd')->name('rt-sm32.keaktifan_mkp_individu_ppd');
Route::get('/rt/sm32/keaktifan-mkp-individu-ppmk/{id}',                    'RT_SM32Controller@keaktifan_mkp_individu_ppmk')->name('rt-sm32.keaktifan_mkp_individu_ppmk');
Route::get('/rt/sm32/keaktifan-mkp-individu-ppn/{id}',                    'RT_SM32Controller@keaktifan_mkp_individu_ppn')->name('rt-sm32.keaktifan_mkp_individu_ppn');
Route::get('/rt/sm32/keaktifan-mkp-individu-upmk/{id}',                    'RT_SM32Controller@keaktifan_mkp_individu_upmk')->name('rt-sm32.keaktifan_mkp_individu_upmk');
Route::get('/rt/sm32/keaktifan-mkp-individu-p/{id}',                    'RT_SM32Controller@keaktifan_mkp_individu_p')->name('rt-sm32.keaktifan_mkp_individu_p');
Route::get('/rt/sm32/keaktifan-mkp-individu-kp/{id}',                    'RT_SM32Controller@keaktifan_mkp_individu_kp')->name('rt-sm32.keaktifan_mkp_individu_kp');

Route::get('/rt/sm32/laporan-pelanjutan-mkp-ppd',                        'RT_SM32Controller@laporan_pelanjutan_mkp_ppd')->name('rt-sm32.laporan_pelanjutan_mkp_ppd');
Route::get('/rt/sm32/laporan-pelanjutan-mkp-ppmk',                        'RT_SM32Controller@laporan_pelanjutan_mkp_ppmk')->name('rt-sm32.laporan_pelanjutan_mkp_ppmk');
Route::get('/rt/sm32/laporan-pelanjutan-mkp-ppn',                        'RT_SM32Controller@laporan_pelanjutan_mkp_ppn')->name('rt-sm32.laporan_pelanjutan_mkp_ppn');
Route::get('/rt/sm32/laporan-pelanjutan-mkp-upmk',                        'RT_SM32Controller@laporan_pelanjutan_mkp_upmk')->name('rt-sm32.laporan_pelanjutan_mkp_upmk');
Route::get('/rt/sm32/laporan-pelanjutan-mkp-p',                            'RT_SM32Controller@laporan_pelanjutan_mkp_p')->name('rt-sm32.laporan_pelanjutan_mkp_p');

Route::get('/rt/sm32/laporan-mediasi-mkp-ppd',                            'RT_SM32Controller@laporan_mediasi_mkp_ppd')->name('rt-sm32.laporan_mediasi_mkp_ppd');
Route::get('/rt/sm32/laporan-mediasi-mkp-ppmk',                            'RT_SM32Controller@laporan_mediasi_mkp_ppmk')->name('rt-sm32.laporan_mediasi_mkp_ppmk');
Route::get('/rt/sm32/laporan-mediasi-mkp-ppn',                            'RT_SM32Controller@laporan_mediasi_mkp_ppn')->name('rt-sm32.laporan_mediasi_mkp_ppn');
Route::get('/rt/sm32/laporan-mediasi-mkp-upmk',                            'RT_SM32Controller@laporan_mediasi_mkp_upmk')->name('rt-sm32.laporan_mediasi_mkp_upmk');
Route::get('/rt/sm32/laporan-mediasi-mkp-p',                            'RT_SM32Controller@laporan_mediasi_mkp_p')->name('rt-sm32.laporan_mediasi_mkp_p');

Route::get('/rt/sm32/laporan-kluster-mediasi-mkp-ppd',                    'RT_SM32Controller@laporan_kluster_mediasi_mkp_ppd')->name('rt-sm32.laporan_kluster_mediasi_mkp_ppd');
Route::get('/rt/sm32/laporan-kluster-mediasi-mkp-ppmk',                    'RT_SM32Controller@laporan_kluster_mediasi_mkp_ppmk')->name('rt-sm32.laporan_kluster_mediasi_mkp_ppmk');
Route::get('/rt/sm32/laporan-kluster-mediasi-mkp-ppn',                    'RT_SM32Controller@laporan_kluster_mediasi_mkp_ppn')->name('rt-sm32.laporan_kluster_mediasi_mkp_ppn');
Route::get('/rt/sm32/laporan-kluster-mediasi-mkp-upmk',                    'RT_SM32Controller@laporan_kluster_mediasi_mkp_upmk')->name('rt-sm32.laporan_kluster_mediasi_mkp_upmk');
Route::get('/rt/sm32/laporan-kluster-mediasi-mkp-p',                    'RT_SM32Controller@laporan_kluster_mediasi_mkp_p')->name('rt-sm32.laporan_kluster_mediasi_mkp_p');

Route::get('/rt/sm32/laporan-kluster-mediasi-mkp-b-ppd',                'RT_SM32Controller@laporan_kluster_mediasi_mkp_b_ppd')->name('rt-sm32.laporan_kluster_mediasi_mkp_b_ppd');
Route::get('/rt/sm32/laporan-kluster-mediasi-mkp-b-ppmk',                'RT_SM32Controller@laporan_kluster_mediasi_mkp_b_ppmk')->name('rt-sm32.laporan_kluster_mediasi_mkp_b_ppmk');
Route::get('/rt/sm32/laporan-kluster-mediasi-mkp-b-ppn',                'RT_SM32Controller@laporan_kluster_mediasi_mkp_b_ppn')->name('rt-sm32.laporan_kluster_mediasi_mkp_b_ppn');
Route::get('/rt/sm32/laporan-kluster-mediasi-mkp-b-upmk',                'RT_SM32Controller@laporan_kluster_mediasi_mkp_b_upmk')->name('rt-sm32.laporan_kluster_mediasi_mkp_b_upmk');
Route::get('/rt/sm32/laporan-kluster-mediasi-mkp-b-p',                    'RT_SM32Controller@laporan_kluster_mediasi_mkp_b_p')->name('rt-sm32.laporan_kluster_mediasi_mkp_b_p');
Route::get('/rt/sm32/laporan-ikes',                                         'RT_SM32Controller@laporan_ikes')->name('rt-sm32.laporan_ikes');
Route::get('/rt/sm32/get_excel_file/negeri/{negeri?}/daerah/{daerah?}/parlimen/{parlimen?}/dun/{dun?}/start/{start?}/end/{end?}/kluster/{kluster?}',                               'RT_SM32Controller@get_excel_file')->name('rt-sm32.get_excel_file');

/* Modul Utiliti */
Route::group(['prefix' => '/pengurusan'], function () {
    Route::get('/', function () {
        return redirect('dashboard/index');
    });
    Route::get('/rujukan-data',                                     'ManagementsController@rujukan_data')->name('pengurusan.rujukan_data');
    Route::get('/peranan',                                          'ManagementsController@peranan')->name('pengurusan.peranan');
    Route::get('/pengguna',                                         'ManagementsController@pengguna')->name('pengurusan.pengguna');
    Route::get('/audit-trail',                                      'ManagementsController@audit_trail')->name('pengurusan.audit_trail');
    Route::get('/rujukan-emel',                                     'ManagementsController@rujukan_emel')->name('pengurusan.rujukan_emel');
    Route::get('/pengguna-ppd',                                     'ManagementsController@pengguna_ppd')->name('pengurusan.pengguna_ppd');

    Route::get('/pengurusan/pengguna-admin',                            'PenggunaController@pengguna_admin')->name('pengurusan.pengguna_admin');
    Route::post('post_add_pengguna_jpnin_admin',                        'PenggunaController@post_add_pengguna_jpnin_admin')->name('post_add_pengguna_jpnin_admin');



    /* Resources Pengurusan Rujukan Data */
    Route::resource('/rujukan-data/daerah',                         'RefDaerahController');
    Route::resource('/rujukan-data/parlimen',                       'RefParlimenController');
    Route::resource('/rujukan-data/dun',                            'RefDUNController');
    Route::resource('/rujukan-data/pbt',                            'RefPBTController');
    Route::resource('/rujukan-data/bandar',                         'RefBandarController');

    /* Resources Pengurusan Peranan (Roles) */
    Route::resource('/peranan/pengguna',                            'RefRolesUserController');
    Route::resource('/peranan/menu',                                'RefRolesMenuController');
    Route::resource('/peranan/akses',                               'RefRolesAccessController');

    /* Resources Pengurusan Pengguna */
    Route::resource('/pengguna/jpnin',                              'RefUsersController');
    Route::resource('/pengguna/orang_awam',                         'RefOrangAwamController');
    Route::resource('/pengguna/e_krt',                              'RefEKrtController');
    Route::resource('/pengguna/e_srs',                              'RefESrsController');
    Route::resource('/pengguna/e_sepakat',                          'RefESepakatController');

    /* Resources Pengurusan Pengguna PPD */
    Route::resource('/pengguna-ppd/orang_awam_ppd',                 'RefOrangAwamPPDController');
    Route::resource('/pengguna-ppd/krt_ppd',                        'RefKrtPPDController');
    Route::resource('/pengguna-ppd/srs_ppd',                        'RefSrsPPDController');
});

/* PDF */
Route::get('pdf/surat_pelantikan_ajk/{id}',                         'PdfController@surat_pelantikan_ajk')->name('pdf.surat_pelantikan_ajk');
Route::get('pdf/kad_keahlian/{id}',                                 'PdfController@kad_keahlian')->name('pdf.kad_keahlian');
Route::get('pdf/minit_mesyuarat/{id}',                              'PdfController@minit_mesyuarat')->name('pdf.minit_mesyuarat');
Route::get('pdf/kewangan_resit_penerimaan/{id}',                    'PdfController@kewangan_resit_penerimaan')->name('pdf.kewangan_resit_penerimaan');
Route::get('pdf/kewangan_baucer_pembayaran/{id}',                   'PdfController@kewangan_baucer_pembayaran')->name('pdf.kewangan_baucer_pembayaran');
Route::get('pdf/laporan_kewangan_rt/{id}',                          'PdfController@laporan_kewangan_rt')->name('pdf.laporan_kewangan_rt');
Route::get('pdf/laporan_kewangan_rt_pdf/krt/{krt}/bulan/{bulan}/tahun/{tahun}',                          'PdfController@laporan_kewangan_rt_pdf')->name('pdf.laporan_kewangan_rt_pdf');
Route::get('pdf/laporan_ikes_pdf/negeri/{negeri}/daerah/{daerah}/parlimen/{parlimen}/dun/{dun}/start/{start}/end/{end}/kluster/{kluster}',                          'PdfController@laporan_ikes_pdf')->name('pdf.laporan_ikes_pdf');

Route::get('pdf/laporan_aktiviti_rt_pdf/negeri/{negeri}/daerah/{daerah}/agenda/{agenda}/bidang/{bidang}/kategori/{kategori}/jenis/{jenis}', 'PdfController@laporan_aktiviti_rt_pdf')->name('pdf.laporan_aktiviti_rt_pdf');

Route::get('pdf/aktiviti_surat_perancangan_aktiviti_hq/{id}',       'PdfController@aktiviti_surat_perancangan_aktiviti_hq')->name('pdf.aktiviti_surat_perancangan_aktiviti_hq');
Route::get('pdf/perancangan_rondaan_srs/{id}',                      'PdfController@perancangan_rondaan_srs')->name('pdf.perancangan_rondaan_srs');
Route::get('pdf/notis_pembatalan_srs/{id}',                         'PdfController@notis_pembatalan_srs')->name('pdf.notis_pembatalan_srs');
Route::get('pdf/report_kewangan_krt/{id}',                          'PdfController@report_kewangan_krt')->name('pdf.report_kewangan_krt');
Route::get('pdf/notis_pembatalan_krt/{id}',                         'PdfController@notis_pembatalan_krt')->name('pdf.notis_pembatalan_krt');
Route::get('pdf/srs_kad_keahlian/{id}',                             'PdfController@srs_kad_keahlian')->name('pdf.srs_kad_keahlian');

Route::get('pdf/surat_pelantikan_mediator/{id}',                    'PdfController@surat_pelantikan_mediator')->name('pdf.surat_pelantikan_mediator');
Route::get('pdf/kad_imediator/{id}',                                'PdfController@kad_imediator')->name('pdf.kad_imediator');
Route::get('pdf/surat_pemakluman_tabika/{id}',                      'PdfController@surat_pemakluman_tabika')->name('pdf.surat_pemakluman_tabika');
Route::get('pdf/surat_pemakluman_tabika_xberjaya/{id}',             'PdfController@surat_pemakluman_tabika_xberjaya')->name('pdf.surat_pemakluman_tabika_xberjaya');
Route::get('pdf/laporan_keaktifan/state/{state}/parlimen/{parlimen}/daerah/{daerah}/dun/{dun}/krt/{krt}/tahun/{tahun}/kunci_ajk/{kunci_ajk}/kunci_aktiviti/{kunci_aktiviti}/kunci_mesyuarat/{kunci_mesyuarat}/kunci_kewangan/{kunci_kewangan}',  'PdfController@laporan_keaktifan')->name('pdf.laporan_keaktifan');
Route::get('pdf/laporan_aktiviti/{id}',                              'PdfController@laporan_aktiviti')->name('pdf.laporan_aktiviti');
/* Modul CAPTCHA */
Route::group(['prefix' => '/captcha'], function () {
    Route::get('/', function () {
        return redirect('dashboard/index');
    });
});
