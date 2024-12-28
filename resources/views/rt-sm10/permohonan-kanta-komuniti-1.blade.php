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
                                                                <label class="form-label">Nama Kanta Komuniti: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pkk_kanta_nama" id="pkk_kanta_nama" placeholder="Nama Kanta Komuniti" >
                                                                <div class="error_pkk_kanta_nama invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Alamat Lokasi Kanta Komuniti: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" rows="4" id="pkk_kanta_alamat" name="pkk_kanta_alamat" placeholder="Alamat Lokasi Kanta Komuniti"></textarea>
                                                                <div class="error_pkk_kanta_alamat invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Jenis Kediaman : <span class="text-red">*</span></label>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" name="pkk_kanta_jenis_kediaman_1" value='1'>
                                                                        <span class="custom-control-label">Rumah Perkampungan / Persendirian</span>
                                                                    </label>
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" name="pkk_kanta_jenis_kediaman_2" value='1'>
                                                                        <span class="custom-control-label">Flat / Rumah Pangsa</span>
                                                                    </label>
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" name="pkk_kanta_jenis_kediaman_3" value='1'>
                                                                        <span class="custom-control-label">Rumah Teres Kos Rendah</span>
                                                                    </label>
                                                                    <label class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" name="pkk_kanta_jenis_kediaman_4" value='1'>
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
                                                <form action="#" id="form_pkk1">
                                                    {{ csrf_field() }}
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <p>Komposisi Penduduk : <span class="text-red">*</span></p> 
                                                            <hr class="mt-1">
                                                            <div class="col-md-12 alert alert-danger error_form_pkk1" role="alert" style="display: none; padding-bottom: 0px;">
                                                                <ul></ul>
                                                            </div>
                                                            <div class="series-frame">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Kaum :</label>
                                                                        <select class="custom-select" id="pkk1_kaum_id" name="pkk1_kaum_id">
                                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                            @foreach($kaum as $item)                                    
                                                                                <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Bilangan : </label>
                                                                        <input type="text" class="form-control" name="pkk1_bilangan" id="pkk1_bilangan" placeholder="Bilangan">
                                                                    </div>
                                                                    <input type="hidden" name="pkk1_kanta_komuniti_id" id="pkk1_kanta_komuniti_id">
                                                                    <input type="hidden" name="add_kanta_komuniti_kaum" value="add">
                                                                    <button type="submit" class="btn btn-primary pull-right" id="btn_save_kaum"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                </div>
                                                            </div>
                                                            <br/><br/>
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_kaum_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Kaum</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Bilangan</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Peratus</font></label></th>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <br>
                                                <form action="#" id="form_pkk2">
                                                    {{ csrf_field() }}
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <p>Bilangan Rumah dan Pecahan Mengikut Kaum : <span class="text-red">*</span></p> 
                                                            <hr class="mt-1">
                                                            <div class="col-md-12 alert alert-danger error_form_pkk2" role="alert" style="display: none; padding-bottom: 0px;">
                                                                <ul></ul>
                                                            </div>
                                                            <div class="series-frame">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Kaum :</label>
                                                                        <select class="custom-select" id="pkk2_kaum_id" name="pkk2_kaum_id">
                                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                            @foreach($kaum as $item)                                    
                                                                                <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Bilangan Unit Rumah : </label>
                                                                        <input type="text" class="form-control" name="pkk2_bilangan_rumah" id="pkk2_bilangan_rumah" placeholder="Bilangan Unit Rumah">
                                                                    </div>
                                                                    <input type="hidden" name="pkk2_kanta_komuniti_id" id="pkk2_kanta_komuniti_id">
                                                                    <input type="hidden" name="add_kanta_komuniti_penduduk" value="add">
                                                                    <button type="submit" class="btn btn-primary pull-right" id="btn_save_penduduk"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                </div>
                                                            </div>
                                                            <br/><br/>
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_penduduk_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Kaum</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Bilangan Rumah</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Peratus</font></label></th>
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
                                            <form method="POST" id="form_pkk3">
                                            @csrf
                                                <input type="hidden" name="pkk3_kanta_komuniti_id" id="pkk3_kanta_komuniti_id">
                                                <input type="hidden" name="action" id="post_permohonan_kanta_komuniti_1" value="edit">
                                                <input type="hidden" name="post_permohonan_kanta_komuniti_1" value="edit">
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="submit" class="btn btn-primary" id="btn_next">Seterusnya &nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm10.j-permohonan-kanta-komuniti-1')
