@extends('layout.master')
@section('title', 'Penyediaan Minit Mesyuarat Jawatankuasa')


@section('content')
@include('modal.modal-add-pekara-berbangkit-mesyuarat-krt')
@include('modal.modal-view-pekara-berbangkit-mesyuarat-krt')
@include('modal.modal-add-kertas-kerja-mesyuarat-krt')
@include('modal.modal-view-kertas-kerja-mesyuarat-krt')
@include('modal.modal-add-hal-lain-mesyuarat-krt')
@include('modal.modal-view-hal-lain-mesyuarat-krt')
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
    <div class="section-body mt-3" style="display:none;" id="pmmrt_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span class="text-red blink" id="pmmrt_status_description" name="pmmrt_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> <span id="pmmrt_disahkan_note" name="pmmrt_disahkan_note"></span></span>.
                                <br>
                                <input type="hidden" name="pmmrt_status" id="pmmrt_status">
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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pmmrt_1_nama_krt" name="pmmrt_1_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pmmrt_1_alamat_krt" name="pmmrt_1_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="pmmrt_1_negeri_krt" name="pmmrt_1_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="pmmrt_1_parlimen_krt" name="pmmrt_1_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="pmmrt_1_pbt_krt" name="pmmrt_1_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="pmmrt_1_daerah_krt" name="pmmrt_1_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="pmmrt_1_dun_krt" name="pmmrt_1_dun_krt"></span></b></p>
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
                                        <form action="#" id="form_pmmrt_1" >
                                        @csrf
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <h6><b>MAKLUMAT MINIT MESYUARAT JAWATANKUASA</b></h6>
                                                    <br>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">3. Pembentangan Penyata Kewangan Rukun Tertangga: <font color="red">*</font></label>
                                                        <textarea class="form-control" name="pmmrt_1_mesyuarat_penyata_kewangan" id="pmmrt_1_mesyuarat_penyata_kewangan" ></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">4. Perkara-perkara Berbangkit: <label><font color="red">*</font></label> </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-primary pull-right" onclick="load_add_pekara_berbangkit_mesyuarat_krt();"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                        <br><br>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_perkara_berbangkit_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Perkara</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Tindakan Yang Diambil</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">5. Pembentangan Kertas-Kertas Kerja (jika ada)/ (Fokus Mesyuarat): <font color="red">*</font></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-primary pull-right" onclick="load_add_kertas_kerja_mesyuarat_krt();"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                        <br><br>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_kertas_kerja_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Perkara</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Tindakan Yang Diambil</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">6. Hal-Hal Lain: <font color="red">*</font></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-primary pull-right" onclick="load_add_hal_lain_mesyuarat_krt();"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                        <br><br>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table thead-dark table-bordered table-striped" id="senarai_hal_lain_table" style="width: 100%" border="1">
                                                            <thead>
                                                                <tr>
                                                                    <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Perkara</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Tindakan Yang Diambil</font></label></th>
                                                                    <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Penutup: </label>
                                                        <textarea class="form-control" name="pmmrt_1_mesyuarat_penutup" id="pmmrt_1_mesyuarat_penutup" ></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <br>
                                                    <input type="hidden" name="pmmrt_1_minit_mesyuarat_id" id="pmmrt_1_minit_mesyuarat_id" >
                                                    <input type="hidden" name="post_penyediaan_minit_mesyuarat_rt_1" value="edit">
                                                    <input type="hidden" name="action" id="post_penyediaan_minit_mesyuarat_rt_1" value="edit">
                                                    <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                    <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Minit Mesyuarat&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<!-- <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"> -->

<link rel="stylesheet" href="../assets/plugins/datatable/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

@stop

@include('js.rt-sm5.j-penyediaan-minit-mesyuarat-rt-1')
