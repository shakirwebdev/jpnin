@extends('layout.master')
@section('title', 'Pelaksanaan Projek Ekonomi RT')


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
    <div class="section-body mt-3" style="display:none;" id="ppesk_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert">
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span class="text-red blink" id="ppesk_status_description" name="ppesk_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> <span id="ppesk_disemak_note" name="ppesk_disemak_note"></span><span id="ppesk_disahkan_note" name="ppesk_disahkan_note"></span>.
                                <br>
                                <input type="hidden" name="ppesk_status" id="ppesk_status">
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
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                    <br><br>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ppesk_nama_krt" name="ppesk_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ppesk_alamat_krt" name="ppesk_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="ppesk_negeri_krt" name="ppesk_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="ppesk_parlimen_krt" name="ppesk_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="ppesk_pbt_krt" name="ppesk_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="ppesk_daerah_krt" name="ppesk_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="ppesk_dun_krt" name="ppesk_dun_krt"></span></b></p>
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
                                                <form method="POST" id="form_ppesk1">
                                                @csrf
                                                    <p>1. Maklumat Projek</p>
                                                    <hr class="mt-1">
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Nama Projek: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ppesk1_projek_st_nama" id="ppesk1_projek_st_nama" placeholder="Nama Projek" >
                                                                <div class="error_ppesk1_projek_st_nama invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Kategori Projek: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ppesk1_projek_st_kategori" id="ppesk1_projek_st_kategori" placeholder="Kategori Projek" >
                                                                <div class="error_ppesk1_projek_st_kategori invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Cabaran: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ppesk1_projek_st_cabaran" id="ppesk1_projek_st_cabaran" placeholder="Cabaran" >
                                                                <div class="error_ppesk1_projek_st_cabaran invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Sumber Peruntukan/bantuan, KEWANGAN (Jabatan Peruntukan Khusus/Geran/luar) dan BUKAN KEWANGAN : <span class="text-red">*</span><br> (Nyatakan jenis modal yang diterima selain RM)</label>
                                                                <input type="text" class="form-control" name="ppesk1_projek_st_peruntukan_jabatan" id="ppesk1_projek_st_peruntukan_jabatan" placeholder="Sumber Peruntukan/bantuan, KEWANGAN (Jabatan Peruntukan Khusus/Geran/luar) dan BUKAN KEWANGAN " >
                                                                <div class="error_ppesk1_projek_st_peruntukan_jabatan invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Tahun Mula Projek: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ppesk1_projek_st_tahun" id="ppesk1_projek_st_tahun" placeholder="Tahun Mula Projek" >
                                                                <div class="error_ppesk1_projek_st_tahun invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                           <div class="form-group">
                                                                <label class="form-label">Pendapatan Kasar Sebulan (sebelum tolak modal dan komitmen): <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ppesk1_projek_st_pendapatan" id="ppesk1_projek_st_pendapatan" placeholder="Pendapatan Kasar Sebulan (sebelum tolak modal dan komitmen)" >
                                                                <div class="error_ppesk1_projek_st_pendapatan invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Perbelanjaan Keseluruhan Sebulan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ppesk1_projek_st_pembelanjaan" id="ppesk1_projek_st_pembelanjaan" placeholder="Perbelanjaan Keseluruhan Sebulan" >
                                                                <div class="error_ppesk1_projek_st_pembelanjaan invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <br>
                                                <form action="#" id="form_ppesk2">
                                                {{ csrf_field() }}
                                                    <p>2. Peserta Projek</p>
                                                    <hr class="mt-1">
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="col-md-12 alert alert-danger error_form_ppesk2" role="alert" style="display: none; padding-bottom: 0px;">
                                                                <ul></ul>
                                                            </div>
                                                            <div class="series-frame">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Nama Perserta Projek: </label>
                                                                        <input type="text" class="form-control" name="ppesk2_nama_peserta" id="ppesk2_nama_peserta" placeholder="Nama Perserta Projek">
                                                                    </div>
                                                                    <input type="hidden" name="ppesk2_pelaksanaan_projek_ekonomi_id" id="ppesk2_pelaksanaan_projek_ekonomi_id">
                                                                    <input type="hidden" name="add_maklumat_peserta" value="add">
                                                                    <button type="submit" class="btn btn-primary pull-right" id="btn_save"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                </div>
                                                            </div>
                                                            <br><br>
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_peserta_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Nama Perserta Projek</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form method="POST" id="form_ppesk3">
                                            @csrf
                                                <input type="hidden" name="ppesk3_pelaksanaan_projek_ekonomi_id" id="ppesk3_pelaksanaan_projek_ekonomi_id">
                                                <input type="hidden" name="action" id="post_pelaksanaan_projek_ekonomi_1" value="edit">
                                                <input type="hidden" name="post_pelaksanaan_projek_ekonomi_1" value="edit">
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Pelaksanaan Projek Ekonomi &nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
@stop



@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="../assets/plugins/datatable/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@stop

@include('js.rt-sm10.j-pelaksanaan-projek-ekonomi-st-krt-1')
