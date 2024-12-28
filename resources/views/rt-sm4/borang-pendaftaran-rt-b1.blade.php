@extends('layout.master')
@section('parentPageTitle', 'HRMS')
@section('title', 'Maklumat Cadangan Ahli Jawatankuasa Rukun Tetangga Yang Mempunyai Kepentingan Dikawasan Rukun Tetangga')


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
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <small>Isi maklumat pada borang yang disediakan dibawah, dan tekan butang HANTAR. 
                        <br>
                        Ruangan bertanda <span class="text-red">*</span> adalah ruangan mandatori dan perlu diisi..&nbsp;&nbsp;<a href="#"><i class="dropdown-icon fe fe-help-circle"></i></a></small>
                    </div>                        
                </div>
            </div>
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="user-list" role="tabpanel">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                    <br><br>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="bprb_nama_krt" name="bprb_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="bprb_alamat_krt" name="bprb_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="bprb_negeri_krt" name="bprb_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="bprb_parlimen_krt" name="bprb_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="bprb_pbt_krt" name="bprb_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="bprb_daerah_krt" name="bprb_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="bprb_dun_krt" name="bprb_dun_krt"></span></b></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="#" id="form_bprb" >
                                        @csrf
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <h6><b>MAKLUMAT AHLI JAWATANKUASA</b></h6>
                                                    <br>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Penuh: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="bprb_ajk_luar_nama" id="bprb_ajk_luar_nama" placeholder="Nama Penuh">
                                                        <div class="error_bprb_ajk_luar_nama invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="bprb_ajk_luar_ic" id="bprb_ajk_luar_ic" placeholder="No Kad Pengenalan">
                                                        <div class="error_bprb_ajk_luar_ic invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Alamat: <span class="text-red">*</span></label>
                                                        <textarea class="form-control" rows="5" name="bprb_ajk_luar_alamat" id="bprb_ajk_luar_alamat" placeholder="Alamat"></textarea>
                                                        <div class="error_bprb_ajk_luar_alamat invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Kepentingan Interaksi Sosial (sila tandakan /  Jika Berkaitan): <span class="text-red">*</span></label>
                                                        <div class="custom-controls-stacked">
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" name="bprb_ajk_luar_miliki_perniagaan" value="1">
                                                                <span class="custom-control-label">(a) Memiliki perniagaan dalam kawasan</span>
                                                            </label>
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" name="bprb_ajk_luar_miliki_keluarga" value="1">
                                                                <span class="custom-control-label">(b) Ahli keluarga tingal dalam kawasan</span>
                                                            </label>
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" name="bprb_ajk_luar_miliki_pekerjaan" value="1">
                                                                <span class="custom-control-label">(c) Berkerja dalam kawasan</span>
                                                            </label>
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" name="bprb_ajk_luar_miliki_jawatan" value="1">
                                                                <span class="custom-control-label">(d) Memegang jawatan dalam Persatuan/ Pertubuhan lain dalam kawasan</span>
                                                            </label>
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" name="bprb_ajk_luar_miliki_kepentingan" value="1">
                                                                <span class="custom-control-label">(e) Lain kepentingan interaksi Sosial dengan komuniti dalam kawasan</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Keterangan lanjut mengenai kepentingan Interaksi Sosial diatas (Sila Nyatakan): <span class="text-red">*</span></label>
                                                        <textarea class="form-control" rows="5" name="bprb_ajk_luar_note" id="bprb_ajk_luar_note" placeholder="Alamat"></textarea>
                                                        <div class="error_bprb_ajk_luar_note invalid-feedback text-right"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                <br>
                                                    <input type="hidden" name="bprb_krt_profile_id" id="bprb_krt_profile_id">
                                                    <input type="hidden" name="post_borang_rt_b1" value="add">
                                                    <input type="hidden" name="action" id="post_borang_rt_b1" value="add">
                                                    <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                    <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Borang Cadangan AJK Kepentingan Di KRT&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
                                                </div>
                                            </div>
                                        </form>
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

@include('js.rt-sm4.j-borang-pendaftaran-rt-b1')