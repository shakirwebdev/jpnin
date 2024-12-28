@extends('layout.master')
@section('title', 'Rekod Profil Ahli Jawatan Kuasa Cawangan')


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
    <div class="section-body mt-3" style="display:none;" id="tacr_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> 
                                <span class="text-red blink" id="tacr_status_description" name="tacr_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> 
                                <span id="tacr_disemak_note" name="tacr_disemak_note"></span></span>
                                <span id="tacr_diakui_note" name="tacr_diakui_note"></span></span>.
                                <br>
                                <input type="hidden" name="tacr_status" id="tacr_status">
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
                                <form method="POST" id="form_tacr_4">
                                @csrf
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row clearfix">
                                                        <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                        <br><br>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="tacr_4_nama_krt" name="tacr_4_nama_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="tacr_4_alamat_krt" name="tacr_4_alamat_krt"></span></b></p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <p><span style="font-size:12px">Negeri</span><br><b><span id="tacr_4_negeri_krt" name="tacr_4_negeri_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Parlimen</span><br><b><span id="tacr_4_parlimen_krt" name="tacr_4_parlimen_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="tacr_4_pbt_krt" name="tacr_4_pbt_krt"></span></b></p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <p><span style="font-size:12px">Daerah</span><br><b><span id="tacr_4_daerah_krt" name="tacr_4_daerah_krt"></span></b></p>
                                                            <p><span style="font-size:12px">Dun</span><br><b><span id="tacr_4_dun_krt" name="tacr_4_dun_krt"></span></b></p>
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
                                                    <h6><b>MAKLUMAT Cawangan Rukun Tetangga</b></h6>
                                                    <br><br>
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Cawangan: </label>
                                                        <div class="form-group">
                                                            <select class="custom-select" id="tacr_4_cawangan_id" name="tacr_4_cawangan_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($cawangan as $item)                                    
                                                                    <option value="{{ $item->id }}">{{ $item->cawangan_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6><b>MAKLUMAT Profil Ahli Jawatan Kuasa</b></h6>
                                            <br>
                                            <p>3. Maklumat Kerjaya</p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form method="POST" id="form_tacr_5">
                                                @csrf
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <div class="form-label">Status Pekerjaan (pilih salah satu): <span class="text-red">*</span></div>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" class="custom-control-input enable_tb" name="tacr_4_status_perkejaan_id" value="1">
                                                                        <span class="custom-control-label">Bekerja</span>
                                                                        <br>
                                                                    </label>
                                                                    <label class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" class="custom-control-input" name="tacr_4_status_perkejaan_id" value="2">
                                                                        <span class="custom-control-label">Tidak Bekerja</span>
                                                                    </label>
                                                                    <label class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" class="custom-control-input" name="tacr_4_status_perkejaan_id" value="3">
                                                                        <span class="custom-control-label">Belajar</span>
                                                                    </label>
                                                                    <div class="error_tacr_4_status_perkejaan_id invalid-feedback text-right"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Jawatan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="tacr_4_ajk_pekerjaan_jawatan" id="tacr_4_ajk_pekerjaan_jawatan" placeholder="Jawatan" disabled>
                                                                <div class="error_tacr_4_ajk_pekerjaan_jawatan invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Bidang: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="tacr_4_ajk_pekerjaan_bidang" id="tacr_4_ajk_pekerjaan_bidang" placeholder="Bidang" disabled>
                                                                <div class="error_tacr_4_ajk_pekerjaan_bidang invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Pengalaman Pekerjaan dan Skop Penglibatan : <span class="text-red">*</span></label>
                                                                <textarea class="form-control" id="tacr_4_ajk_pekerjaan_pengalaman" name="tacr_4_ajk_pekerjaan_pengalaman" rows="4" placeholder="Pengalaman Pekerjaan dan Skop Penglibatan" disabled></textarea>
                                                                <div class="error_tacr_4_ajk_pekerjaan_pengalaman invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <br>
                                            <p>4. Pengalaman / Penglibatan dalam aktiviti / program kesukarelawanan : </p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form action="#" id="form_tacr_6">
                                                {{ csrf_field() }}
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="col-md-12 alert alert-danger error_form_tacr_6" role="alert" style="display: none; padding-bottom: 0px;">
                                                                <ul></ul>
                                                            </div>
                                                            <div class="series-frame">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Tahun: <span class="text-red">*</span></label>
                                                                        <input type="text" class="form-control" name="tacr_6_pengalaman_tahun" id="tacr_6_pengalaman_tahun" placeholder="Tahun">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Program: <span class="text-red">*</span></label>
                                                                        <input type="text" class="form-control" name="tacr_6_pengalaman_program" id="tacr_6_pengalaman_program" placeholder="Program">
                                                                    </div>
                                                                    <br/>
                                                                    <input type="hidden" name="tacr_6_ajk_cawangan_id" id="tacr_6_ajk_cawangan_id">
                                                                    <input type="hidden" name="add_maklumat_pengalaman" value="add">
                                                                    <button type="submit" class="btn btn-primary pull-right" id="btn-save-pengalaman"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                </div>
                                                            </div>
                                                            <br/><br/>
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_pengalaman_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Tahun</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Program</font></label></th>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                            <br/><br/>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <p>5. Kemahiran & Minat : </p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form method="POST" id="form_tacr_7">
                                                    @csrf
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Kemahiran / Kebolehan : <span class="text-red">*</span></label>
                                                                <textarea class="form-control" id="tacr_4_ajk_kemahiran" name="tacr_4_ajk_kemahiran" rows="4" placeholder="Kemahiran / Kebolehan"></textarea>
                                                                <div class="error_tacr_4_ajk_kemahiran invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Minat / Hobi : <span class="text-red">*</span></label>
                                                                <textarea class="form-control" id="tacr_4_ajk_minat" name="tacr_4_ajk_minat" rows="4" placeholder="Minat / Hobi"></textarea>
                                                                <div class="error_tacr_4_ajk_minat invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form method="POST" id="form_tacr_8">
                                            @csrf
                                                <input type="hidden" name="tacr_8_ajk_cawangan_id" id="tacr_8_ajk_cawangan_id">
                                                <input type="hidden" name="action" id="update_ajk_cawangan_rt_2" value="edit">
                                                <input type="hidden" name="update_ajk_cawangan_rt_2" value="edit">
                                                <button type="button" class="btn btn-secondary"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="submit" class="btn btn-primary" id="btn_send">Hantar Profil AJK Cawangan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></i></button>
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

@include('js.rt-sm9.j-tambah-ajk-cawangan-rt-2')
