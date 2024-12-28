@extends('layout.master')
@section('title', 'Senarai Pelaksanaan Projek Ekonomi RT')


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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ppespn_nama_krt" name="ppespn_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ppespn_alamat_krt" name="ppespn_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="ppespn_negeri_krt" name="ppespn_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="ppespn_parlimen_krt" name="ppespn_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="ppespn_pbt_krt" name="ppespn_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="ppespn_daerah_krt" name="ppespn_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="ppespn_dun_krt" name="ppespn_dun_krt"></span></b></p>
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
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6><b>MAKLUMAT PROJEK EKONOMI RT</b></h6>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <p>1. Maklumat Projek</p>
                                                <hr class="mt-1">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama Projek: </label>
                                                            <input type="text" class="form-control" name="ppespn_projek_st_nama" id="ppespn_projek_st_nama" placeholder="Nama Projek" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Kategori Projek: </label>
                                                            <input type="text" class="form-control" name="ppespn_projek_st_kategori" id="ppespn_projek_st_kategori" placeholder="Kategori Projek" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Cabaran: </label>
                                                            <input type="text" class="form-control" name="ppespn_projek_st_cabaran" id="ppespn_projek_st_cabaran" placeholder="Cabaran" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Peruntukan Diterima (Jabatan): </label>
                                                            <input type="text" class="form-control" name="ppespn_projek_st_peruntukan_jabatan" id="ppespn_projek_st_peruntukan_jabatan" placeholder="Peruntukan Diterima" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Tahun Mula Projek: </label>
                                                            <input type="text" class="form-control" name="ppespn_projek_st_tahun" id="ppespn_projek_st_tahun" placeholder="Tahun Mula Projek" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Pendapatan Hasil Projek: </label>
                                                            <input type="text" class="form-control" name="ppespn_projek_st_pendapatan" id="ppespn_projek_st_pendapatan" placeholder="Pendapatan Hasil Projek" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Pembelanjaan Projek: </label>
                                                            <input type="text" class="form-control" name="ppespn_projek_st_pembelanjaan" id="ppespn_projek_st_pembelanjaan" placeholder="Pembelanjaan Projek" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <p>2. Peserta Projek</p>
                                                <hr class="mt-1">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="col-md-12 alert alert-danger error_form_ppesk2" role="alert" style="display: none; padding-bottom: 0px;">
                                                            <ul></ul>
                                                        </div>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_peserta_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama Perserta Projek</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="button" class="btn btn-secondary" disabled>Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm10.j-senarai-pelaksanaan-projek-ekonomi-krt-1')
