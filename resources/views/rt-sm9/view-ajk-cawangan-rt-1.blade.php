@extends('layout.master')
@section('title', 'Paparan Profil Ahli Jawatan Kuasa Cawangan')


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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="vacr_1_nama_krt" name="vacr_1_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="vacr_1_alamat_krt" name="vacr_1_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="vacr_1_negeri_krt" name="vacr_1_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="vacr_1_parlimen_krt" name="vacr_1_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="vacr_1_pbt_krt" name="vacr_1_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="vacr_1_daerah_krt" name="vacr_1_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="vacr_1_dun_krt" name="vacr_1_dun_krt"></span></b></p>
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
                                                <h6><b>MAKLUMAT CAWANGAN RUKUN TETANGGA</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Cawangan: </label>
                                                    <div class="form-group">
                                                        <select class="custom-select" id="vacr_1_cawangan_id" name="vacr_1_cawangan_id" disabled>
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
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT STATUS AHLI JAWATANKUASA</b></h6>
                                                <br>
                                                <form action="#" id="form_vacr1" >
                                                @csrf
                                                    <div class="form-group">
                                                        <label class="form-label">Status: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="vacr1_ajk_status" id="vacr1_ajk_status">
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            <option value="1">Aktif</option>
                                                            <option value="2">Tidak Aktif</option>
                                                        </select>
                                                        <div class="error_vacr1_ajk_status invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group pull-right">
                                                            <input type="hidden" name="vacr1_ajk_cawangan_id" id="vacr1_ajk_cawangan_id">
                                                            <input type="hidden" name="post_kemaskini_status_ajk" value="edit">
                                                            <input type="hidden" name="action" id="post_kemaskini_status_ajk" value="edit">
                                                            <button type="submit" class="btn btn-primary" id="btn_submit">Kemaskini Status Ahli Jawatankuasa&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
                                            <h6><b>MAKLUMAT Profil Ahli Jawatan Kuasa</b></h6>
                                            <br>
                                            <p>3. Maklumat Kerjaya</p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <div class="form-label">Status Pekerjaan (pilih salah satu): </div>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" class="custom-control-input enable_tb" name="vacr_1_status_perkejaan_id" value="1" disabled>
                                                                    <span class="custom-control-label">Bekerja</span>
                                                                    <br>
                                                                </label>
                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" class="custom-control-input" name="vacr_1_status_perkejaan_id" value="2" disabled>
                                                                    <span class="custom-control-label">Tidak Bekerja</span>
                                                                </label>
                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" class="custom-control-input" name="vacr_1_status_perkejaan_id" value="3" disabled>
                                                                    <span class="custom-control-label">Belajar</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Jawatan: </label>
                                                            <input type="text" class="form-control" name="vacr_1_ajk_pekerjaan_jawatan" id="vacr_1_ajk_pekerjaan_jawatan" placeholder="Jawatan" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Bidang: </label>
                                                            <input type="text" class="form-control" name="vacr_1_ajk_pekerjaan_bidang" id="vacr_1_ajk_pekerjaan_bidang" placeholder="Bidang" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Pengalaman Pekerjaan dan Skop Penglibatan : </label>
                                                            <textarea class="form-control" id="vacr_1_ajk_pekerjaan_pengalaman" name="vacr_1_ajk_pekerjaan_pengalaman" rows="4" placeholder="Pengalaman Pekerjaan dan Skop Penglibatan" disabled></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <p>4. Pengalaman / Penglibatan dalam aktiviti / program kesukarelawanan : </p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_pengalaman_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tahun</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Program</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                        <br/><br/>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>5. Kemahiran & Minat : </p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Kemahiran / Kebolehan : </label>
                                                            <textarea class="form-control" id="vacr_1_ajk_kemahiran" name="vacr_1_ajk_kemahiran" rows="4" placeholder="Kemahiran / Kebolehan" disabled></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Minat / Hobi : </label>
                                                            <textarea class="form-control" id="vacr_1_ajk_minat" name="vacr_1_ajk_minat" rows="4" placeholder="Minat / Hobi" disabled></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="button" class="btn btn-secondary" disabled>Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></i></button>
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

@include('js.rt-sm9.j-view-ajk-cawangan-rt-1')
