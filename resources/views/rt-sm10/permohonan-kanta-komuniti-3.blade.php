@extends('layout.master')
@section('title', 'Permohonan Kanta Komuniti')


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
    <div class="section-body mt-3" style="display:none;" id="pkk_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert">
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span class="text-red blink" id="pkk_status_description" name="pkk_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> <span id="pkk_disemak_note" name="pkk_disemak_note"></span><span id="pkk_disahkan_note" name="pkk_disahkan_note"></span>.
                                <br>
                                <input type="hidden" name="pkk_status" id="pkk_status">
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
                                                    <h6><b>MAKLUMAT AM KANTA KOMUNITI</b></h6>
                                                    <br><br>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <form method="POST" id="form_pkk">
                                                        @csrf
                                                            <div class="form-group">
                                                                <label class="form-label">Negeri</label>
                                                                <select class="custom-select" id="pkk_state_id" name="pkk_state_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($state as $item)                                    
                                                                        <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Daerah</label>
                                                                <select class="custom-select" id="pkk_daerah_id" name="pkk_daerah_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($daerah as $item)                                    
                                                                        <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Nama Kanta Komuniti: </label>
                                                                <input type="text" class="form-control" name="pkk_kanta_nama" id="pkk_kanta_nama" placeholder="Nama Kanta Komuniti" disabled>
                                                                <div class="error_pkk_kanta_nama invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Alamat Lokasi Kanta Komuniti: </label>
                                                                <textarea class="form-control" rows="4" id="pkk_kanta_alamat" name="pkk_kanta_alamat" placeholder="Alamat Lokasi Kanta Komuniti" disabled></textarea>
                                                                <div class="error_pkk_kanta_alamat invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Jenis Kediaman : </label>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" name="pkk_kanta_jenis_kediaman_1" value='1' disabled>
                                                                        <span class="custom-control-label">Rumah Perkampungan / Persendirian</span>
                                                                    </label>
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" name="pkk_kanta_jenis_kediaman_2" value='1' disabled>
                                                                        <span class="custom-control-label">Flat / Rumah Pangsa</span>
                                                                    </label>
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" name="pkk_kanta_jenis_kediaman_3" value='1' disabled>
                                                                        <span class="custom-control-label">Rumah Teres Kos Rendah</span>
                                                                    </label>
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" name="pkk_kanta_jenis_kediaman_4" value='1' disabled>
                                                                        <span class="custom-control-label">Gabungan Jenis Perumahan</span>
                                                                    </label>
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
                            <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6><b>MAKLUMAT PROFIL KANTA KOMUNITI</b></h6>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form action="#" id="form_pkk7">
                                                    {{ csrf_field() }}
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <p>Isu dan Masalah : <span class="text-red">(Mengikut Keutamaan)</span></p> 
                                                            <hr class="mt-1">
                                                            <div class="col-md-12 alert alert-danger error_form_pkk7" role="alert" style="display: none; padding-bottom: 0px;">
                                                                <ul></ul>
                                                            </div>
                                                            <div class="series-frame">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Isu / Masalah : </label>
                                                                        <input type="text" class="form-control" name="pkk7_masalah_tajuk" id="pkk7_masalah_tajuk" placeholder="Isu / Masalah">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Perincian Isu : </label>
                                                                        <input type="text" class="form-control" name="pkk7_masalah_perincian" id="pkk7_masalah_perincian" placeholder="Perincian Isu">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Penjelasan Isu : </label>
                                                                        <input type="text" class="form-control" name="pkk7_masalah_penjelasan" id="pkk7_masalah_penjelasan" placeholder="Penjelasan Isu">
                                                                    </div>
                                                                    <input type="hidden" name="pkk7_kanta_komuniti_id" id="pkk7_kanta_komuniti_id">
                                                                    <input type="hidden" name="add_kanta_komuniti_masalah" value="add">
                                                                    <button type="submit" class="btn btn-primary pull-right" id="btn_save_masalah"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                </div>
                                                            </div>
                                                            <br/><br/>
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_masalah_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Isu / Masalah</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Perincian Isu</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Penjelasan Isu</font></label></th>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <br>
                                                <form action="#" id="form_pkk8">
                                                    {{ csrf_field() }}
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <p>Status Kewujudan KRT : <span class="text-red">*</span></p> 
                                                            <hr class="mt-1">
                                                            <div class="col-md-12 alert alert-danger error_form_pkk8" role="alert" style="display: none; padding-bottom: 0px;">
                                                                <ul></ul>
                                                            </div>
                                                            <div class="series-frame">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Nama KRT</label>
                                                                        <select class="custom-select" id="pkk8_krt_profile_id" name="pkk8_krt_profile_id">
                                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                            @foreach($krt_profile as $item)                                    
                                                                                <option value="{{ $item->id }}">{{ $item->krt_nama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Isu / Masalah : </label>
                                                                        <input type="text" class="form-control" name="pkk8_krt_masalah" id="pkk8_krt_masalah" placeholder="Isu / Masalah">
                                                                    </div>
                                                                    <input type="hidden" name="pkk8_kanta_komuniti_id" id="pkk8_kanta_komuniti_id">
                                                                    <input type="hidden" name="add_kanta_komuniti_krt" value="add">
                                                                    <button type="submit" class="btn btn-primary pull-right" id="btn_save_krt"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                </div>
                                                            </div>
                                                            <br/><br/>
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_krt_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Nama KRT</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Isu / Masalah</font></label></th>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
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
                                            <form method="POST" id="form_pkk9">
                                            @csrf
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="button" class="btn btn-primary" id="btn_next">Seterusnya &nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
                                            </form>
                                        </div>
                                        <br>
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

@include('js.rt-sm10.j-permohonan-kanta-komuniti-3')
