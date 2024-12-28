@extends('layout.master')
@section('title', 'Jana Laporan Perancangan Aktiviti')


@section('content')
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                &nbsp;
            </div>
        </div>
    </div>
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="user-list" role="tabpanel">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-4">
                                <form method="POST" id="form_ppap2">
                                @csrf
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row clearfix">
                                                        <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                        <br><br>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ppap2_nama_krt" name="ppap2_nama_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ppap2_alamat_krt" name="ppap2_alamat_krt"></span></b></p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <p><span style="font-size:12px">Negeri</span><br><b><span id="ppap2_negeri_krt" name="ppap2_negeri_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Parlimen</span><br><b><span id="ppap2_parlimen_krt" name="ppap2_parlimen_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="ppap2_pbt_krt" name="ppap2_pbt_krt"></span></b></p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <p><span style="font-size:12px">Daerah</span><br><b><span id="ppap2_daerah_krt" name="ppap2_daerah_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Dun</span><br><b><span id="ppap2_dun_krt" name="ppap2_dun_krt"></span></b></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row clearfix">
                                                        <h6><b>MAKLUMAT TEMPAT AKTIVITI PERPADUAN</b></h6>
                                                        <br><br>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Negeri: </label>
                                                                <select class="custom-select" id="ppap2_state_id" name="ppap2_state_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($state as $item)                                    
                                                                        <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Daerah: </label>
                                                                <select class="custom-select" id="ppap2_daerah_id" name="ppap2_daerah_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($daerah as $item)                                    
                                                                        <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Tempat: </label>
                                                                <textarea class="form-control" name="ppap2_aktiviti_tempat" id="ppap2_aktiviti_tempat" rows="4" placeholder="Tempat" disabled></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="ppap2_aktiviti_kawasan_DL" value="1" disabled>
                                                                        <div class="custom-control-label">Kawasan Rukun Tetangga</div>
                                                                    </label>
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="ppap2_aktiviti_kawasan_DL" value="2" disabled>
                                                                        <div class="custom-control-label">Luar Kawasan Rukun Tetangga</div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                             <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6><b>MAKLUMAT AKTIVITI PERPADUAN</b></h6>
                                            <br>
                                            <p>2. Maklumat Penyertaan</p>
                                            <hr class="mt-1">
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form action="#" id="form_ppap3">
                                            {{ csrf_field() }}
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <br>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_penyertaan_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="6%" rowspan="2" style="background-color: #113f50"><label class="form-label"><font color="white">Bil</font></label></th>
                                                                        <th rowspan="2" style="background-color: #113f50"><label class="form-label"><font color="white">Kaum</font></label></th>
                                                                        <th colspan="2" style="background-color: #113f50"><label class="form-label text-center"><font color="white">Jantina</font></label></th>
                                                                        <th colspan="7" style="background-color: #113f50"><label class="form-label text-center"><font color="white">Umur</font></label></th>
                                                                        <th rowspan="2" style="background-color: #113f50"><label class="form-label"><font color="white">Jumlah (Bil. Orang)</font></label></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Lelaki</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Perempuan</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">0 - 6</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">07 - 12</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">13 - 17</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">18 - 35</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">36 - 45</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">45 - 59</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">60 Keatas</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <br>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <p>3. Rakan Perpaduan</p>
                                            <hr class="mt-1">
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form action="#" id="form_ppap4">
                                            {{ csrf_field() }}
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_rakan_perpaduan_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="6%" style="background-color: #113f50"><label class="form-label"><font color="white">Bil</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label"><font color="white">Rakan Perpaduan</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label text-center"><font color="white">Bentuk Sumbangan</font></label></th>
                                                                        <th style="background-color: #113f50"><label class="form-label text-center"><font color="white">Jumlah</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="button" class="btn btn-primary" id="btn_next">Seterusnya&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
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
@stop

@include('js.rt-sm6.j-jana-laporan-perancangan-aktiviti-krt-2')
