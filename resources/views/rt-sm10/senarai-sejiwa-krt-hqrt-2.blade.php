@extends('layout.master')
@section('title', 'Profil Sejiwa')

@section('content')
@include('modal.modal-add-ahli-sejiwa')
@include('modal.modal-add-perkhidmatan-sejiwa')
@include('modal.modal-add-cabaran-sejiwa')
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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ask2_nama_krt" name="ask2_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ask2_alamat_krt" name="ask2_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="ask2_negeri_krt" name="ask2_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="ask2_parlimen_krt" name="ask2_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="ask2_pbt_krt" name="ask2_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="ask2_daerah_krt" name="ask2_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="ask2_dun_krt" name="ask2_dun_krt"></span></b></p>
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
                                                <h6><b>MAKLUMAT AM SEJIWA</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Sejiwa: </label>
                                                    <input type="text" class="form-control" name="ask2_sejiwa_nama" id="ask2_sejiwa_nama" placeholder="Nama Sejiwa" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Tarikh Penubuhan Sejiwa: </label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                        <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="ask2_sejiwa_tarikh_ditubuhkan" id="ask2_sejiwa_tarikh_ditubuhkan" placeholder="Tarikh Penubuhan Sejiwa" data-date-format="dd/mm/yyyy" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Pusat Operasi Sejiwa: </label>
                                                    <input type="text" class="form-control" name="ask2_sejiwa_pusat_operasi" id="ask2_sejiwa_pusat_operasi" placeholder="Pusat Operasi Sejiwa" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6><b>MAKLUMAT PROFIL SEJIWA</b></h6>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <p>4. Ahli Sejiwa</p>
                                                <hr class="mt-1">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_ahli_sejiwa_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">No Kad Pengenalan</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Pekerjaan</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <p>5. Bidang / Jenis Fokus Perkhidmatan SeJiwa</p>
                                                <hr class="mt-1">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_perkhidmatan_sejiwa_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Keperluan / Masalah / Isu</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Jenis Aktiviti / Perkhidmatan seJiwa (Penumpuan)</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <p>6. Pegawai Rujukan / Penyelia Sejiwa</p>
                                                <hr class="mt-1">
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama : </label>
                                                            <input type="text" class="form-control" name="psk6_sejiwa_pegawai_nama" id="psk6_sejiwa_pegawai_nama" placeholder="Nama" disabled>
                                                        </div> 
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon : </label>
                                                            <input type="text" class="form-control" name="psk6_sejiwa_pegawai_phone" id="psk6_sejiwa_pegawai_phone" placeholder="No Telefon" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Jawatan : </label>
                                                            <input type="text" class="form-control" name="psk6_sejiwa_pegawai_jawatan" id="psk6_sejiwa_pegawai_jawatan" placeholder="Jawatan" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">E-mel : </label>
                                                            <input type="text" class="form-control" name="psk6_sejiwa_pegawai_emel" id="psk6_sejiwa_pegawai_emel" placeholder="E-mel" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <p>7. Cabaran Dan Cara Menangani</p>
                                                <hr class="mt-1">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_cabaran_sejiwa_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Cabaran</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Cara Mengatasi</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="button" class="btn btn-secondary" disabled>Seterusnya &nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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
<link rel="stylesheet" href="../assets/plugins/datatable/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@stop

@include('js.rt-sm10.j-senarai-sejiwa-krt-hqrt-2')
