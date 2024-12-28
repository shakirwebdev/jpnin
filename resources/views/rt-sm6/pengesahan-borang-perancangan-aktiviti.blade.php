@extends('layout.master')
@section('title', 'Pengesahan Perancangan Aktiviti Perpaduan')


@section('content')
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                &nbsp;
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>&nbsp;</div>
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
                                                    <h6><b>MAKLUMAT TEMPAT AKTIVITI PERPADUAN</b></h6>
                                                    <br><br>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Negeri: <span class="text-red">*</span></label>
                                                            <select class="form-control" disabled="">
                                                                <option>Perlis</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Daerah: <span class="text-red">*</span></label>
                                                            <select class="form-control" disabled="">
                                                                <option>Kangar</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Tempat: <span class="text-red">*</span></label>
                                                            <textarea class="form-control" rows="4" placeholder="Tempat" disabled="">Dewan Rakyat Taman Peladang Jaya 02000 Kuala Perlis</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio">
                                                                    <input type="radio" class="custom-control-input" name="example-radios" value="option1" checked disabled="">
                                                                    <div class="custom-control-label">Kawasan Rukun Tetangga</div>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input type="radio" class="custom-control-input" name="example-radios" value="option2" disabled="">
                                                                    <div class="custom-control-label">Luar Kawasan Rukun Tetangga</div>
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
                                                    <label class="form-label">Status: <span class="text-red">*</span></label>
                                                    <select class="form-control" disabled="">
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Disahkan</option>
                                                        <option>Perlu Dikemaskini</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Penerangan: <span class="text-red">*</span></label>
                                                    <textarea class="form-control" rows="4" disabled=""></textarea>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group pull-right">
                                                        <button type="submit" class="btn btn-secondary" disabled="">Hantar&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <h6><b>MAKLUMAT AKTIVITI PERPADUAN</b></h6>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <!-- <div class="form-group">
                                                    <div class="form-label">Jenis Aktiviti : <span class="text-red">*</span></div>
                                                    <div class="custom-controls-stacked">
                                                        <label class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" class="custom-control-input" name="example-inline-radios" value="option1" checked>
                                                            <span class="custom-control-label">Perancangan</span>
                                                        </label>
                                                        <label class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" class="custom-control-input" name="example-inline-radios" value="option2">
                                                            <span class="custom-control-label">Laporan</span>
                                                        </label>
                                                    </div>
                                                </div> -->
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">Penganjur: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Penganjur" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Bahagian: <span class="text-red">*</span></label>
                                                    <select class="form-control" disabled="">
                                                        <option>-- Sila Pilih --</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Tajuk Aktiviti: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Tajuk Aktiviti" value="Gotong Royong" disabled="">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">Nama KRT: <span class="text-red">(Wajib diisi sekiranya penganjur ada KRT)</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Nama KRT" value="KRT Taman Peladang Jaya" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">PMK: <span class="text-red">*</span></label>
                                                    <select class="form-control" disabled="">
                                                        <option>-- Sila Pilih --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">Tarikh Aktiviti: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Tarikh Aktiviti" value="1/12/2020" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Masa: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Masa" value="10:00 AM" disabled="">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">Tarikh Rancang: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Tarikh Rancang" value="12/11/2020" disabled="">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">Bidang Aktiviti: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Bidang Aktiviti" disabled="">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">Kategori Aktiviti: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Kategori Aktiviti" disabled="">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label">Anjuran Cawangan: <span class="text-red">*</span></label>
                                                    <select class="form-control" disabled="">
                                                        <option>-- Sila Pilih --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label">Krt Yang Terlibat: <span class="text-red">*</span></label>
                                                    <select class="form-control" disabled="">
                                                        <option>-- Sila Pilih --</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Pembelanjaan: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Pembelanjaan (RM)" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Sumber Kewangan: <span class="text-red">*</span></label>
                                                </div>
                                                <div class="form-group">
                                                    <div class="table-responsive">
                                                        <table class="table thead-dark table-bordered table-striped" id="sumber_kewangan_table" style="width: 100%">
                                                            <thead>
                                                                <tr>
                                                                    <th width="6%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Sumber</font></label></th>
                                                                    <th width="6%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Kumpulan Sasar: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Kumpulan Sasar" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Perasmi: <span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="" placeholder="Perasmi" disabled="">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm6.pengesahan_perancangan_aktiviti')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="button" class="btn btn-secondary"><i class="dropdown-icon fa fa-save"></i>&nbsp;Simpan</button>
                                                <button type="button" class="btn btn-primary" onclick="window.location.href = '{{route('rt-sm6.pengesahan_borang_perancangan_aktiviti_1')}}';">Seterusnya&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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
@stop

@include('js.rt-sm6.j-pengesahan-borang-perancangan-aktiviti')
