@extends('layout.master')
@section('title', 'Sokongan Pendaftaran Mediator Komuniti (Pegawai)')


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
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                <br>
                                                <div class="form-group">
                                                    <label class="custom-switch">
                                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked disabled>
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">Dalam Kawasan KRT</span>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Negeri: </label>
                                                    <select class="select2 custom-select" id="" name="" disabled>
                                                        <option value="">PERLIS</option>
                                                        <option value="">-- Sila Pilih --</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Daerah: </label>
                                                    <select class="select2 custom-select" id="" name="" disabled>
                                                        <option value="">PERLIS</option>
                                                        <option value="">-- Sila Pilih --</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Nama KRT: </label>
                                                    <select class="select2 custom-select" id="" name="" disabled>
                                                        <option value="">KRT Taman Peladang Jaya</option>
                                                        <option value="">-- Sila Pilih --</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat KRT: </label>
                                                    <textarea class="form-control" id="" name="" rows="4" disabled="" placeholder="Alamat KRT">Taman Peladang Jaya 02000 Kuala Perlis, Perlis</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT STATUS SOKONGAN</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Status: <span class="text-red">*</span></label>
                                                    <select class="form-control" >
                                                        <option>-- Sila Pilih --</option>
                                                        <option>Disokong</option>
                                                        <option>Perlu Dikemaskini</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Penerangan: <span class="text-red">*</span></label>
                                                    <textarea class="form-control" rows="4" ></textarea>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group pull-right">
                                                        <button type="submit" class="btn btn-primary" >Hantar Status Sokongan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
                                            <h6><b>MAKLUMAT DARI SUMBER YANG MUNGKIN BERLAKU</b></h6>
                                            <br>
                                            <p>1. Maklumat Pemohon : </p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Nama Pemohon: </label>
                                                            <input type="text" class="form-control" name="" placeholder="Nama Pemohon" value="Mohamad Shauki Bin Sahardi" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <b>Tarikh Lahir: </b>
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                                <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="" id="" placeholder="Tarikh Lahir" data-date-format="dd/mm/yyyy" value="08/09/1993" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Jantina: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                 <option value="">Lelaki</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                                <option value="">Lelaki</option>
                                                                <option value="">Perempuan</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Kaum: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">Melayu</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Emel : </label>
                                                            <input type="text" class="form-control" name="" placeholder="Emel" value="mohamadshauki93@gmail.com" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Alamat Rumah: </label>
                                                            <textarea class="form-control" id="" name="" rows="5" placeholder="Alamat Rumah" disabled>No, 10 Lorong 5 Taman Peladang Jaya 02000 Kuala Perlis, Perlis</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Alamat Pejabat: </label>
                                                            <textarea class="form-control" id="" name="" rows="5" placeholder="Alamat Pejabat" disabled>No, 14, Jalan Pangalila Bintong 01000 Kangar, Perlis</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Kategori MKP: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">Pegawai</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                                <option value="">Pegawai</option>
                                                                <option value="">Ahli Rukun Tetangga</option>
                                                                <option value="">Mediator Agama</option>
                                                                <option value="">NGO</option>
                                                                <option value="">Orang Awam</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Kelulusan Akademik: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">Doktor Falsafah (Phd)</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                                <option value="">Doktor Falsafah (Phd)</option>
                                                                <option value="">Sarjana / Sarjana Muda</option>
                                                                <option value="">Diploma</option>
                                                                <option value="">Stpm dan Setaraf</option>
                                                                <option value="">SPM / SPVM dan Setaraf</option>
                                                                <option value="">PMK / SRP dan Setaraf</option>
                                                                <option value="">Sekolah Rendah</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">No Kad Pengenalan: </label>
                                                            <input type="text" class="form-control" name="" placeholder="No Kad Pengenalan" value="930508095161" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Negeri: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">PERLIS</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Daerah: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">PERLIS</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Parlimen: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">KUALA PERLIS</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Dun: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">Kangar</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">PBT: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                 <option value="">Majlis Pembadaran Kangar</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Mukim: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">Mukim Kuala Perlis</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon : </label>
                                                            <input type="text" class="form-control" name="" placeholder="No Telefon" value="0124470470" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">No Telefon Pejabat : </label>
                                                            <input type="text" class="form-control" name="" placeholder="No Telefon Pejabat" value="049851925" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Tahap MKP: </label>
                                                            <select class="select2 custom-select" id="" name="" disabled>
                                                                <option value="">Mediator Pelatih</option>
                                                                <option value="">-- Sila Pilih --</option>
                                                                <option value="">Mediator Pelatih</option>
                                                                <option value="">Mediator</option>
                                                                <option value="">Senior Mediator</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Pengkhususan (kemahiran): </label>
                                                            <input type="text" class="form-control" name="" placeholder="Pengkhususan" value="Tiada" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <p>2. Maklumat Kursus Yang Dihadiri : <span class="text-red">*</span></p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="series-frame">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">Nama Kursus : </label>
                                                                    <input type="text" class="form-control" name="" placeholder="Isu / Masalah" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Kategori Kursus: </label>
                                                                    <select class="select2 custom-select" id="" name="" disabled>
                                                                        <option value="">-- Sila Pilih --</option>
                                                                        <option value="">Tahap 1</option>
                                                                        <option value="">Tahap 2</option>
                                                                        <option value="">Tahap 3</option>
                                                                        <option value="">Tahap 4</option>
                                                                        <option value="">Conferensing Case</option>
                                                                        <option value="">Pentaulihan</option>
                                                                        <option value="">Simposium</option>
                                                                        <option value="">Refseshing</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Peringkat Kursus: </label>
                                                                    <select class="select2 custom-select" id="" name="" disabled>
                                                                        <option value="">-- Sila Pilih --</option>
                                                                        <option value="">Ibu Pejabat</option>
                                                                        <option value="">Negeri</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Penganjur : </label>
                                                                    <input type="text" class="form-control" name="" placeholder="Status Pelaksana" disabled>
                                                                </div>
                                                                <button type="submit" class="btn btn-secondary pull-right" disabled>Tambah</button>
                                                            </div>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_kursus_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Nama Kursus</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Kategori Kursus</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Peringkat Kursus</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Penganjur</font></label></th>
                                                                        <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="button" class="btn btn-secondary" disabled>Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@stop

@include('js.rt-sm23.j-sokongan-mkp-admin-ppmk-1')
