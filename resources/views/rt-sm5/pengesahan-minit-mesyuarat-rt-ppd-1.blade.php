@extends('layout.master')
@section('title', 'Pengesahan Minit Mesyuarat Jawatankuasa')


@section('content')
@include('modal.modal-view-pekara-berbangkit-mesyuarat-krt')
@include('modal.modal-view-kertas-kerja-mesyuarat-krt')
@include('modal.modal-view-hal-lain-mesyuarat-krt')
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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pmmrp_1_nama_krt" name="pmmrp_1_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pmmrp_1_alamat_krt" name="pmmrp_1_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="pmmrp_1_negeri_krt" name="pmmrp_1_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="pmmrp_1_parlimen_krt" name="pmmrp_1_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="pmmrp_1_pbt_krt" name="pmmrp_1_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="pmmrp_1_daerah_krt" name="pmmrp_1_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="pmmrp_1_dun_krt" name="pmmrp_1_dun_krt"></span></b></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT STATUS PENGESAHAN</b></h6>
                                                <br>
                                                <form action="#" id="form_pmmrtp_1" >
                                                @csrf
                                                    <div class="form-group">
                                                        <label class="form-label">Status: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="pmmrp_1_mesyuarat_status" id="pmmrp_1_mesyuarat_status">
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            <option value="1">Disahkan</option>
                                                            <option value="4">Perlu Dikemaskini</option>
                                                        </select>
                                                        <div class="error_pmmrp_1_mesyuarat_status invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Penerangan: <span class="text-red">*</span></label>
                                                        <textarea class="form-control" name="pmmrp_1_disemak_note" id="pmmrp_1_disemak_note" rows="4"></textarea>
                                                        <div class="error_pmmrp_1_disemak_note invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group pull-right">
                                                            <input type="hidden" name="pmmrp_1_minit_mesyuarat_id" id="pmmrp_1_minit_mesyuarat_id">
                                                            <input type="hidden" name="post_pengesahan_minit_mesyuarat" value="edit">
                                                            <input type="hidden" name="action" id="post_pengesahan_minit_mesyuarat" value="edit">
                                                            <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Pengesahan Minit Mesyuarat&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
                                                        </div>
                                                    </div>
                                                </form>
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
                                                <h6><b>MAKLUMAT MINIT MESYUARAT JAWATANKUASA</b></h6>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">3. Pembentangan Penyata Kewangan Rukun Tertangga: </label>
                                                    <textarea id="pmmrp_1_mesyuarat_penyata_kewangan" name="pmmrp_1_mesyuarat_penyata_kewangan" class="form-control"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">4. Perkara-perkara Berbangkit: <label></label> </label>
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
                                                    <label class="form-label">5. Pembentangan Kertas-Kertas Kerja (jika ada)/ (Fokus Mesyuarat): </label>
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
                                                    <label class="form-label">6. Hal-Hal Lain: </label>
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
                                                    <textarea id="pmmrp_1_mesyuarat_penutup" name="pmmrp_1_mesyuarat_penutup" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <br>
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="button" class="btn btn-secondary" disabled="">Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

<link rel="stylesheet" href="../assets/plugins/datatable/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">

@stop

@include('js.rt-sm5.j-pengesahan-minit-mesyuarat-rt-ppd-1')
