@extends('layout.master')
@section('parentPageTitle', 'Sistem Maklumat Perpaduan')
@section('title', 'Dashboard')

@section('content')
<div class="for_krt">
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="row clearfix">
                @if(\Session::has('error'))
                    <div class="col-lg-12 alert alert-danger">
                        {{\Session::get('error')}}
                    </div>
                @endif
                @auth
                <div class="col-lg-12">
                    <div class="mb-4">
                        <h4>Selamat Datang, {{ Auth::user()->profile->user_fullname }}</h4>
                        <small>"Kejayaan tidak datang kepada manusia yang leka."- <a href="#">Charles Cahier</a></small>
                    </div>
					<div class="mb-4">
						<span style="font-size:18px;">
                        <b><span class="text-red blink">Pemberitahuan</span></b>
                        <large>SISMAP telah ditambahbaik. Sila Rujuk Video Tutorial di bawah bagi mendapatkan kaedah pengisian maklumat mengikut menu. :
						<br><a href="https://drive.google.com/file/d/1i-yf5ZHGFCpJXT78RMvWyH78DBE73VjD/view?usp=sharing"><span style="color:#0033FF;">1. Pengisian Profail KRT</span></a>
						<br><a href="https://drive.google.com/file/d/1k4qYaTfnvYNDJHLBJnzHo3sjdYbh7gMB/view?usp=drivesdk"><span style="color:#0033FF;">2. Kaedah Menyediakan Minit Mesyuarat KRT</span></a>
						<br><a href="https://drive.google.com/file/d/1Mlq-r-5dgEhHkIkUbNnzTi33s-PpEAeY/view?usp=sharing"><span style="color:#0033FF;">3. Kaedah Penilaian Keaktifan KRT Melalui SISMAP</span></a>
						<br><a href="https://drive.google.com/file/d/1QvoUBwzsNAy-jyLQp2sxPMGaL8wJBrY5/view?usp=sharing"><span style="color:#0033FF;">4. Kaedah Penyediaan Laporan Kewangan KRT</span></a>
						<br><a href="https://onedrive.live.com/?authkey=%21AN3MZjzLqKmTvG0&id=7900AFD42354FEAF%21142304&cid=7900AFD42354FEAF"><span style="color:#0033FF;">5. Carian Notis Penetapan</span></a>
						</large>
						</span>
                    </div>
                </div>
                @else
                <div class="col-lg-12">
                    <div class="mb-4">
                        <h4>Selamat Datang,</h4>
                        <small>"Kejayaan tidak datang kepada manusia yang leka."- <a href="#">Charles Cahier</a></small>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="container-fluid">
            <div class="row clearfix row-deck">
                <div class="col-xl-6 col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Statistik Ringkas</h3>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="card bg-light">
                                      <div class="card-body">
                                        <div class="font-weight-bold">Bilangan KRT</div>
                                        <div class="py-4 m-0 text-center h1 text-success counter">{{ number_format(App\KRT_Profile::where('krt_status', 1)->count()) }}</div>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="card bg-light">
                                      <div class="card-body">
                                        <div class="font-weight-bold">Bilangan SRS</div>
                                        <div class="py-4 m-0 text-center h1 text-success counter">{{ number_format(App\SRS_Profile::where('srs_status', 1)->count()) }}</div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="card bg-light">
                                      <div class="card-body">
                                        <div class="font-weight-bold">Bilangan AJK KRT</div>
                                        <div class="py-4 m-0 text-center h1 text-success counter">{{ App\KRT_Ahli_Jawatan_Kuasa::where('ajk_status', '1')->count() }} </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="card bg-light">
                                      <div class="card-body">
                                        <div class="font-weight-bold">Bilangan Peronda SRS</div>
                                        <div class="py-4 m-0 text-center h1 text-success counter">{{ App\SRS_Ahli_Peronda::where('peronda_status', '1')->count() }}</div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bilangan KRT dan SRS Mengikut Negeri</h3>
                        </div>
                        <div class="card-body text-center">
                            <style>
                                .table td, .table th {
                                    padding: .65rem;
                                }
                            </style>
                            <table class="table table-vcenter table_custom mb-0">
                                <tbody>
                                    <tr>
                                        <td class="w40" colspan="2">
                                          <h6 class="mb-0">Negeri</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">KRT</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">SRS</h6>
                                        </td>
                                        <td class="w40" colspan="2">
                                          <h6 class="mb-0">Negeri</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">KRT</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">SRS</h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w40">
                                            <i class="flag flag-johor" data-toggle="tooltip" title="" data-original-title="Johor"></i>
                                        </td>
                                        <td class="left">
                                            <small>Johor</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\KRT_Profile::where('state_id', '01')->where('krt_status', 1)->count()) }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\SRS_Profile::join('krt__profile', 'srs__profile.krt_id', 'krt__profile.id')->where('krt__profile.state_id', '01')->count()) }}</h6>
                                        </td>
                                        <td class="w40">
                                            <i class="flag flag-penang" data-toggle="tooltip" title="" data-original-title="Pulau Pinang"></i>
                                        </td>
                                        <td class="left">
                                            <small>Pulau Pinang</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\KRT_Profile::where('state_id', '07')->where('krt_status', 1)->count()) }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\SRS_Profile::join('krt__profile', 'srs__profile.krt_id', 'krt__profile.id')->where('krt__profile.state_id', '07')->count()) }}</h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w40">
                                            <i class="flag flag-kedah" data-toggle="tooltip" title="" data-original-title="Kedah"></i>
                                        </td>
                                        <td class="left">
                                            <small>Kedah</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\KRT_Profile::where('state_id', '02')->where('krt_status', 1)->count()) }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\SRS_Profile::join('krt__profile', 'srs__profile.krt_id', 'krt__profile.id')->where('krt__profile.state_id', '02')->count()) }}</h6>
                                        </td>
                                        <td class="w40">
                                            <i class="flag flag-sabah" data-toggle="tooltip" title="" data-original-title="Sabah"></i>
                                        </td>
                                        <td class="left">
                                            <small>Sabah</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\KRT_Profile::where('state_id', '12')->where('krt_status', 1)->count()) }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\SRS_Profile::join('krt__profile', 'srs__profile.krt_id', 'krt__profile.id')->where('krt__profile.state_id', '12')->count()) }}</h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w40">
                                            <i class="flag flag-kelantan" data-toggle="tooltip" title="" data-original-title="Kelantan"></i>
                                        </td>
                                        <td class="left">
                                            <small>Kelantan</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\KRT_Profile::where('state_id', '03')->where('krt_status', 1)->count()) }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\SRS_Profile::join('krt__profile', 'srs__profile.krt_id', 'krt__profile.id')->where('krt__profile.state_id', '03')->count()) }}</h6>
                                        </td>
                                        <td class="w40">
                                            <i class="flag flag-sarawak" data-toggle="tooltip" title="" data-original-title="Sarawak"></i>
                                        </td>
                                        <td class="left">
                                            <small>Sarawak</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\KRT_Profile::where('state_id', '13')->where('krt_status', 1)->count()) }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\SRS_Profile::join('krt__profile', 'srs__profile.krt_id', 'krt__profile.id')->where('krt__profile.state_id', '13')->count()) }}</h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w40">
                                            <i class="flag flag-melaka" data-toggle="tooltip" title="" data-original-title="Melaka"></i>
                                        </td>
                                        <td class="left">
                                            <small>Melaka</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\KRT_Profile::where('state_id', '04')->where('krt_status', 1)->count()) }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\SRS_Profile::join('krt__profile', 'srs__profile.krt_id', 'krt__profile.id')->where('krt__profile.state_id', '04')->count()) }}</h6>
                                        </td>
                                        <td class="w40">
                                            <i class="flag flag-selangor" data-toggle="tooltip" title="" data-original-title="Selangor"></i>
                                        </td>
                                        <td class="left">
                                            <small>Selangor</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\KRT_Profile::where('state_id', '10')->where('krt_status', 1)->count()) }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\SRS_Profile::join('krt__profile', 'srs__profile.krt_id', 'krt__profile.id')->where('krt__profile.state_id', '10')->count()) }}</h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w40">
                                            <i class="flag flag-negeri9" data-toggle="tooltip" title="" data-original-title="Negeri Sembilan"></i>
                                        </td>
                                        <td class="left">
                                            <small>Negeri Sembilan</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\KRT_Profile::where('state_id', '05')->where('krt_status', 1)->count()) }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\SRS_Profile::join('krt__profile', 'srs__profile.krt_id', 'krt__profile.id')->where('krt__profile.state_id', '05')->count()) }}</h6>
                                        </td>
                                        <td class="w40">
                                            <i class="flag flag-terengganu" data-toggle="tooltip" title="" data-original-title="Terengganu"></i>
                                        </td>
                                        <td class="left">
                                            <small>Terengganu</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\KRT_Profile::where('state_id', '11')->where('krt_status', 1)->count()) }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\SRS_Profile::join('krt__profile', 'srs__profile.krt_id', 'krt__profile.id')->where('krt__profile.state_id', '11')->count() )}}</h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w40">
                                            <i class="flag flag-pahang" data-toggle="tooltip" title="" data-original-title="Pahang"></i>
                                        </td>
                                        <td class="left">
                                            <small>Pahang</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\KRT_Profile::where('state_id', '06')->where('krt_status', 1)->count()) }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\SRS_Profile::join('krt__profile', 'srs__profile.krt_id', 'krt__profile.id')->where('krt__profile.state_id', '06')->count()) }}</h6>
                                        </td>
                                        <td class="w40">
                                            <i class="flag flag-wp-kl" data-toggle="tooltip" title="" data-original-title="Wilayah Persekutuan Kuala Lumpur"></i>
                                        </td>
                                        <td class="left">
                                            <small>WP Kuala Lumpur</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\KRT_Profile::where('state_id', '14')->where('krt_status', 1)->count()) }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\SRS_Profile::join('krt__profile', 'srs__profile.krt_id', 'krt__profile.id')->where('krt__profile.state_id', '14')->count()) }}</h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w40">
                                            <i class="flag flag-perak" data-toggle="tooltip" title="" data-original-title="Perak"></i>
                                        </td>
                                        <td class="left">
                                            <small>Perak</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\KRT_Profile::where('state_id', '08')->where('krt_status', 1)->count()) }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\SRS_Profile::join('krt__profile', 'srs__profile.krt_id', 'krt__profile.id')->where('krt__profile.state_id', '08')->count()) }}</h6>
                                        </td>
                                        <td class="w40">
                                            <i class="flag flag-wp-labuan" data-toggle="tooltip" title="" data-original-title="Wilayah Persekutuan Labuan"></i>
                                        </td>
                                        <td class="left">
                                            <small>WP Labuan</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\KRT_Profile::where('state_id', '15')->where('krt_status', 1)->count()) }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\SRS_Profile::join('krt__profile', 'srs__profile.krt_id', 'krt__profile.id')->where('krt__profile.state_id', '15')->count()) }}</h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w40">
                                            <i class="flag flag-perlis" data-toggle="tooltip" title="" data-original-title="Perlis"></i>
                                        </td>
                                        <td class="left">
                                            <small>Perlis</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\KRT_Profile::where('state_id', '09')->where('krt_status', 1)->count()) }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\SRS_Profile::join('krt__profile', 'srs__profile.krt_id', 'krt__profile.id')->where('krt__profile.state_id', '09')->count()) }}</h6>
                                        </td>
                                        <td class="w40">
                                            <i class="flag flag-wp-putrajaya" data-toggle="tooltip" title="" data-original-title="Putrajaya"></i>
                                        </td>
                                        <td class="left">
                                            <small>WP Putrajaya</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\KRT_Profile::where('state_id', '16')->where('krt_status', 1)->count()) }}</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ number_format(App\SRS_Profile::join('krt__profile', 'srs__profile.krt_id', 'krt__profile.id')->where('krt__profile.state_id', '16')->count()) }}</h6>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="for_esepakat">
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="row clearfix">
                @if(\Session::has('error'))
                    <div class="col-lg-12 alert alert-danger">
                        {{\Session::get('error')}}
                    </div>
                @endif
                @auth
                <div class="col-lg-12">
                    <div class="mb-4">
                        <h4>Selamat Datang, {{ Auth::user()->profile->user_fullname }}</h4>
                        <small>"Kejayaan tidak datang kepada manusia yang leka."- <a href="#">Charles Cahier</a></small>
                    </div>
					<div class="mb-4">
						<span style="font-size:18px;">
                        <b><span class="text-red blink">Pemberitahuan</span></b>
                        <large>SISMAP telah ditambahbaik. Sila Rujuk Video Tutorial di bawah bagi mendapatkan kaedah pengisian maklumat mengikut menu. :
						<br><a href="https://drive.google.com/file/d/1i-yf5ZHGFCpJXT78RMvWyH78DBE73VjD/view?usp=sharing"><span style="color:#0033FF;">1. Pengisian Profail KRT</span></a>
						<br><a href="https://drive.google.com/file/d/1k4qYaTfnvYNDJHLBJnzHo3sjdYbh7gMB/view?usp=drivesdk"><span style="color:#0033FF;">2. Kaedah Menyediakan Minit Mesyuarat KRT</span></a>
						<br><a href="https://drive.google.com/file/d/1Mlq-r-5dgEhHkIkUbNnzTi33s-PpEAeY/view?usp=sharing"><span style="color:#0033FF;">3. Kaedah Penilaian Keaktifan KRT Melalui SISMAP</span></a>
						<br><a href="https://drive.google.com/file/d/1QvoUBwzsNAy-jyLQp2sxPMGaL8wJBrY5/view?usp=sharing"><span style="color:#0033FF;">4. Kaedah Penyediaan Laporan Kewangan KRT</span></a>
						<br><a href="https://onedrive.live.com/?authkey=%21AN3MZjzLqKmTvG0&id=7900AFD42354FEAF%21142304&cid=7900AFD42354FEAF"><span style="color:#0033FF;">5. Carian Notis Penetapan</span></a>
						</large>
						</span>
                    </div>
                </div>
                @else
                <div class="col-lg-12">
                    <div class="mb-4">
                        <h4>Selamat Datang,</h4>
                        <small>"Kejayaan tidak datang kepada manusia yang leka."- <a href="#">Charles Cahier</a></small>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="container-fluid">
            <div class="row clearfix row-deck">
                <div class="col-xl-6 col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Statistik Ringkas</h3>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="card bg-light">
                                      <div class="card-body">
                                        <div class="font-weight-bold">JUMLAH KESELURUHAN i-KES</div>
                                        <div class="py-4 m-0 text-center h1 text-success counter"><span id="dashboard_total_ikes"></span></div>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="card bg-light">
                                      <div class="card-body">
                                        <div class="font-weight-bold">JUMLAH MEDIATOR KOMUNITI</div>
                                        <div class="py-4 m-0 text-center h1 text-success counter"><span id="dashboard_total_mkp"></span></div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="card bg-light">
                                      <div class="card-body">
                                        <div class="font-weight-bold">JUMLAH KESELURUHAN i-RAMAL</div>
                                        <div class="py-4 m-0 text-center h1 text-success counter"><span id="dashboard_total_iramal"></span></div>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="card bg-light">
                                      <div class="card-body">
                                        <div class="font-weight-bold">JUMLAH KES MEDIASI</div>
                                        <div class="py-4 m-0 text-center h1 text-success counter"><span id="dashboard_total_mediasi"></span></div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bilangan i-Kes Dan Mediator Komuniti Mengikut Negeri</h3>
                        </div>
                        <div class="card-body text-center">
                            <style>
                                .table td, .table th {
                                    padding: .65rem;
                                }
                            </style>
                            <table class="table table-vcenter table_custom mb-0">
                                <tbody>
                                    <tr>
                                        <td class="w40" colspan="2">
                                          <h6 class="mb-0">Negeri</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">KES</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">MK</h6>
                                        </td>
                                        <td class="w40" colspan="2">
                                          <h6 class="mb-0">Negeri</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">KES</h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0">MK</h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w40">
                                            <i class="flag flag-johor" data-toggle="tooltip" title="" data-original-title="Johor"></i>
                                        </td>
                                        <td class="left">
                                            <small>Johor</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="dashboard_kes_s_1"></span></h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="total_mkp_s_1"></span></h6>
                                        </td>
                                        <td class="w40">
                                            <i class="flag flag-penang" data-toggle="tooltip" title="" data-original-title="Pulau Pinang"></i>
                                        </td>
                                        <td class="left">
                                            <small>Pulau Pinang</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="dashboard_kes_s_7"></span></h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="total_mkp_s_7"></span></h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w40">
                                            <i class="flag flag-kedah" data-toggle="tooltip" title="" data-original-title="Kedah"></i>
                                        </td>
                                        <td class="left">
                                            <small>Kedah</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="dashboard_kes_s_2"></span></h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="total_mkp_s_2"></span></h6>
                                        </td>
                                        <td class="w40">
                                            <i class="flag flag-sabah" data-toggle="tooltip" title="" data-original-title="Sabah"></i>
                                        </td>
                                        <td class="left">
                                            <small>Sabah</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="dashboard_kes_s_12"></span></h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="total_mkp_s_12"></span></h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w40">
                                            <i class="flag flag-kelantan" data-toggle="tooltip" title="" data-original-title="Kelantan"></i>
                                        </td>
                                        <td class="left">
                                            <small>Kelantan</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="dashboard_kes_s_3"></span></h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="total_mkp_s_3"></span></h6>
                                        </td>
                                        <td class="w40">
                                            <i class="flag flag-sarawak" data-toggle="tooltip" title="" data-original-title="Sarawak"></i>
                                        </td>
                                        <td class="left">
                                            <small>Sarawak</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="dashboard_kes_s_13"></span></h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="total_mkp_s_13"></span></h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w40">
                                            <i class="flag flag-melaka" data-toggle="tooltip" title="" data-original-title="Melaka"></i>
                                        </td>
                                        <td class="left">
                                            <small>Melaka</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="dashboard_kes_s_4"></span></h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="total_mkp_s_4"></span></h6>
                                        </td>
                                        <td class="w40">
                                            <i class="flag flag-selangor" data-toggle="tooltip" title="" data-original-title="Selangor"></i>
                                        </td>
                                        <td class="left">
                                            <small>Selangor</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="dashboard_kes_s_10"></span></h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="total_mkp_s_10"></span></h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w40">
                                            <i class="flag flag-negeri9" data-toggle="tooltip" title="" data-original-title="Negeri Sembilan"></i>
                                        </td>
                                        <td class="left">
                                            <small>Negeri Sembilan</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="dashboard_kes_s_5"></span></h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="total_mkp_s_5"></span></h6>
                                        </td>
                                        <td class="w40">
                                            <i class="flag flag-terengganu" data-toggle="tooltip" title="" data-original-title="Terengganu"></i>
                                        </td>
                                        <td class="left">
                                            <small>Terengganu</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="dashboard_kes_s_11"></span></h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="total_mkp_s_11"></span></h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w40">
                                            <i class="flag flag-pahang" data-toggle="tooltip" title="" data-original-title="Pahang"></i>
                                        </td>
                                        <td class="left">
                                            <small>Pahang</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="dashboard_kes_s_6"></span></h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="total_mkp_s_6"></span></h6>
                                        </td>
                                        <td class="w40">
                                            <i class="flag flag-wp-kl" data-toggle="tooltip" title="" data-original-title="Wilayah Persekutuan Kuala Lumpur"></i>
                                        </td>
                                        <td class="left">
                                            <small>WP Kuala Lumpur</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="dashboard_kes_s_14"></span></h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="total_mkp_s_14"></span></h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w40">
                                            <i class="flag flag-perak" data-toggle="tooltip" title="" data-original-title="Perak"></i>
                                        </td>
                                        <td class="left">
                                            <small>Perak</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="dashboard_kes_s_8"></span></h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="total_mkp_s_8"></span></h6>
                                        </td>
                                        <td class="w40">
                                            <i class="flag flag-wp-labuan" data-toggle="tooltip" title="" data-original-title="Wilayah Persekutuan Labuan"></i>
                                        </td>
                                        <td class="left">
                                            <small>WP Labuan</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="dashboard_kes_s_15"></span></h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="total_mkp_s_15"></span></h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w40">
                                            <i class="flag flag-perlis" data-toggle="tooltip" title="" data-original-title="Perlis"></i>
                                        </td>
                                        <td class="left">
                                            <small>Perlis</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="dashboard_kes_s_9"></span></h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="total_mkp_s_9"></span></h6>
                                        </td>
                                        <td class="w40">
                                            <i class="flag flag-wp-putrajaya" data-toggle="tooltip" title="" data-original-title="Putrajaya"></i>
                                        </td>
                                        <td class="left">
                                            <small>WP Putrajaya</small>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="dashboard_kes_s_16"></span></h6>
                                        </td>
                                        <td>
                                            <h6 class="mb-0"><span id="total_mkp_s_16"></span></h6>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
@stop

@section('page-styles')
<style>
	.blink {
        animation: blinker 1.0s linear infinite;
        color: #1c87c9;
        font-weight: bold;
        font-family: sans-serif;
    }
    @keyframes blinker {
        50% {
          opacity: 0;
        }
      }
</style>

@stop

@section('page-script')
<script src="{{ asset('assets/bundles/apexcharts.bundle.js') }}"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript"> 
    
    $(document).ready( function () {
        
        if("{{$role_users->role_users}}" == 1){
            $('.for_krt').css("display", "none");
            $('.for_esepakat').css("display", "block");
        } else {
            $('.for_krt').css("display", "block");
            $('.for_esepakat').css("display", "none");
        }
        

        /* Maklumat Statistik Ringkas */
        $('#dashboard_total_ikes').html("{{$total_ikes->total_ikes}}");
        $('#dashboard_total_iramal').html("{{$total_iramal->total_iramal}}");
        $('#dashboard_total_mkp').html("{{$total_mkp->total_mkp}}");
        $('#dashboard_total_mediasi').html("{{$total_mediasi->total_mediasi}}");

        /* Maklumat Kes Mediator */
        $('#dashboard_kes_s_1').html("{{$total_kes_s_1->total_kes_s_1}}");
        $('#dashboard_kes_s_2').html("{{$total_kes_s_2->total_kes_s_2}}");
        $('#dashboard_kes_s_3').html("{{$total_kes_s_3->total_kes_s_3}}");
        $('#dashboard_kes_s_4').html("{{$total_kes_s_4->total_kes_s_4}}");
        $('#dashboard_kes_s_5').html("{{$total_kes_s_5->total_kes_s_5}}");
        $('#dashboard_kes_s_6').html("{{$total_kes_s_6->total_kes_s_6}}");
        $('#dashboard_kes_s_7').html("{{$total_kes_s_7->total_kes_s_7}}");
        $('#dashboard_kes_s_8').html("{{$total_kes_s_8->total_kes_s_8}}");
        $('#dashboard_kes_s_9').html("{{$total_kes_s_9->total_kes_s_9}}");
        $('#dashboard_kes_s_10').html("{{$total_kes_s_10->total_kes_s_10}}");
        $('#dashboard_kes_s_11').html("{{$total_kes_s_11->total_kes_s_11}}");
        $('#dashboard_kes_s_12').html("{{$total_kes_s_12->total_kes_s_12}}");
        $('#dashboard_kes_s_13').html("{{$total_kes_s_13->total_kes_s_13}}");
        $('#dashboard_kes_s_14').html("{{$total_kes_s_14->total_kes_s_14}}");
        $('#dashboard_kes_s_15').html("{{$total_kes_s_15->total_kes_s_15}}");
        $('#dashboard_kes_s_16').html("{{$total_kes_s_16->total_kes_s_16}}");

        $('#total_mkp_s_1').html("{{$total_mkp_s_1->total_mkp_s_1}}");
        $('#total_mkp_s_2').html("{{$total_mkp_s_2->total_mkp_s_2}}");
        $('#total_mkp_s_3').html("{{$total_mkp_s_3->total_mkp_s_3}}");
        $('#total_mkp_s_4').html("{{$total_mkp_s_4->total_mkp_s_4}}");
        $('#total_mkp_s_5').html("{{$total_mkp_s_5->total_mkp_s_5}}");
        $('#total_mkp_s_6').html("{{$total_mkp_s_6->total_mkp_s_6}}");
        $('#total_mkp_s_7').html("{{$total_mkp_s_7->total_mkp_s_7}}");
        $('#total_mkp_s_8').html("{{$total_mkp_s_8->total_mkp_s_8}}");
        $('#total_mkp_s_9').html("{{$total_mkp_s_9->total_mkp_s_9}}");
        $('#total_mkp_s_10').html("{{$total_mkp_s_10->total_mkp_s_10}}");
        $('#total_mkp_s_11').html("{{$total_mkp_s_11->total_mkp_s_11}}");
        $('#total_mkp_s_12').html("{{$total_mkp_s_12->total_mkp_s_12}}");
        $('#total_mkp_s_13').html("{{$total_mkp_s_13->total_mkp_s_13}}");
        $('#total_mkp_s_14').html("{{$total_mkp_s_14->total_mkp_s_14}}");
        $('#total_mkp_s_15').html("{{$total_mkp_s_15->total_mkp_s_15}}");
        $('#total_mkp_s_16').html("{{$total_mkp_s_16->total_mkp_s_16}}");
    });
</script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
@stop
