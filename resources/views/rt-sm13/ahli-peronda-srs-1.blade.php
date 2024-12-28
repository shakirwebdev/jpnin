@extends('layout.master')
@section('title', 'Ahli Peronda SRS')


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
    <div class="section-body mt-3">
        <div class="container-fluid">
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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="aps1_nama_krt" name="aps1_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="aps1_alamat_krt" name="aps1_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="aps1_negeri_krt" name="aps1_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="aps1_parlimen_krt" name="aps1_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="aps1_pbt_krt" name="aps1_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="aps1_daerah_krt" name="aps1_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="aps1_dun_krt" name="aps1_dun_krt"></span></b></p>
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
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <h6><b>MAKLUMAT AHLI PERONDA SRS</b></h6>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form action="#" id="form_aps1">
                                                @csrf
                                                    <div class="form-group">
                                                        <label class="form-label">Pekerjaan: <span class="text-red">*</span></label>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_pekerjaan_srs_table" style="width: 100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Pekerjaan</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <input type="hidden" name="aps1_srs_ahli_peronda_id" id="aps1_srs_ahli_peronda_id" >
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </form>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form action="#" id="form_aps2">
                                                @csrf
                                                    <input type="hidden" name="aps2_srs_ahli_peronda_id" id="aps2_srs_ahli_peronda_id" >
                                                    <input type="hidden" name="post_ahli_peronda_srs_1" value="edit">
                                                    <input type="hidden" name="action" id="post_ahli_peronda_srs_1" value="edit">
                                                    <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                    <button type="submit" class="btn btn-primary" id="btn_submit">Kemaskini Maklumat Ahli Peronda&nbsp;&nbsp;<i class="dropdown-icon fa fa-plus"></i></button>
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
        </div>
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
@stop

@include('js.rt-sm13.j-ahli-peronda-srs-1')
