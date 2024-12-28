@extends('layout.master')
@section('parentPageTitle', 'Sistem Maklumat Perpaduan')
@section('title', 'Dashboard')


@section('content')
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
                                            <div class="py-4 m-0 text-center h1 text-success counter">0</div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="font-weight-bold">JUMLAH MEDIATOR KOMUNITI</div>
                                            <div class="py-4 m-0 text-center h1 text-success counter">0</div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="font-weight-bold">JUMLAH KESELURUHAN i-RAMAL</div>
                                            <div class="py-4 m-0 text-center h1 text-success counter">0</div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="font-weight-bold">JUMLAH KES MEDIASI</div>
                                            <div class="py-4 m-0 text-center h1 text-success counter">0</div>
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
                                <h3 class="card-title">Bilangan Kes Dan Mediator Komuniti Mengikut Negeri</h3>
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
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td class="w40">
                                                <i class="flag flag-penang" data-toggle="tooltip" title="" data-original-title="Pulau Pinang"></i>
                                            </td>
                                            <td class="left">
                                                <small>Pulau Pinang</small>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
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
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td class="w40">
                                                <i class="flag flag-sabah" data-toggle="tooltip" title="" data-original-title="Sabah"></i>
                                            </td>
                                            <td class="left">
                                                <small>Sabah</small>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
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
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td class="w40">
                                                <i class="flag flag-sarawak" data-toggle="tooltip" title="" data-original-title="Sarawak"></i>
                                            </td>
                                            <td class="left">
                                                <small>Sarawak</small>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
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
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td class="w40">
                                                <i class="flag flag-selangor" data-toggle="tooltip" title="" data-original-title="Selangor"></i>
                                            </td>
                                            <td class="left">
                                                <small>Selangor</small>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
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
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td class="w40">
                                                <i class="flag flag-terengganu" data-toggle="tooltip" title="" data-original-title="Terengganu"></i>
                                            </td>
                                            <td class="left">
                                                <small>Terengganu</small>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
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
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td class="w40">
                                                <i class="flag flag-wp-kl" data-toggle="tooltip" title="" data-original-title="Wilayah Persekutuan Kuala Lumpur"></i>
                                            </td>
                                            <td class="left">
                                                <small>WP Kuala Lumpur</small>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
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
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td class="w40">
                                                <i class="flag flag-wp-labuan" data-toggle="tooltip" title="" data-original-title="Wilayah Persekutuan Labuan"></i>
                                            </td>
                                            <td class="left">
                                                <small>WP Labuan</small>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
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
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td class="w40">
                                                <i class="flag flag-wp-putrajaya" data-toggle="tooltip" title="" data-original-title="Putrajaya"></i>
                                            </td>
                                            <td class="left">
                                                <small>WP Putrajaya</small>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-0">0</h6>
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
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@stop

@include('js.dashboard.j-dashboard')

