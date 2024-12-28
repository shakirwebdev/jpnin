@extends('layout.master')
@section('title', 'Pengurusan Pengguna')


@section('content')
<div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <ul class="nav nav-tabs page-header-tab">
                    <li class="nav-item"><a class="nav-link active" id="Departments-tab" data-toggle="tab" href="#ref-jpnin"><i class="fa fa-list-ul"></i>&nbsp;Pengguna</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" id="Departments-tab1" data-toggle="tab" href="#ref-orang-awam"><i class="fa fa-list-ul"></i>&nbsp;Pengguna Orang Awam</a></li> -->
                    <!-- <li class="nav-item"><a class="nav-link" id="Departments-tab2" data-toggle="tab" href="#ref-eKRT"><i class="fa fa-list-ul"></i>&nbsp;Pengguna e-KRT</a></li> -->
                    <!-- <li class="nav-item"><a class="nav-link" id="Departments-tab3" data-toggle="tab" href="#ref_srs"><i class="fa fa-list-ul"></i>&nbsp;Pengguna e-SRS</a></li> -->
                    <!-- <li class="nav-item"><a class="nav-link" id="Departments-tab4" data-toggle="tab" href="#ref_espakat"><i class="fa fa-list-ul"></i>&nbsp;Pengguna e-Sepakat</a></li> -->
                </ul>
            </div>
        </div>
    </div>
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="ref-jpnin" role="tabpanel">
                    <div class="row clearfix">
                        <div class="col-12">
                            @if(\Session::has('success'))
                                <div class="form-group">
                                    <div class="col-lg-12 alert alert-success text-sm-left">
                                        <small>{{\Session::get('success')}}</small>
                                    </div>
                                </div>
                            @endif
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Carian</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Cari pengguna..." id="myInputTextField_UserJPNIN">
                                            </div>
                                        </div>
                                        <!-- <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>Peranan</label>
                                            <div class="form-group">
                                                <select class="custom-select" id="mySelectField_JPNIN">
                                                    <option value="">Pilih untuk isihan</option>
                                                    @foreach($roles_user as $item)
                                                    <option value="{{ $item->state_code }}">{{ $item->short_description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> -->
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <br>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary" title="" data-toggle="modal" data-target="#ModalAddJPNIN"><i class="fa fa-window-restore" aria-hidden="true"></i>&nbsp;&nbsp;Tambah Pengguna JPNIN</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Senarai Pengguna</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-vcenter table-hover mb-0" id="user_jpnin_table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Nama Penuh</font></th>
                                                    <th style="background-color: #113f50"><font color="white">No Kad Pengenalan</font></th>
                                                    <th style="background-color: #113f50"><font color="white">No Telefon</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Peranan</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Tarikh</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Status</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Tindakan</font></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="ref-orang-awam" role="tabpanel">
                    <div class="row clearfix">
                        <div class="col-12">
                            @if(\Session::has('success'))
                                <div class="form-group">
                                    <div class="col-lg-12 alert alert-success text-sm-left">
                                        <small>{{\Session::get('success')}}</small>
                                    </div>
                                </div>
                            @endif
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Carian</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Cari pengguna..." id="myInputTextField_OrgAwam">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>Negeri</label>
                                            <div class="form-group">
                                                <select class="custom-select" id="mySelectField_Parlimen">
                                                    <option value="">Pilih untuk isihan</option>
                                                    @foreach($negeri as $item)
                                                    <option value="{{ $item->state_code }}">{{ $item->state_description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Senarai Pengguna Orang Awam</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-vcenter table-hover mb-0" id="orang_awam_table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Nama Penuh</font></th>
                                                    <th style="background-color: #113f50"><font color="white">No Kad Pengenalan</font></th>
                                                    <th style="background-color: #113f50"><font color="white">No Telefon</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Peranan</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Tarikh</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Status</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Tindakan</font></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="ref-eKRT" role="tabpanel">
                    <div class="row clearfix">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Cari pengguna..." id="myInputTextField_ekrt">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>Negeri</label>
                                            <div class="form-group">
                                                <select class="custom-select" id="mySelectField_Parlimen">
                                                    <option value="">Pilih untuk isihan</option>
                                                    @foreach($negeri as $item)
                                                    <option value="{{ $item->state_code }}">{{ $item->state_description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <br>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary" title="" data-toggle="modal" data-target="#ModalAddeKRT"><i class="fa fa-window-restore" aria-hidden="true"></i>&nbsp;&nbsp;Tambah Pengguna eKRT</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Senarai Pengguna e-KRT</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-vcenter table-hover mb-0" id="KRT_table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Nama Penuh</font></th>
                                                    <th style="background-color: #113f50"><font color="white">No Kad Pengenalan</font></th>
                                                    <th style="background-color: #113f50"><font color="white">No Telefon</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Peranan</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Tarikh</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Status</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Tindakan</font></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="ref_srs" role="tabpanel">
                    <div class="row clearfix">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Carian</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Cari pengguna..." id="srs_nama_penuh">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Cari No Kad Pengenalan..." id="srs_no_ic">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <br>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary" title="" data-toggle="modal" data-target="#ModalAddeSRS"><i class="fa fa-window-restore" aria-hidden="true"></i>&nbsp;&nbsp;Tambah Pengguna e-SRS</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Senarai Pengguna e-SRS</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-vcenter table-hover mb-0" id="pengguna_SRS_table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Nama Penuh</font></th>
                                                    <th style="background-color: #113f50"><font color="white">No Kad Pengenalan</font></th>
                                                    <th style="background-color: #113f50"><font color="white">No Telefon</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Peranan</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Tarikh</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Status</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Tindakan</font></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="ref_espakat" role="tabpanel">
                    <div class="row clearfix">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Carian</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Cari pengguna..." id="srs_nama_penuh">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Cari No Kad Pengenalan..." id="srs_no_ic">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <br>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary" title="" data-toggle="modal" data-target="#ModalAddeSepakat"><i class="fa fa-window-restore" aria-hidden="true"></i>&nbsp;&nbsp;Tambah Pengguna e-Sepakat</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Senarai Pengguna e-Sepakat</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-vcenter table-hover mb-0" id="pengguna_eSepakat_table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Nama Penuh</font></th>
                                                    <th style="background-color: #113f50"><font color="white">No Kad Pengenalan</font></th>
                                                    <th style="background-color: #113f50"><font color="white">No Telefon</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Peranan</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Tarikh</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Status</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Tindakan</font></th>
                                                </tr>
                                            </thead>
                                        </table>
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

@section('popup')
    <!-- Modal Add Pengguna JPNIN -->
        <div class="modal fade" id="ModalAddJPNIN" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalJPNINLabel">Tambah Pengguna JPNIN</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="#" id="user_jpnin_add_form">
                    {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <small>Isi maklumat pada ruangan di bawah, dan tekan butang <strong>Simpan</strong> untuk menambah rekod ke pangkalan data</small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h3 class="card-title">Maklumat Personel</h3>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>Nama penuh</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-mouse-pointer"></i></span>
                                            </div>
                                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="nama penuh anda">
                                            <div class="c_name invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 for_public" >
                                    <div class="form-group">
                                        <b>No Kad Pengenalan</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-id-card-o"></i></span>
                                            </div>
                                            <input type="text" name="ic" class="form-control" value="{{ old('ic') }}" placeholder="XXXXXXXXXXXX" id="no-ic">
                                            <div class="c_ic invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 for_public" >
                                    <div class="form-group">
                                        <b>No Telefon</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                            </div>
                                            <input type="text" name="phone" class="form-control phone-number" value="{{ old('phone') }}" placeholder="Cth: 00000000000" id="no-telefon">
                                            <div class="c_phone invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>Alamat email</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                            </div>
                                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Cth: ali@email.com" id="email">
                                            <div class="c_email invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 negeri">
                                    <div class="form-group">
                                    <label for="select_negeri_jpnin"><b>Negeri</b></label>
                                        <select class="custom-select" name="select_negeri_jpnin" id="select_negeri_jpnin">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih negeri</option>
                                            @foreach($negeri as $item)
                                            <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_negeri invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 daerah">
                                    <div class="form-group">
                                    <label for="select_daerah_jpnin"><b>Daerah</b></label>
                                        <select class="custom-select" name="select_daerah_jpnin" id="select_daerah_jpnin">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih daerah</option>
                                            @foreach($daerah as $item)
                                            <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_daerah invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 krt">
                                    <div class="form-group">
                                    <label for="select_krt_jpnin"><b>Kawasan Rukun Tetangga</b></label>
                                        <select class="custom-select" name="select_krt_jpnin" id="select_krt_jpnin">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($krt as $item)
                                            <option value="{{ $item->id }}">{{ $item->krt_nama }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_krt invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                <br>
                                    <h3 class="card-title">Peranan</h3>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Peranan:</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-controls-stacked">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='2'>
                                            <span class="custom-control-label">Pentadbir Sistem</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='4'>
                                            <span class="custom-control-label">Pengerusi</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='5'>
                                            <span class="custom-control-label">Setiausaha</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='6'>
                                            <span class="custom-control-label">Bendahari</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='7'>
                                            <span class="custom-control-label">Ketua Peronda</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='8'>
                                            <span class="custom-control-label">PPD (RT)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='9'>
                                            <span class="custom-control-label">PPN (RT)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='10'>
                                            <span class="custom-control-label">PPD (SRS)</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-controls-stacked">
                                       <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='11'>
                                            <span class="custom-control-label">PPN (SRS)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='12'>
                                            <span class="custom-control-label">HQ (RT)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='13'>
                                            <span class="custom-control-label">HQ (UKK)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='14'>
                                            <span class="custom-control-label">HQ (UPK)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='15'>
                                            <span class="custom-control-label">HQ (SRS)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='16'>
                                            <span class="custom-control-label">Ketua Pengarah RT</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='17'>
                                            <span class="custom-control-label">MKP</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='18'>
                                            <span class="custom-control-label">PPD (e-Sepakat)</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-controls-stacked">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='19'>
                                            <span class="custom-control-label">PPMK (e-Sepakat)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='20'>
                                            <span class="custom-control-label">PPN (e-Sepakat)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='21'>
                                            <span class="custom-control-label">BPP (UPK)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='22'>
                                            <span class="custom-control-label">P (PP)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='23'>
                                            <span class="custom-control-label">HQ (UPMK)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='24'>
                                            <span class="custom-control-label">TKP (P)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='25'>
                                            <span class="custom-control-label">KP e-Sepakat</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='26'>
                                            <span class="custom-control-label">KPN</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-controls-stacked">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='27'>
                                            <span class="custom-control-label">Ibu Bapa / Penjaga</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='28'>
                                            <span class="custom-control-label">Guru (e-TP)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='29'>
                                            <span class="custom-control-label">PPD (e-TP)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='30'>
                                            <span class="custom-control-label">HQ (UPAKK)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='31'>
                                            <span class="custom-control-label">P (KSIN)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_peranan_jpnin[]" value='31'>
                                            <span class="custom-control-label">KP e-TP</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                <br>
                                    <h3 class="card-title">Kata Laluan</h3>
                                    <hr>
                                </div>
                                
                                <div class="col-md-12">
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group controls show-hide-wpd">
                                        <b>Kata laluan</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input type="password" name="password_1" class="form-control" value="" placeholder="kata laluan anda">
                                            <div class="c_password invalid-feedback text-right"></div>
                                            <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group controls show-hide-wpd">
                                        <b>Kata laluan (taip semula)</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input type="password" name="password_2" class="form-control" value="{{ old('password_2') }}" placeholder="kata laluan (taip semula)">
                                            <div class="invalid-feedback text-right"></div>
                                            <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success" id="btn_save_jpnin">Simpan</button>
                            <input type="hidden" name="action_jpnin" value="add">
                            <input type="hidden" name="action" id="action_jpnin" value="add">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- Modal Kemaskini Pengguna JPNIN -->
        <div class="modal fade" id="ModalEditJPNIN" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Kemaskini Pengguna JPNIN</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="#" id="user_jpnin_edit_form">
                    {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <small>Isi maklumat pada ruangan di bawah, dan tekan butang <strong>Kemaskini</strong> untuk menambah rekod ke pangkalan data</small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h3 class="card-title">Maklumat Personel</h3>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>Nama penuh</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-mouse-pointer"></i></span>
                                            </div>
                                            <input type="text" name="edit_name" class="form-control" value="{{ old('name') }}" placeholder="nama penuh anda">
                                            <div class="c_edit_name invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 for_public" >
                                    <div class="form-group">
                                        <b>No Kad Pengenalan</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-id-card-o"></i></span>
                                            </div>
                                            <input type="text" name="edit_ic" class="form-control" value="{{ old('ic') }}" placeholder="XXXXXX-XX-XXXX" id="no-ic" >
                                            <div class="c_edit_ic invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 for_public" >
                                    <div class="form-group">
                                        <b>No Telefon</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                            </div>
                                            <input type="text" name="edit_phone" class="form-control phone-number" value="{{ old('phone') }}" placeholder="Cth: 000-00000000" id="no-telefon">
                                            <div class="c_edit_phone invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>Alamat email</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                            </div>
                                            <input type="email" name="edit_email" class="form-control" value="{{ old('email') }}" placeholder="Cth: ali@email.com" id="email">
                                            <div class="c_edit_email invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 negeri">
                                    <div class="form-group">
                                    <label for="select_edit_negeri_jpnin"><b>Negeri</b></label>
                                        <select class="custom-select" name="select_edit_negeri_jpnin" id="select_edit_negeri_jpnin">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih negeri</option>
                                            @foreach($negeri as $item)
                                            <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_edit_negeri invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 daerah">
                                    <div class="form-group">
                                    <label for="select_edit_daerah_jpnin"><b>Daerah</b></label>
                                        <select class="custom-select" name="select_edit_daerah_jpnin" id="select_edit_daerah_jpnin">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih daerah</option>
                                            @foreach($daerah as $item)
                                            <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_edit_daerah invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 krt">
                                    <div class="form-group">
                                    <label for="select_edit_krt_jpnin"><b>Kawasan Rukun Tetangga</b></label>
                                        <select class="custom-select" name="select_edit_krt_jpnin" id="select_edit_krt_jpnin">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($krt as $item)
                                            <option value="{{ $item->id }}">{{ $item->krt_nama }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_edit_krt invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Peranan:</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-controls-stacked">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='2'>
                                            <span class="custom-control-label">Pentadbir Sistem</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='4'>
                                            <span class="custom-control-label">Pengerusi</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='5'>
                                            <span class="custom-control-label">Setiausaha</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='6'>
                                            <span class="custom-control-label">Bendahari</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='7'>
                                            <span class="custom-control-label">Ketua Peronda</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='8'>
                                            <span class="custom-control-label">PPD (RT)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='9'>
                                            <span class="custom-control-label">PPN (RT)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='10'>
                                            <span class="custom-control-label">PPD (SRS)</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-controls-stacked">
                                       <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='11'>
                                            <span class="custom-control-label">PPN (SRS)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='12'>
                                            <span class="custom-control-label">HQ (RT)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='13'>
                                            <span class="custom-control-label">HQ (UKK)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='14'>
                                            <span class="custom-control-label">HQ (UPK)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='15'>
                                            <span class="custom-control-label">HQ (SRS)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='16'>
                                            <span class="custom-control-label">Ketua Pengarah RT</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='17'>
                                            <span class="custom-control-label">MKP</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='18'>
                                            <span class="custom-control-label">PPD (e-Sepakat)</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-controls-stacked">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='19'>
                                            <span class="custom-control-label">PPMK (e-Sepakat)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='20'>
                                            <span class="custom-control-label">PPN (e-Sepakat)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='21'>
                                            <span class="custom-control-label">BPP (UPK)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='22'>
                                            <span class="custom-control-label">P (PP)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='23'>
                                            <span class="custom-control-label">HQ (UPMK)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='24'>
                                            <span class="custom-control-label">TKP (P)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='25'>
                                            <span class="custom-control-label">KP e-Sepakat</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='26'>
                                            <span class="custom-control-label">KPN</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-controls-stacked">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='27'>
                                            <span class="custom-control-label">Ibu Bapa / Penjaga</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='28'>
                                            <span class="custom-control-label">Guru (e-TP)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='29'>
                                            <span class="custom-control-label">PPD (e-TP)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='30'>
                                            <span class="custom-control-label">HQ (UPAKK)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='31'>
                                            <span class="custom-control-label">P (KSIN)</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="select_edit_peranan_jpnin[]" value='31'>
                                            <span class="custom-control-label">KP e-TP</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <h3 class="card-title">Kata Laluan</h3>
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group controls show-hide-wpd">
                                        <b>Kata laluan</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input type="password" name="edit_password_1" class="form-control" value="" placeholder="kata laluan anda">
                                            <div class="c_edit_password invalid-feedback text-right"></div>
                                            <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group controls show-hide-wpd">
                                        <b>Kata laluan (taip semula)</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input type="password" name="edit_password_2" class="form-control" value="{{ old('password_2') }}" placeholder="kata laluan (taip semula)">
                                            <div class="invalid-feedback text-right"></div>
                                            <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label for="select_status_ekrt_jpnin"><b>Status</b></label>
                                        <select class="custom-select" name="select_status_ekrt_jpnin" id="select_status_ekrt_jpnin">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            <option value="1">Aktif</option>
                                            <option value="2">Tidak Aktif</option>
                                        </select>
                                        <div class="c_status invalid-feedback text-right"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success" id="btn_edit_jpnin">Kemaskini</button>
                            <input type="hidden" name="user_profile_id" id="user_profile_id">
                            <input type="hidden" name="action_jpnin" value="edit">
                            <input type="hidden" name="action" id="action_jpnin" value="edit">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- Modal Orang Awam -->
        <div class="modal fade" id="ModalOrangAwam" tabindex="-1" role="dialog" aria-labelledby="ModalOrangAwamLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalOrangAwamLabel">Kemaskini Pengguna Orang Awam</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="#" id="user_orang_awam_form">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <small>Isi maklumat pada ruangan di bawah, dan tekan butang <strong>Simpan</strong> untuk menambah rekod ke pangkalan data</small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                <label for="select_peranan_orang_awam"><b>Peranan</b></label>
                                    <select class="custom-select" name="select_peranan_orang_awam" id="select_peranan_orang_awam">
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih peranan</option>
                                        @foreach($roles_user_orang_awam as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->short_description }}</option>
                                        @endforeach
                                    </select>
                                    <div class="c_role_orang_awam invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="col-md-6 negeri" style="display: none;">
                                <div class="form-group">
                                <label for="select_negeri_orang_awam"><b>Negeri</b></label>
                                    <select class="custom-select" name="select_negeri_orang_awam" id="select_negeri_orang_awam">
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        @foreach($negeri as $item)
                                        <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                        @endforeach
                                    </select>
                                    <div class="c_negeri_orang_awam invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="col-md-6 daerah" style="display: none;">
                                <div class="form-group">
                                <label for="select_daerah_orang_awam"><b>Daerah</b></label>
                                    <select class="custom-select" name="select_daerah_orang_awam" id="select_daerah_orang_awam">
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        @foreach($daerah as $item)
                                        <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                        @endforeach
                                    </select>
                                    <div class="c_daerah_orang_awam invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="col-md-6 krt" style="display: none;">
                                <div class="form-group">
                                <label for="select_krt_orang_awam"><b>Kawasan Rukun Tetangga</b></label>
                                    <select class="custom-select" name="select_krt_orang_awam" id="select_krt_orang_awam">
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        @foreach($krt as $item)
                                        <option value="{{ $item->krt_id }}">{{ $item->krt_nama }}</option>
                                        @endforeach
                                    </select>
                                    <div class="c_krt_orang_awam invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group controls show-hide-wpd">
                                    <b>Kata laluan</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-key"></i></span>
                                        </div>
                                        <input type="password" name="password_1_orang_awam" class="form-control" value="" placeholder="kata laluan anda">
                                        <div class="c_password_orang_awam invalid-feedback text-right"></div>
                                        <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group controls show-hide-wpd">
                                    <b>Kata laluan (taip semula)</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-key"></i></span>
                                        </div>
                                        <input type="password" name="password_2_orang_awam" class="form-control" value="{{ old('password_2_orang_awam') }}" placeholder="kata laluan (taip semula)">
                                        <div class="invalid-feedback text-right"></div>
                                        <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h3 class="card-title">Maklumat Personel</h3>
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <b>Nama penuh</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-mouse-pointer"></i></span>
                                        </div>
                                        <input type="text" name="name_orang_awam" class="form-control" value="{{ old('name_orang_awam') }}" placeholder="Nama penuh anda">
                                        <div class="c_name_orang_awam invalid-feedback text-right"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 for_public" style="display:none;">
                                <div class="form-group">
                                    <b>No Kad Pengenalan</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-id-card-o"></i></span>
                                        </div>
                                        <input type="text" name="ic_orang_awam" class="form-control" value="{{ old('ic_orang_awam') }}" placeholder="XXXXXX-XX-XXXX" id="no-ic">
                                        <div class="c_ic_orang_awam invalid-feedback text-right"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 for_public" style="display:none;">
                                <div class="form-group">
                                    <b>No Telefon</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                        </div>
                                        <input type="text" name="phone_orang_awam" class="form-control phone-number" value="{{ old('phone_orang_awam') }}" placeholder="Cth: 000-00000000" id="no-telefon">
                                        <div class="c_phone_orang_awam invalid-feedback text-right"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <b>Alamat email</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                        </div>
                                        <input type="email" name="email_orang_awam" id="email_orang_awam" class="form-control" value="{{ old('email') }}" placeholder="Cth: ali@email.com">
                                        <div class="c_email_orang_awam invalid-feedback text-right"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 for_public" style="display:none;">
                                <div class="form-group">
                                    <label class="form-label">Alamat: </label>
                                    <textarea class="form-control" rows="4" name="alamat_orang_awam" id="alamat_orang_awam"></textarea>
                                    <div class="c_alamat_orang_awam invalid-feedback text-right"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success" id="btn_save_orang_awam">Simpan</button>
                        <input type="hidden" name="action" id="action_orang_awam" value="edit" />
                        <input type="hidden" name="action_orang_awam" value="edit">
                        <input type="hidden" name="user_profile_id" id="user_profile_id" />
                    </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- Modal Add Pengguna KRT -->
        <div class="modal fade" id="ModalAddeKRT" tabindex="-1" role="dialog" aria-labelledby="ModaleKRTLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModaleKRTLabel">Tambah Pengguna eKRT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="#" id="user_krt_add_form">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <small>Isi maklumat pada ruangan di bawah, dan tekan butang <strong>Simpan</strong> untuk menambah rekod ke pangkalan data</small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                <label for="select_peranan_ekrt"><b>Peranan</b></label>
                                    <select class="custom-select" name="select_peranan_ekrt" id="select_peranan_ekrt">
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        @foreach($roles_user_ekrt as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->short_description }}</option>
                                        @endforeach
                                    </select>
                                    <div class="c_role_ekrt invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="col-md-6 negeri" style="display: none;">
                                <div class="form-group">
                                <label for="select_negeri_ekrt"><b>Negeri</b></label>
                                    <select class="custom-select" name="select_negeri_ekrt" id="select_negeri_ekrt">
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        @foreach($negeri as $item)
                                        <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                        @endforeach
                                    </select>
                                    <div class="c_negeri_ekrt invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="col-md-6 daerah" style="display: none;">
                                <div class="form-group">
                                <label for="select_daerah_ekrt"><b>Daerah</b></label>
                                    <select class="custom-select" name="select_daerah_ekrt" id="select_daerah_ekrt">
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        @foreach($daerah as $item)
                                        <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                        @endforeach
                                    </select>
                                    <div class="c_daerah_ekrt invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="col-md-6 krt" style="display: none;">
                                <div class="form-group">
                                <label for="select_krt_ekrt"><b>Kawasan Rukun Tetangga</b></label>
                                    <select class="custom-select" name="select_krt_ekrt" id="select_krt_ekrt">
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        @foreach($krt as $item)
                                        <option value="{{ $item->id }}">{{ $item->krt_nama }}</option>
                                        @endforeach
                                    </select>
                                    <div class="c_krt_ekrt invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-6">
                                <div class="form-group controls show-hide-wpd">
                                    <b>Kata laluan</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-key"></i></span>
                                        </div>
                                        <input type="password" name="password_1_ekrt" class="form-control" value="" placeholder="kata laluan anda">
                                        <div class="c_password_ekrt invalid-feedback text-right"></div>
                                        <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group controls show-hide-wpd">
                                    <b>Kata laluan (taip semula)</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-key"></i></span>
                                        </div>
                                        <input type="password" name="password_2_ekrt" class="form-control" value="{{ old('password_2') }}" placeholder="kata laluan (taip semula)">
                                        <div class="invalid-feedback text-right"></div>
                                        <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h3 class="card-title">Maklumat Personel</h3>
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <b>Nama penuh</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-mouse-pointer"></i></span>
                                        </div>
                                        <input type="text" name="name_ekrt" class="form-control" value="{{ old('name') }}" placeholder="Nama penuh anda">
                                        <div class="c_name_ekrt invalid-feedback text-right"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 for_public">
                                <div class="form-group">
                                    <b>No Kad Pengenalan</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-id-card-o"></i></span>
                                        </div>
                                        <input type="text" name="ic_ekrt" id="ic_ekrt" class="form-control" value="{{ old('ic') }}" placeholder="XXXXXX-XX-XXXX" >
                                        <div class="c_ic_ekrt invalid-feedback text-right"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 for_public">
                                <div class="form-group">
                                    <b>No Telefon</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                        </div>
                                        <input type="text" name="phone_ekrt" id="phone_ekrt" class="form-control phone-number" value="{{ old('phone') }}" placeholder="Cth: 000-00000000" >
                                        <div class="c_phone_ekrt invalid-feedback text-right"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <b>Alamat email</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                        </div>
                                        <input type="email" name="email_ekrt" id="email_ekrt" class="form-control" value="{{ old('email') }}" placeholder="Cth: ali@email.com" >
                                        <div class="c_email_ekrt invalid-feedback text-right"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 for_public">
                                <div class="form-group">
                                    <label class="form-label">Alamat: </label>
                                    <textarea class="form-control" rows="4" name="alamat_ekrt" id="alamat_ekrt"></textarea>
                                    <div class="c_alamat_ekrt invalid-feedback text-right"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success" id="btn_add_krt">Simpan</button>
                        <input type="hidden" name="action_krt" value="add">
                        <input type="hidden" name="action" id="action_krt" value="add">
                    </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- Modal Kemaskini Pengguna eKRT -->
        <div class="modal fade" id="ModalEditeKRT" tabindex="-1" role="dialog" aria-labelledby="ModaleKRTLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModaleKRTLabel">Kemaskini Pengguna eKRT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="#" id="user_krt_edit_form">
                    {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <small>Isi maklumat pada ruangan di bawah, dan tekan butang <strong>Simpan</strong> untuk menambah rekod ke pangkalan data</small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label for="select_peranan_ekrt_edit"><b>Peranan</b></label>
                                        <select class="custom-select" name="select_peranan_ekrt_edit" id="select_peranan_ekrt_edit">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($roles_user_ekrt as $item)                                    
                                            <option value="{{ $item->id }}">{{ $item->short_description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_role_ekrt_edit invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 negeri">
                                    <div class="form-group">
                                    <label for="select_negeri_ekrt_edit"><b>Negeri</b></label>
                                        <select class="custom-select" name="select_negeri_ekrt_edit" id="select_negeri_ekrt_edit">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($negeri as $item)
                                            <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_negeri_ekrt_edit invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 daerah">
                                    <div class="form-group">
                                    <label for="select_daerah_ekrt_edit"><b>Daerah</b></label>
                                        <select class="custom-select" name="select_daerah_ekrt_edit" id="select_daerah_ekrt_edit">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($daerah as $item)
                                            <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_daerah_ekrt_edit invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 krt">
                                    <div class="form-group">
                                    <label for="select_krt_ekrt_edit"><b>Kawasan Rukun Tetangga</b></label>
                                        <select class="custom-select" name="select_krt_ekrt_edit" id="select_krt_ekrt_edit">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($krt as $item)
                                            <option value="{{ $item->id }}">{{ $item->krt_nama }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_krt_ekrt_edit invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-12"></div>
                                <div class="col-md-6">
                                    <div class="form-group controls show-hide-wpd">
                                        <b>Kata laluan</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input type="password" name="password_1_ekrt_edit" class="form-control" value="" placeholder="kata laluan anda">
                                            <div class="c_password_ekrt_edit invalid-feedback text-right"></div>
                                            <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group controls show-hide-wpd">
                                        <b>Kata laluan (taip semula)</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input type="password" name="password_2_ekrt_edit" class="form-control" value="{{ old('password_2') }}" placeholder="kata laluan (taip semula)">
                                            <div class="invalid-feedback text-right"></div>
                                            <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h3 class="card-title">Maklumat Personel</h3>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>Nama penuh</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-mouse-pointer"></i></span>
                                            </div>
                                            <input type="text" name="name_ekrt_edit" class="form-control" value="{{ old('name') }}" placeholder="Nama penuh anda">
                                            <div class="c_name_ekrt_edit invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 for_public">
                                    <div class="form-group">
                                        <b>No Kad Pengenalan</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-id-card-o"></i></span>
                                            </div>
                                            <input type="text" name="ic_ekrt_edit" class="form-control" value="{{ old('ic') }}" placeholder="XXXXXX-XX-XXXX" id="no-ic" disabled>
                                            <div class="c_ic_ekrt_edit invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 for_public">
                                    <div class="form-group">
                                        <b>No Telefon</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                            </div>
                                            <input type="text" name="phone_ekrt_edit" id="phone_ekrt_edit" class="form-control phone-number" value="{{ old('phone') }}" placeholder="Cth: 000-00000000" >
                                            <div class="c_phone_ekrt_edit invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>Alamat email</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                            </div>
                                            <input type="email" name="email_ekrt_edit" id="email_ekrt_edit" class="form-control" value="{{ old('email') }}" placeholder="Cth: ali@email.com" >
                                            <div class="c_email_ekrt_edit invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 for_public">
                                    <div class="form-group">
                                        <label class="form-label">Alamat: </label>
                                        <textarea class="form-control" rows="4" name="alamat_ekrt_edit" id="alamat_ekrt_edit"></textarea>
                                        <div class="c_alamat_ekrt_edit invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label for="select_status_ekrt"><b>Status</b></label>
                                        <select class="custom-select" name="select_status_ekrt" id="select_status_ekrt">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            <option value="1">Aktif</option>
                                            <option value="2">Tidak Aktif</option>
                                        </select>
                                        <div class="c_status invalid-feedback text-right"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success" id="btn_edit_krt">Kemaskini</button>
                            <input type="hidden" name="user_profile_id" id="user_profile_id">
                            <input type="hidden" name="action_krt" value="edit">
                            <input type="hidden" name="action" id="action_krt" value="edit">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- Modal Add Pengguna SRS -->
        <div class="modal fade" id="ModalAddeSRS" tabindex="-1" role="dialog" aria-labelledby="ModaleKRTLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModaleKRTLabel">Tambah Pengguna eSRS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="#" id="user_srs_add_form">
                    {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <small>Isi maklumat pada ruangan di bawah, dan tekan butang <strong>Simpan</strong> untuk menambah rekod ke pangkalan data</small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label for="select_peranan_esrs"><b>Peranan</b></label>
                                        <select class="custom-select" name="select_peranan_esrs" id="select_peranan_esrs">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($roles_user_esrs as $item)                                    
                                            <option value="{{ $item->id }}">{{ $item->short_description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_role_esrs invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 negeri">
                                    <div class="form-group">
                                    <label for="select_negeri_esrs"><b>Negeri</b></label>
                                        <select class="custom-select" name="select_negeri_esrs" id="select_negeri_esrs">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($negeri as $item)
                                            <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_negeri_esrs invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 daerah">
                                    <div class="form-group">
                                    <label for="select_daerah_esrs"><b>Daerah</b></label>
                                        <select class="custom-select" name="select_daerah_esrs" id="select_daerah_esrs" disabled>
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($daerah as $item)
                                            <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_daerah_esrs invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 krt">
                                    <div class="form-group">
                                    <label for="select_krt_esrs"><b>Kawasan Rukun Tetangga</b></label>
                                        <select class="custom-select" name="select_krt_esrs" id="select_krt_esrs" disabled>
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($krt as $item)
                                            <option value="{{ $item->krt_id }}">{{ $item->krt_nama }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_krt_esrs invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 krt">
                                    <div class="form-group">
                                    <label for="select_krt_esrs"><b>Skim Rondaan Sukarela</b></label>
                                        <select class="custom-select" name="select_srs_esrs" id="select_srs_esrs" disabled>
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($srs as $item)
                                            <option value="{{ $item->id }}">{{ $item->srs_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_srs_esrs invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group controls show-hide-wpd">
                                        <b>Kata laluan</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input type="password" name="password_1_esrs" class="form-control" value="" placeholder="kata laluan anda">
                                            <div class="c_password_esrs invalid-feedback text-right"></div>
                                            <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group controls show-hide-wpd">
                                        <b>Kata laluan (taip semula)</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input type="password" name="password_2_esrs" class="form-control" value="{{ old('password_2') }}" placeholder="kata laluan (taip semula)">
                                            <div class="invalid-feedback text-right"></div>
                                            <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h3 class="card-title">Maklumat Personel</h3>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>Nama penuh</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-mouse-pointer"></i></span>
                                            </div>
                                            <input type="text" name="name_esrs" class="form-control" value="{{ old('name') }}" placeholder="Nama penuh anda">
                                            <div class="c_name_esrs invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 for_public">
                                    <div class="form-group">
                                        <b>No Kad Pengenalan</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-id-card-o"></i></span>
                                            </div>
                                            <input type="text" name="ic_esrs" id="ic_esrs" class="form-control" value="{{ old('ic') }}" placeholder="XXXXXXXXXXXX" >
                                            <div class="c_ic_esrs invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 for_public">
                                    <div class="form-group">
                                        <b>No Telefon</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                            </div>
                                            <input type="text" name="phone_esrs" class="form-control phone-number" value="{{ old('phone') }}" placeholder="Cth: 000-00000000" id="no-telefon">
                                            <div class="c_phone_esrs invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>Alamat email</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                            </div>
                                            <input type="email" name="email_esrs" class="form-control" value="{{ old('email') }}" placeholder="Cth: ali@email.com" id="email">
                                            <div class="c_email_esrs invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 for_public">
                                    <div class="form-group">
                                        <label class="form-label">Alamat: </label>
                                        <textarea class="form-control" rows="4" name="alamat_esrs" id="alamat_esrs"></textarea>
                                        <div class="c_alamat_esrs invalid-feedback text-right"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success" id="btn_add_srs">Simpan</button>
                            <input type="hidden" name="action_srs" value="add">
                            <input type="hidden" name="action" id="action_srs" value="add">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- Modal Edit Pengguna SRS -->
        <div class="modal fade" id="ModalEditeSRS" tabindex="-1" role="dialog" aria-labelledby="ModaleKRTLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModaleKRTLabel">Kemaskini Pengguna eSRS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="#" id="user_srs_edit_form">
                    {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <small>Isi maklumat pada ruangan di bawah, dan tekan butang <strong>Kemaskini</strong> untuk menambah rekod ke pangkalan data</small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label for="select_peranan_esrs_edit"><b>Peranan</b></label>
                                        <select class="custom-select" name="select_peranan_esrs_edit" id="select_peranan_esrs_edit">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($roles_user_esrs as $item)                                    
                                            <option value="{{ $item->id }}">{{ $item->short_description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_role_esrs_edit invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 negeri">
                                    <div class="form-group">
                                    <label for="select_negeri_esrs_edit"><b>Negeri</b></label>
                                        <select class="custom-select" name="select_negeri_esrs_edit" id="select_negeri_esrs_edit">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($negeri as $item)
                                            <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_negeri_esrs_edit invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 daerah">
                                    <div class="form-group">
                                    <label for="select_daerah_esrs_edit"><b>Daerah</b></label>
                                        <select class="custom-select" name="select_daerah_esrs_edit" id="select_daerah_esrs_edit">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($daerah as $item)
                                            <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_daerah_esrs_edit invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 krt">
                                    <div class="form-group">
                                    <label for="select_krt_esrs_edit"><b>Kawasan Rukun Tetangga</b></label>
                                        <select class="custom-select" name="select_krt_esrs_edit" id="select_krt_esrs_edit">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($krt as $item)
                                            <option value="{{ $item->id }}">{{ $item->krt_nama }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_krt_esrs_edit invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 krt">
                                    <div class="form-group">
                                    <label for="select_srs_esrs_edit"><b>Skim Rondaan Sukarela</b></label>
                                        <select class="custom-select" name="select_srs_esrs_edit" id="select_srs_esrs_edit">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($srs as $item)
                                            <option value="{{ $item->id }}">{{ $item->srs_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_srs_esrs_edit invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group controls show-hide-wpd">
                                        <b>Kata laluan</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input type="password" name="password_1_esrs_edit" class="form-control" value="" placeholder="kata laluan anda">
                                            <div class="c_password_esrs_edit invalid-feedback text-right"></div>
                                            <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group controls show-hide-wpd">
                                        <b>Kata laluan (taip semula)</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input type="password" name="password_2_esrs_edit" class="form-control" value="{{ old('password_2') }}" placeholder="kata laluan (taip semula)">
                                            <div class="invalid-feedback text-right"></div>
                                            <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h3 class="card-title">Maklumat Personel</h3>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>Nama penuh</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-mouse-pointer"></i></span>
                                            </div>
                                            <input type="text" name="name_esrs_edit" class="form-control" value="{{ old('name') }}" placeholder="Nama penuh anda">
                                            <div class="c_name_esrs_edit invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 for_public">
                                    <div class="form-group">
                                        <b>No Kad Pengenalan</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-id-card-o"></i></span>
                                            </div>
                                            <input type="text" name="ic_esrs_edit" id="ic_esrs_edit" class="form-control" value="{{ old('ic') }}" placeholder="XXXXXX-XX-XXXX">
                                            <div class="c_ic_esrs_edit invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 for_public">
                                    <div class="form-group">
                                        <b>No Telefon</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                            </div>
                                            <input type="text" name="phone_esrs_edit" id="phone_esrs_edit" class="form-control phone-number" value="{{ old('phone') }}" placeholder="Cth: 000-00000000" >
                                            <div class="c_phone_esrs_edit invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>Alamat email</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                            </div>
                                            <input type="email" name="email_esrs_edit" id="email_esrs_edit" class="form-control" value="{{ old('email') }}" placeholder="Cth: ali@email.com" >
                                            <div class="c_email_esrs_edit invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 for_public">
                                    <div class="form-group">
                                        <label class="form-label">Alamat: </label>
                                        <textarea class="form-control" rows="4" name="alamat_esrs_edit" id="alamat_esrs_edit"></textarea>
                                        <div class="c_alamat_esrs_edit invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label for="select_status_ekrt"><b>Status</b></label>
                                        <select class="custom-select" name="select_status_esrs" id="select_status_esrs">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            <option value="1">Aktif</option>
                                            <option value="2">Tidak Aktif</option>
                                        </select>
                                        <div class="c_status_esrs invalid-feedback text-right"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success" id="btn_edit_srs">Kemaskini</button>
                            <input type="hidden" name="user_profile_id" id="user_profile_id">
                            <input type="hidden" name="action_srs" value="edit">
                            <input type="hidden" name="action" id="action_srs" value="edit">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- Modal Add Pengguna e-Sepakat -->
        <div class="modal fade" id="ModalAddeSepakat" tabindex="-1" role="dialog" aria-labelledby="ModaleSepakatLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModaleSepakatLabel">Tambah Pengguna e-Sepakat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="#" id="user_eSepakat_add_form">
                    {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <small>Isi maklumat pada ruangan di bawah, dan tekan butang <strong>Simpan</strong> untuk menambah rekod ke pangkalan data</small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label for="select_peranan_sepakat"><b>Peranan</b></label>
                                        <select class="custom-select" name="select_peranan_sepakat" id="select_peranan_sepakat">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih peranan</option>
                                            @foreach($roles_user_sepakat as $item)                                    
                                            <option value="{{ $item->id }}">{{ $item->short_description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_peranan_sepakat invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 negeri" style="display: none;">
                                    <div class="form-group">
                                    <label for="select_negeri_sepakat"><b>Negeri</b></label>
                                        <select class="custom-select" name="select_negeri_sepakat" id="select_negeri_sepakat">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih negeri</option>
                                            @foreach($negeri as $item)
                                            <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_negeri_sepakat invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 daerah" style="display: none;">
                                    <div class="form-group">
                                    <label for="select_daerah_sepakat"><b>Daerah</b></label>
                                        <select class="custom-select" name="select_daerah_sepakat" id="select_daerah_sepakat">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih daerah</option>
                                            @foreach($daerah as $item)
                                            <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_daerah_sepakat invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group controls show-hide-wpd">
                                        <b>Kata laluan</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input type="password" name="password_1_sepakat" class="form-control" value="" placeholder="kata laluan anda">
                                            <div class="c_password_sepakat invalid-feedback text-right"></div>
                                            <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group controls show-hide-wpd">
                                        <b>Kata laluan (taip semula)</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input type="password" name="password_2_sepakat" class="form-control" value="{{ old('password_2') }}" placeholder="kata laluan (taip semula)">
                                            <div class="invalid-feedback text-right"></div>
                                            <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h3 class="card-title">Maklumat Personel</h3>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>Nama penuh</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-mouse-pointer"></i></span>
                                            </div>
                                            <input type="text" name="name_sepakat" class="form-control" value="{{ old('name') }}" placeholder="nama penuh anda">
                                            <div class="c_name_sepakat invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <b>No Kad Pengenalan</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-id-card-o"></i></span>
                                            </div>
                                            <input type="text" name="ic_sepakat" class="form-control" value="{{ old('ic') }}" placeholder="XXXXXX-XX-XXXX" id="no-ic">
                                            <div class="c_ic_sepakat invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <b>No Telefon</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                            </div>
                                            <input type="text" name="phone_sepakat" id="phone_sepakat" class="form-control phone-number" value="{{ old('phone') }}" placeholder="Cth: 000-00000000" >
                                            <div class="c_phone_sepakat invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>Alamat email</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                            </div>
                                            <input type="email" name="email_sepakat" id="email_sepakat" class="form-control" value="{{ old('email') }}" placeholder="Cth: ali@email.com">
                                            <div class="c_email_sepakat invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success" id="btn_save_sepakat">Simpan</button>
                            <input type="hidden" name="action_sepakat" value="add">
                            <input type="hidden" name="action" id="action_sepakat" value="add">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- Modal Edit Pengguna e-Sepakat -->
        <div class="modal fade" id="ModalEditeSepakat" tabindex="-1" role="dialog" aria-labelledby="ModaleSepakatLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModaleSepakatLabel">Kemaskini Pengguna e-Sepakat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="#" id="user_eSepakat_edit_form">
                    {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <small>Isi maklumat pada ruangan di bawah, dan tekan butang <strong>Simpan</strong> untuk menambah rekod ke pangkalan data</small>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label for="select_peranan_sepakat_edit"><b>Peranan</b></label>
                                        <select class="custom-select" name="select_peranan_sepakat_edit" id="select_peranan_sepakat_edit">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih peranan</option>
                                            @foreach($roles_user_sepakat as $item)                                    
                                            <option value="{{ $item->id }}">{{ $item->short_description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_peranan_sepakat_edit invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 negeri" style="display: none;">
                                    <div class="form-group">
                                    <label for="select_negeri_sepakat_edit"><b>Negeri</b></label>
                                        <select class="custom-select" name="select_negeri_sepakat_edit" id="select_negeri_sepakat_edit">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih negeri</option>
                                            @foreach($negeri as $item)
                                            <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_negeri_sepakat_edit invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 daerah" style="display: none;">
                                    <div class="form-group">
                                    <label for="select_daerah_sepakat_edit"><b>Daerah</b></label>
                                        <select class="custom-select" name="select_daerah_sepakat_edit" id="select_daerah_sepakat_edit">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih daerah</option>
                                            @foreach($daerah as $item)
                                            <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                            @endforeach
                                        </select>
                                        <div class="c_daerah_sepakat_edit invalid-feedback text-right"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group controls show-hide-wpd">
                                        <b>Kata laluan</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input type="password" name="password_1_sepakat_edit" class="form-control" value="" placeholder="kata laluan anda">
                                            <div class="c_password_sepakat_edit invalid-feedback text-right"></div>
                                            <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group controls show-hide-wpd">
                                        <b>Kata laluan (taip semula)</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input type="password" name="password_2_sepakat_edit" class="form-control" value="{{ old('password_2') }}" placeholder="kata laluan (taip semula)">
                                            <div class="invalid-feedback text-right"></div>
                                            <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h3 class="card-title">Maklumat Personel</h3>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>Nama penuh</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-mouse-pointer"></i></span>
                                            </div>
                                            <input type="text" name="name_sepakat_edit" class="form-control" value="{{ old('name') }}" placeholder="nama penuh anda">
                                            <div class="c_name_sepakat_edit invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <b>No Kad Pengenalan</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-id-card-o"></i></span>
                                            </div>
                                            <input type="text" name="ic_sepakat_edit" id="ic_sepakat_edit" class="form-control" value="{{ old('ic') }}" placeholder="XXXXXX-XX-XXXX" disabled>
                                            <div class="ic_sepakat_edit invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <b>No Telefon</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                            </div>
                                            <input type="text" name="phone_sepakat_edit" id="phone_sepakat_edit" class="form-control phone-number" value="{{ old('phone') }}" placeholder="Cth: 000-00000000" >
                                            <div class="c_phone_sepakat_edit invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>Alamat email</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                            </div>
                                            <input type="email" name="email_sepakat_edit" id="email_sepakat_edit" class="form-control" value="{{ old('email') }}" placeholder="Cth: ali@email.com">
                                            <div class="c_email_sepakat_edit invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label for="select_status_ekrt"><b>Status</b></label>
                                        <select class="custom-select" name="select_status_sepakat" id="select_status_sepakat">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            <option value="1">Aktif</option>
                                            <option value="2">Tidak Aktif</option>
                                        </select>
                                        <div class="c_select_status_sepakat invalid-feedback text-right"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success" id="btn_edit_sepakat">Kemaskini</button>
                            <input type="hidden" name="action_sepakat" value="edit">
                            <input type="hidden" name="action" id="action_sepakat" value="edit">
                            <input type="hidden" name="user_profile_id" id="user_profile_id">
                        </div>
                    </form>
                </div>
            </div>
        </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style>    
    #user_jpnin_table_filter, #parlimen_table_filter, #dun_table_filter, #pbt_table_filter, #bandar_table_filter  {
        display: none;
    }
    #orang_awam_table_filter, #parlimen_table_filter, #dun_table_filter, #pbt_table_filter, #bandar_table_filter  {
        display: none;
    }
    div.dataTables_processing {
        z-index: 1;
    }
    .modal-dialog {
        max-width: 900px;
    }
    .controls.show-hide-wpd span.icon-eye.show-pwd {
        position: absolute;
        right: 10px;
        top: 0px;
        height: 28px;
        padding-top: 10px;
        width: 45px;
        text-align: center;
        cursor: pointer;
    }
</style>
@stop

@include('js.pengurusan.j-pengguna')