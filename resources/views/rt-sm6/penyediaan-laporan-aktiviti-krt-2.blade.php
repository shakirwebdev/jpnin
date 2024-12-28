@extends('layout.master')
@section('title', 'Penyediaan Laporan Aktiviti')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <small>Isi maklumat pada borang yang disediakan dibawah, dan tekan butang HANTAR. 
                        <br>
                        Ruangan bertanda <span class="text-red">*</span> adalah ruangan mandatori dan perlu diisi..&nbsp;&nbsp;<a href="#"><i class="dropdown-icon fe fe-help-circle"></i></a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-body mt-3" style="display:none;" id="plak_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span class="text-red blink" id="plak_status_description" name="plak_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> <span id="plak_disahkan_note" name="plak_disahkan_note"></span></span>.
                                <br>
                                <input type="hidden" name="plak_status" id="plak_status">
                            </div>
                        </div>
                    </div>
                </div>
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
                                <form method="POST" id="form_plak2">
                                @csrf
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row clearfix">
                                                        <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                        <br><br>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="plak2_nama_krt" name="plak2_nama_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="plak2_alamat_krt" name="plak2_alamat_krt"></span></b></p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <p><span style="font-size:12px">Negeri</span><br><b><span id="plak2_negeri_krt" name="plak2_negeri_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Parlimen</span><br><b><span id="plak2_parlimen_krt" name="plak2_parlimen_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="plak2_pbt_krt" name="plak2_pbt_krt"></span></b></p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <p><span style="font-size:12px">Daerah</span><br><b><span id="plak2_daerah_krt" name="plak2_daerah_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Dun</span><br><b><span id="plak2_dun_krt" name="plak2_dun_krt"></span></b></p>
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
                                                                <select class="custom-select" id="plak2_state_id" name="plak2_state_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($state as $item)                                    
                                                                        <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Daerah: </label>
                                                                <select class="custom-select" id="plak2_daerah_id" name="plak2_daerah_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($daerah as $item)                                    
                                                                        <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Tempat: </label>
                                                                <textarea class="form-control" name="plak2_aktiviti_tempat" id="plak2_aktiviti_tempat" rows="4" placeholder="Tempat" disabled></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="plak2_aktiviti_kawasan_DL" value="1" disabled>
                                                                        <div class="custom-control-label">Kawasan Rukun Tetangga</div>
                                                                    </label>
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" name="plak2_aktiviti_kawasan_DL" value="2" disabled>
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
                                            <form action="#" id="form_plak3">
                                            {{ csrf_field() }}
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="col-md-12 alert alert-danger error_form_plak3" role="alert" style="display: none; padding-bottom: 0px;">
                                                            <ul></ul>
                                                        </div>
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Komposisi Kaum: </label>
                                                                    <select class="custom-select" id="plak3_kaum_id" name="plak3_kaum_id">
                                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                        @foreach($kaum as $item)                                    
                                                                            <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Pilih Jantina: </label>
                                                                    <select class="custom-select" id="plak3_jantina_id" name="plak3_jantina_id">
                                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                        @foreach($jantina as $item)                                    
                                                                            <option value="{{ $item->id }}">{{ $item->jantina_description }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Umur: </label>
                                                                    <select class="custom-select" id="plak3_umur_id" name="plak3_umur_id">
                                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                        @foreach($umur as $item)                                    
                                                                            <option value="{{ $item->id }}">{{ $item->umur_description }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Jumlah (Bil. Orang): </label>
                                                                    <input type="text" class="form-control" name="plak3_penyertaan_jumlah" id="plak3_penyertaan_jumlah" placeholder="Jumlah (Bil. Orang)">
                                                                </div>
                                                                <input type="hidden" name="plak3_aktiviti_laporan_id" id="plak3_aktiviti_laporan_id">
                                                                <input type="hidden" name="add_aktiviti_laporan_penyertaan" value="add">
                                                                <button type="submit" class="btn btn-primary pull-right" id="btn_save_penyertaan"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                            </div>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_penyertaan_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="6%" rowspan="2"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th rowspan="2"><label class="form-label"><font color="#113f50">Kaum</font></label></th>
                                                                        <th colspan="2"><label class="form-label text-center"><font color="#113f50">Jantina</font></label></th>
                                                                        <th colspan="7"><label class="form-label text-center"><font color="#113f50">Umur</font></label></th>
                                                                        <th rowspan="2"><label class="form-label"><font color="#113f50">Jumlah (Bil. Orang)</font></label></th>
                                                                        <th rowspan="2" width="6%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th><label class="form-label"><font color="#113f50">Lelaki</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Perempuan</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">0 - 6</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">07 - 12</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">13 - 17</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">18 - 35</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">36 - 45</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">45 - 59</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">60 Keatas</font></label></th>
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
                                            <form action="#" id="form_plak4">
                                            {{ csrf_field() }}
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="col-md-12 alert alert-danger error_form_plak4" role="alert" style="display: none; padding-bottom: 0px;">
                                                            <ul></ul>
                                                        </div>
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Rakan Perpaduan: </label>
                                                                    <select class="custom-select" id="plak4_rakan_id" name="plak4_rakan_id">
                                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                        @foreach($rakan_perpaduan as $item)                                    
                                                                            <option value="{{ $item->id }}">{{ $item->rakan_description }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Bentuk Sumbangan: </label>
                                                                    <select class="custom-select" id="plak4_sumbangan_id" name="plak4_sumbangan_id">
                                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                        @foreach($sumbangan as $item)                                    
                                                                            <option value="{{ $item->id }}">{{ $item->sumbangan_description }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Jumlah : </label>
                                                                    <input type="text" class="form-control" name="plak4_rakan_perpaduan_jumlah" id="plak4_rakan_perpaduan_jumlah" placeholder="Jumlah">
                                                                </div>
                                                                <input type="hidden" name="plak4_aktiviti_laporan_id" id="plak4_aktiviti_laporan_id">
                                                                <input type="hidden" name="add_aktiviti_laporan_rakan_perpaduan" value="add">
                                                                <button type="submit" class="btn btn-primary pull-right" id="btn_save_rakan_perpaduan"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                            </div>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_rakan_perpaduan_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="6%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Rakan Perpaduan</font></label></th>
                                                                        <th><label class="form-label text-center"><font color="#113f50">Bentuk Sumbangan</font></label></th>
                                                                        <th><label class="form-label text-center"><font color="#113f50">Jumlah</font></label></th>
                                                                        <th width="6%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
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

@include('js.rt-sm6.j-penyediaan-laporan-aktiviti-krt-2')
