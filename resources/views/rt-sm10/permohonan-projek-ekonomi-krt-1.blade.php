@extends('layout.master')
@section('title', 'Permohonan Projek Ekonomi RT')


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
    <div class="section-body mt-3" style="display:none;" id="ppek_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert">
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span class="text-red blink" id="ppek_status_description" name="ppek_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> <span id="ppek_disemak_note" name="ppek_disemak_note"></span><span id="ppek_disahkan_note" name="ppek_disahkan_note"></span>.
                                <br>
                                <input type="hidden" name="ppek_status" id="ppek_status">
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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ppek_nama_krt" name="ppek_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ppek_alamat_krt" name="ppek_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="ppek_negeri_krt" name="ppek_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="ppek_parlimen_krt" name="ppek_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="ppek_pbt_krt" name="ppek_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="ppek_daerah_krt" name="ppek_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="ppek_dun_krt" name="ppek_dun_krt"></span></b></p>
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
                                                <form method="POST" id="form_ppek1">
                                                @csrf
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Nama projek ekonomi: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ppek1_projek_nama" id="ppek1_projek_nama" placeholder="Nama projek ekonomi" >
                                                                <div class="error_ppek1_projek_nama invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Penerangan ringkas mengenai projek: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" name="ppek1_projek_penerangan" id="ppek1_projek_penerangan" rows="4" placeholder="Penerangan ringkas mengenai projek"></textarea>
                                                                <div class="error_ppek1_projek_penerangan invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-label">Status Pelaksanaan: <span class="text-red">*</span></div>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" class="custom-control-input enable_tb" name="ppek1_status_pelaksanaan_projek_id" value="1">
                                                                        <span class="custom-control-label">Belum Dilaksanakan</span>
                                                                    </label>
                                                                </div>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" class="custom-control-input" name="ppek1_status_pelaksanaan_projek_id" value="2">
                                                                        <span class="custom-control-label">Sedang Dilaksanakan</span>
                                                                    </label>
                                                                </div>
                                                                <div class="error_ppek1_status_pelaksanaan_projek_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-label">Sekala Projek (semasa): <span class="text-red">*</span></div>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" class="custom-control-input enable_tb" name="ppek1_sekala_project_semasa_id" value="1">
                                                                        <span class="custom-control-label">Kecil (Pendapatan RM 1000 ke bawah)</span>
                                                                    </label>
                                                                </div>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" class="custom-control-input" name="ppek1_sekala_project_semasa_id" value="2">
                                                                        <span class="custom-control-label">Sederhana (Pendapatan RM 1000 - RM 3000)</span>
                                                                    </label>
                                                                </div>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" class="custom-control-input" name="ppek1_sekala_project_semasa_id" value="3">
                                                                        <span class="custom-control-label">Besar (Pendapatan RM 3000 ke atas)</span>
                                                                    </label>
                                                                </div>
                                                                <div class="error_ppek1_sekala_project_semasa_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-label">Sekala Projek (sasaran masa hadapan): <span class="text-red">*</span></div>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" class="custom-control-input enable_tb" name="ppek1_sekala_project_hadapan_id" value="1">
                                                                        <span class="custom-control-label">Kecil (Pendapatan RM 1000 ke bawah)</span>
                                                                    </label>
                                                                </div>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" class="custom-control-input" name="ppek1_sekala_project_hadapan_id" value="2">
                                                                        <span class="custom-control-label">Sederhana (Pendapatan RM 1000 - RM 3000)</span>
                                                                    </label>
                                                                </div>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" class="custom-control-input" name="ppek1_sekala_project_hadapan_id" value="3">
                                                                        <span class="custom-control-label">Besar (Pendapatan RM 3000 ke atas)</span>
                                                                    </label>
                                                                </div>
                                                                <div class="error_ppek1_sekala_project_hadapan_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Jaringan kerjasama dan jenis bantuan yang diterima: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" name="ppek1_projek_jaringan" id="ppek1_projek_jaringan" rows="4" placeholder="Jaringan kerjasama dan jenis bantuan yang diterima"></textarea>
                                                                <div class="error_ppek1_ppek1_projek_jaringan invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Tahun mula projek: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ppek1_projek_tahun" id="ppek1_projek_tahun" placeholder="Tahun mula projek" >
                                                                <div class="error_ppek1_projek_tahun invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Impak kepada komuniti: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ppek1_projek_impak" id="ppek1_projek_impak" placeholder="Impak kepada komuniti" >
                                                                <div class="error_ppek1_projek_impak invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form method="POST" id="form_ppek2">
                                            @csrf
                                                <input type="hidden" name="psk2_projek_ekonomi_id" id="psk2_projek_ekonomi_id">
                                                <input type="hidden" name="action" id="post_permohonan_projek_ekonomi_1" value="edit">
                                                <input type="hidden" name="post_permohonan_projek_ekonomi_1" value="edit">
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Permohonan Projek Ekonomi &nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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

@include('js.rt-sm10.j-permohonan-projek-ekonomi-krt-1')
