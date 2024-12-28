@extends('layout.master')
@section('title', 'Semakan Profil Skuad Uniti')


@section('content')
@include('modal.modal-add-biro-skuad-uniti')
@include('modal.modal-view-biro-skuad-uniti')
@include('modal.modal-add-jaringan-skuad-uniti')
@include('modal.modal-view-jaringan-skuad-uniti')
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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="spsupn_nama_krt" name="spsupn_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="spsupn_alamat_krt" name="spsupn_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="spsupn_negeri_krt" name="spsupn_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="spsupn_parlimen_krt" name="spsupn_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="spsupn_pbt_krt" name="spsupn_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="spsupn_daerah_krt" name="spsupn_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="spsupn_dun_krt" name="spsupn_dun_krt"></span></b></p>
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
                                                <h6><b>MAKLUMAT AM SKUAD UNITI</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Skuad Uniti: </label>
                                                    <input type="text" class="form-control" name="spsupn_skuad_nama" id="spsupn_skuad_nama" placeholder="Nama Skuad Uniti" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Tarikh Penubuhan Skuad: </label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                        <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="spsupn_skuad_tarikh_ditubuhkan" id="spsupn_skuad_tarikh_ditubuhkan" placeholder="Tarikh Penubuhan Skuad" data-date-format="dd/mm/yyyy" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Skop Perkhidmatan Skuad Uniti: </label>
                                                    <textarea class="form-control" name="spsupn_skuad_skop_perkhidmatan" id="spsupn_skuad_skop_perkhidmatan" rows="4" placeholder="Skop Perkhidmatan Skuad Uniti" disabled></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT STATUS MENYEMAK</b></h6>
                                                <br><br>
                                                <form method="POST" id="form_spsuk">
                                                @csrf
                                                    <div class="form-group">
                                                        <label class="form-label">Status: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="spsuk_status" id="spsuk_status">
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            <option value="6" >Disemak</option>
                                                            <option value="5" >Perlu Dikemaskini</option>
                                                        </select>
                                                        <div class="error_spsuk_status invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Penerangan: <span class="text-red">*</span></label>
                                                        <textarea class="form-control" rows="4" name="spsuk_disemak_note"id="spsuk_disemak_note" placeholder="Penerangan"></textarea>
                                                        <div class="error_spsuk_disemak_note invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group pull-right">
                                                            <input type="hidden" name="spsuk_skuad_uniti_id" id="spsuk_skuad_uniti_id">
                                                            <input type="hidden" name="post_semakan_profile_skuad_uniti" value="edit">
                                                            <input type="hidden" name="action" id="post_semakan_profile_skuad_uniti" value="edit">
                                                            <button type="submit" id="btn_submit" class="btn btn-primary">Hantar Status Semakan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6><b>MAKLUMAT PROFIL SKUAD UNITI</b></h6>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <p>1. Maklumat Ketua Skuad Uniti</p>
                                                <hr class="mt-1">
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama Penuh: </label>
                                                            <input type="text" class="form-control" name="spsupn_skuad_nama_ketua" id="spsupn_skuad_nama_ketua" placeholder="Nama Penuh" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon: </label>
                                                            <input type="text" class="form-control" name="spsupn_skuad_phone_ketua" id="spsupn_skuad_phone_ketua" placeholder="No Telefon" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">E-mel: </label>
                                                            <input type="text" class="form-control" name="spsupn_skuad_email_ketua" id="spsupn_skuad_email_ketua" placeholder="E-mel" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">No Kad Pengenalan: </label>
                                                            <input type="text" class="form-control" name="spsupn_skuad_ic_ketua" id="spsupn_skuad_ic_ketua" placeholder="No Kad Pengenalan" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Alamat Rumah: </label>
                                                            <textarea class="form-control" name="spsupn_skuad_alamat_ketua" id="spsupn_skuad_alamat_ketua" rows="5" placeholder="Alamat Rumah" disabled></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Pekerjaan: </label>
                                                            <input type="text" class="form-control" name="spsupn_skuad_pekerjaan_ketua" id="spsupn_skuad_pekerjaan_ketua" placeholder="Pekerjaan" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p>2. Maklumat Setiausaha Skuad Uniti</p>
                                                <hr class="mt-1">
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama Penuh: </label>
                                                            <input type="text" class="form-control" name="spsupn_skuad_nama_setiausaha" id="spsupn_skuad_nama_setiausaha" placeholder="Nama Penuh" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon: </label>
                                                            <input type="text" class="form-control" name="spsupn_skuad_phone_setiausaha" id="spsupn_skuad_phone_setiausaha" placeholder="No Telefon" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">E-mel: </label>
                                                            <input type="text" class="form-control" name="spsupn_skuad_email_setiausaha" id="spsupn_skuad_email_setiausaha" placeholder="E-mel" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">No Kad Pengenalan: </label>
                                                            <input type="text" class="form-control" name="spsupn_skuad_ic_setiausaha" id="spsupn_skuad_ic_setiausaha" placeholder="No Kad Pengenalan" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Alamat Rumah: </label>
                                                            <textarea class="form-control" name="spsupn_skuad_alamat_setiausaha" id="spsupn_skuad_alamat_setiausaha" rows="5" placeholder="Alamat Rumah" disabled></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Pekerjaan: </label>
                                                            <input type="text" class="form-control" name="spsupn_skuad_pekerjaan_setiausaha" id="spsupn_skuad_pekerjaan_setiausaha" placeholder="Pekerjaan" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <p>3. Biro Skuad Uniti</p>
                                                <hr class="mt-1">
                                                <br>
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_biro_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama Biro</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama Penuh</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">No Kad Pengenalan</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br><br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <p>4. Jaringan Kerjasama Strategik (<i>Berdasarkan isu / keperluan komuniti</i> )</p>
                                                <hr class="mt-1">
                                                <br>
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_jaringan_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama Agensi</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama Pegawai</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">No Telefon</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br><br>
                                        </div>
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

@include('js.rt-sm10.j-semakan-profil-skuad-uniti-krt-1')
