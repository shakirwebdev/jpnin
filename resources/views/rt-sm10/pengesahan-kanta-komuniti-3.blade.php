@extends('layout.master')
@section('title', 'Pengesahan Permohonan Kanta Komuniti')


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
                                                    <h6><b>MAKLUMAT AM KANTA KOMUNITI</b></h6>
                                                    <br><br>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Negeri</label>
                                                            <select class="custom-select" id="skk_state_id" name="skk_state_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($state as $item)                                    
                                                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Daerah</label>
                                                            <select class="custom-select" id="skk_daerah_id" name="skk_daerah_id" disabled>
                                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                @foreach($daerah as $item)                                    
                                                                    <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Nama Kanta Komuniti: </label>
                                                            <input type="text" class="form-control" name="skk_kanta_nama" id="skk_kanta_nama" placeholder="Nama Kanta Komuniti" disabled>
                                                            <div class="error_skk_kanta_nama invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Alamat Lokasi Kanta Komuniti: </label>
                                                            <textarea class="form-control" rows="4" id="skk_kanta_alamat" name="skk_kanta_alamat" placeholder="Alamat Lokasi Kanta Komuniti" disabled></textarea>
                                                            <div class="error_skk_kanta_alamat invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Jenis Kediaman : </label>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="skk_kanta_jenis_kediaman_1" value='1' disabled>
                                                                    <span class="custom-control-label">Rumah Perkampungan / Persendirian</span>
                                                                </label>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="skk_kanta_jenis_kediaman_2" value='1' disabled>
                                                                    <span class="custom-control-label">Flat / Rumah Pangsa</span>
                                                                </label>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="skk_kanta_jenis_kediaman_3" value='1' disabled>
                                                                    <span class="custom-control-label">Rumah Teres Kos Rendah</span>
                                                                </label>
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" name="skk_kanta_jenis_kediaman_4" value='1' disabled>
                                                                    <span class="custom-control-label">Gabungan Jenis Perumahan</span>
                                                                </label>
                                                            </div>
                                                        </div>
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
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Status: </label>
                                                    <select class="form-control" name="" id="" disabled>
                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            <option value="1" >Disahkan</option>
                                                            <option value="7" >Perlu Dikemaskini</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Penerangan: </label>
                                                    <textarea class="form-control" rows="4" name=""id="" placeholder="Penerangan" disabled></textarea>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group pull-right">
                                                        <button type="submit" id="btn_submit" class="btn btn-secondary" disabled>Hantar Status Pengesahan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <p>Isu dan Masalah : <span class="text-red">(Mengikut Keutamaan)</span></p> 
                                                        <hr class="mt-1">
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Isu / Masalah : </label>
                                                                    <input type="text" class="form-control" name="" id="" placeholder="Isu / Masalah" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Perincian Isu : </label>
                                                                    <input type="text" class="form-control" name="" id="" placeholder="Perincian Isu" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Penjelasan Isu : </label>
                                                                    <input type="text" class="form-control" name="" id="" placeholder="Penjelasan Isu" disabled>
                                                                </div>
                                                                <button type="submit" class="btn btn-secondary pull-right" id="btn_save_masalah" disabled><i class="fe fe-plus mr-2"></i>Tambah</button>
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
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <p>Status Kewujudan KRT : </p> 
                                                        <hr class="mt-1">
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Nama KRT</label>
                                                                    <select class="custom-select" id="" name="" disabled>
                                                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                        @foreach($krt_profile as $item)                                    
                                                                            <option value="{{ $item->id }}">{{ $item->krt_nama }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Isu / Masalah : </label>
                                                                    <input type="text" class="form-control" name="" id="" placeholder="Isu / Masalah" disabled>
                                                                </div>
                                                                <button type="submit" class="btn btn-secondary pull-right" id="btn_save_krt" disabled><i class="fe fe-plus mr-2"></i>Tambah</button>
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
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form method="POST" id="form_skk9">
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

@include('js.rt-sm10.j-pengesahan-kanta-komuniti-3')
