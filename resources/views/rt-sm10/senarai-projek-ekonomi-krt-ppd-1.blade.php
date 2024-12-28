@extends('layout.master')
@section('title', 'Projek Ekonomi RT')


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
    <div class="section-body mt-3" style="display:none;" id="psk_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert">
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span class="text-red blink" id="psk_status_description" name="psk_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> <span id="psk_disemak_note" name="psk_disemak_note"></span><span id="psk_disahkan_note" name="psk_disahkan_note"></span>.
                                <br>
                                <input type="hidden" name="psk_status" id="psk_status">
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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ppepn_nama_krt" name="ppepn_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ppepn_alamat_krt" name="ppepn_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="ppepn_negeri_krt" name="ppepn_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="ppepn_parlimen_krt" name="ppepn_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="ppepn_pbt_krt" name="ppepn_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="ppepn_daerah_krt" name="ppepn_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="ppepn_dun_krt" name="ppepn_dun_krt"></span></b></p>
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
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama projek ekonomi: </label>
                                                            <input type="text" class="form-control" name="ppepn_projek_nama" id="ppepn_projek_nama" placeholder="Nama projek ekonomi" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Penerangan ringkas mengenai projek: </label>
                                                            <textarea class="form-control" name="ppepn_projek_penerangan" id="ppepn_projek_penerangan" rows="4" placeholder="Penerangan ringkas mengenai projek" disabled></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-label">Status Pelaksanaan: </div>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" class="custom-control-input" name="ppepn_status_pelaksanaan_projek_id" value="1" disabled>
                                                                    <span class="custom-control-label">Belum Dilaksanakan</span>
                                                                </label>
                                                            </div>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" class="custom-control-input" name="ppepn_status_pelaksanaan_projek_id" value="2" disabled>
                                                                    <span class="custom-control-label">Sedang Dilaksanakan</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-label">Sekala Projek (semasa): </div>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" class="custom-control-input enable_tb" name="ppepn_sekala_project_semasa_id" value="1" disabled>
                                                                    <span class="custom-control-label">Kecil (Pendapatan RM 1000 ke bawah)</span>
                                                                </label>
                                                            </div>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" class="custom-control-input" name="ppepn_sekala_project_semasa_id" value="2" disabled>
                                                                    <span class="custom-control-label">Sederhana (Pendapatan RM 1000 - RM 3000)</span>
                                                                </label>
                                                            </div>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" class="custom-control-input" name="ppepn_sekala_project_semasa_id" value="3" disabled>
                                                                    <span class="custom-control-label">Besar (Pendapatan RM 3000 ke atas)</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-label">Sekala Projek (sasaran masa hadapan): </div>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" class="custom-control-input enable_tb" name="ppepn_sekala_project_hadapan_id" value="1" disabled>
                                                                    <span class="custom-control-label">Kecil (Pendapatan RM 1000 ke bawah)</span>
                                                                </label>
                                                            </div>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" class="custom-control-input" name="ppepn_sekala_project_hadapan_id" value="2" disabled>
                                                                    <span class="custom-control-label">Sederhana (Pendapatan RM 1000 - RM 3000)</span>
                                                                </label>
                                                            </div>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" class="custom-control-input" name="ppepn_sekala_project_hadapan_id" value="3" disabled>
                                                                    <span class="custom-control-label">Besar (Pendapatan RM 3000 ke atas)</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Jaringan kerjasama dan jenis bantuan yang diterima: </label>
                                                            <textarea class="form-control" name="ppepn_projek_jaringan" id="ppepn_projek_jaringan" rows="4" placeholder="Jaringan kerjasama dan jenis bantuan yang diterima" disabled></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Tahun mula projek: </label>
                                                            <input type="text" class="form-control" name="ppepn_projek_tahun" id="ppepn_projek_tahun" placeholder="Tahun mula projek" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Impak kepada komuniti: </label>
                                                            <input type="text" class="form-control" name="ppepn_projek_impak" id="ppepn_projek_impak" placeholder="Impak kepada komuniti" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="submit" class="btn btn-secondary" disabled>Seterusnya &nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm10.j-senarai-projek-ekonomi-krt-ppd-1')
