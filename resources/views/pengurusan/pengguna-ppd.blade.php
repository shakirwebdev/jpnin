@extends('layout.master')
@section('title', 'Pengurusan Pengguna')


@section('content')
<div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <ul class="nav nav-tabs page-header-tab">
                    <!-- <li class="nav-item"><a class="nav-link active" id="Departments-tab" data-toggle="tab" href="#ref_org_awam"><i class="fa fa-list-ul"></i>&nbsp;Pengguna Orang Awam</a></li> -->
                    <li class="nav-item"><a class="nav-link active" id="Departments-tab1" data-toggle="tab" href="#ref_krt"><i class="fa fa-list-ul"></i>&nbsp;Pengguna e-KRT</a></li>
                    <li class="nav-item"><a class="nav-link" id="Departments-tab2" data-toggle="tab" href="#ref_srs"><i class="fa fa-list-ul"></i>&nbsp;Pengguna e-SRS</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show" id="ref_org_awam" role="tabpanel">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            @if(\Session::has('success'))
                                <div class="form-group">
                                    <div class="col-lg-12 alert alert-success text-sm-left">
                                        <small>{{\Session::get('success')}}</small>
                                    </div>
                                </div>
                            @endif
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Cari pengguna..." id="myInputTextField_OrgAwam">
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
                <div class="tab-pane fade show active" id="ref_krt" role="tabpanel">
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
                                                <input type="text" class="form-control" placeholder="Cari pengguna..." id="krt_nama_penuh">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Cari No Kad Pengenalan..." id="krt_no_ic">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <br>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary" title="" data-toggle="modal" data-target="#ModalAddeKRT"><i class="fa fa-window-restore" aria-hidden="true"></i>&nbsp;&nbsp;Tambah Pengguna e-KRT</a>
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
                                                    <th style="background-color: #113f50"><font color="white">Nama KRT</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Nama Penuh</font></th>
                                                    <th style="background-color: #113f50"><font color="white">No Kad Pengenalan</font></th>
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
                                                    <th style="background-color: #113f50"><font color="white">Nama KRT</font></th>
                                                    <th style="background-color: #113f50"><font color="white">Nama Penuh</font></th>
                                                    <th style="background-color: #113f50"><font color="white">No Kad Pengenalan</font></th>
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
    <!-- Modal Kemaskini Pengguna Orang Awam -->
    <div class="modal fade" id="ModalOrangAwam" tabindex="-1" role="dialog" aria-labelledby="ModalOrangAwamLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
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
                                    <div class="c_role invalid-feedback text-right"></div>
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
                                    <div class="c_negeri invalid-feedback text-right"></div>
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
                                    <div class="c_daerah invalid-feedback text-right"></div>
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
                                    <div class="c_krt invalid-feedback text-right"></div>
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
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nama penuh anda">
                                        <div class="c_name invalid-feedback text-right"></div>
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
                                        <input type="text" name="ic" class="form-control" value="{{ old('ic') }}" placeholder="XXXXXX-XX-XXXX" id="no-ic">
                                        <div class="c_ic invalid-feedback text-right"></div>
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
                                        <input type="text" name="phone" class="form-control phone-number" value="{{ old('phone') }}" placeholder="Cth: 000-00000000" id="no-telefon">
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
                            <div class="col-md-12 for_public">
                                <div class="form-group">
                                    <label class="form-label">Alamat: </label>
                                    <textarea class="form-control" rows="4" name="alamat" id="alamat_org_awam"></textarea>
                                    <div class="c_address invalid-feedback text-right"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="user_profile_id" id="user_profile_id">
                        <input type="hidden" name="edit_orang_awam" value="edit">
                        <input type="hidden" name="action" id="edit_orang_awam" value="edit">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success" id="btn_edit_org_awam">Kemaskini</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Add Pengguna KRT -->
    <div class="modal fade" id="ModalAddeKRT" tabindex="-1" role="dialog" aria-labelledby="ModaleKRTLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
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
                                <div class="c_role invalid-feedback text-right"></div>
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
                                <div class="c_negeri invalid-feedback text-right"></div>
                            </div>
                        </div>
                        <div class="col-md-6 daerah" style="display: none;">
                            <div class="form-group">
                            <label for="select_daerah_ekrt"><b>Daerah</b></label>
                                <select class="custom-select" name="select_daerah_ekrt" id="select_daerah_ekrt" disabled>
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                </select>
                                <div class="c_daerah invalid-feedback text-right"></div>
                            </div>
                        </div>
                        <div class="col-md-6 krt" style="display: none;">
                            <div class="form-group">
                            <label for="select_krt_ekrt"><b>Kawasan Rukun Tetangga</b></label>
                                <select class="custom-select" name="select_krt_ekrt" id="select_krt_ekrt" disabled>
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                </select>
                                <div class="c_krt invalid-feedback text-right"></div>
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
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nama penuh anda">
                                    <div class="c_name invalid-feedback text-right"></div>
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
                                    <input type="text" name="ic" class="form-control" value="{{ old('ic') }}" placeholder="XXXXXX-XX-XXXX" id="no_ic_krt">
                                    <div class="c_ic invalid-feedback text-right"></div>
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
                                    <input type="text" name="phone" class="form-control phone-number" value="{{ old('phone') }}" placeholder="Cth: 000-00000000" id="no-telefon">
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
                        <div class="col-md-12 for_public">
                            <div class="form-group">
                                <label class="form-label">Alamat: </label>
                                <textarea class="form-control" rows="4" name="alamat" id="alamat_krt"></textarea>
                                <div class="c_address invalid-feedback text-right"></div>
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

    <!-- Modal Edit Pengguna KRT -->
    <div class="modal fade" id="ModalEditeKRT" tabindex="-1" role="dialog" aria-labelledby="ModaleKRTLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
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
                                <label for="select_peranan_ekrt"><b>Peranan</b></label>
                                    <select class="custom-select" name="select_peranan_ekrt_e" id="select_peranan_ekrt_e">
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        @foreach($roles_user_ekrt as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->short_description }}</option>
                                        @endforeach
                                    </select>
                                    <div class="c_role invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="col-md-6 negeri">
                                <div class="form-group">
                                <label for="select_negeri_ekrt"><b>Negeri</b></label>
                                    <select class="custom-select" name="select_negeri_ekrt_e" id="select_negeri_ekrt_e">
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        @foreach($negeri as $item)
                                        <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                        @endforeach
                                    </select>
                                    <div class="c_negeri invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="col-md-6 daerah">
                                <div class="form-group">
                                <label for="select_daerah_ekrt"><b>Daerah</b></label>
                                    <select class="custom-select" name="select_daerah_ekrt_e" id="select_daerah_ekrt_e"></select>
                                    <div class="c_daerah invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="col-md-6 krt">
                                <div class="form-group">
                                <label for="select_krt_ekrt"><b>Kawasan Rukun Tetangga</b></label>
                                    <select class="custom-select" name="select_krt_ekrt_e" id="select_krt_ekrt_e">
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                    </select>
                                    <div class="c_krt invalid-feedback text-right"></div>
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
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nama penuh anda">
                                        <div class="c_name invalid-feedback text-right"></div>
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
                                        <input type="text" name="ic_edit" class="form-control" value="{{ old('ic') }}" placeholder="XXXXXX-XX-XXXX" id="no-ic" disabled>
                                        <div class="c_ic invalid-feedback text-right"></div>
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
                                        <input type="text" name="phone" class="form-control phone-number" value="{{ old('phone') }}" placeholder="Cth: 000-00000000" id="no-telefon">
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
                            <div class="col-md-12 for_public">
                                <div class="form-group">
                                    <label class="form-label">Alamat: </label>
                                    <textarea class="form-control" rows="4" name="alamat" id="alamat_krt_edit"></textarea>
                                    <div class="c_address invalid-feedback text-right"></div>
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
        <div class="modal-dialog" role="document">
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
                                <div class="c_role invalid-feedback text-right"></div>
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
                                <div class="c_negeri invalid-feedback text-right"></div>
                            </div>
                        </div>
                        <div class="col-md-6 daerah">
                            <div class="form-group">
                            <label for="select_daerah_esrs"><b>Daerah</b></label>
                                <select class="custom-select" name="select_daerah_esrs" id="select_daerah_esrs" disabled>
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                </select>
                                <div class="c_daerah invalid-feedback text-right"></div>
                            </div>
                        </div>
                        <div class="col-md-6 krt">
                            <div class="form-group">
                            <label for="select_krt_esrs"><b>Kawasan Rukun Tetangga</b></label>
                                <select class="custom-select" name="select_krt_esrs" id="select_krt_esrs" disabled>
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                </select>
                                <div class="c_krt invalid-feedback text-right"></div>
                            </div>
                        </div>
                        <div class="col-md-6 krt">
                            <div class="form-group">
                            <label for="select_krt_esrs"><b>Skim Rondaan Sukarela</b></label>
                                <select class="custom-select" name="select_srs_esrs" id="select_srs_esrs" disabled>
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                </select>
                                <div class="c_krt invalid-feedback text-right"></div>
                            </div>
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
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nama penuh anda">
                                    <div class="c_name invalid-feedback text-right"></div>
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
                                    <input type="text" name="ic" class="form-control" value="{{ old('ic') }}" placeholder="XXXXXX-XX-XXXX" id="no_ic_srs">
                                    <div class="c_ic invalid-feedback text-right"></div>
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
                                    <input type="text" name="phone" class="form-control phone-number" value="{{ old('phone') }}" placeholder="Cth: 000-00000000" id="no-telefon">
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
                        <div class="col-md-12 for_public">
                            <div class="form-group">
                                <label class="form-label">Alamat: </label>
                                <textarea class="form-control" rows="4" name="alamat" id="alamat_srs"></textarea>
                                <div class="c_address invalid-feedback text-right"></div>
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
        <div class="modal-dialog" role="document">
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
                                <label for="select_peranan_esrs"><b>Peranan</b></label>
                                    <select class="custom-select" name="select_peranan_esrs_e" id="select_peranan_esrs_e">
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        @foreach($roles_user_esrs as $item)                                    
                                        <option value="{{ $item->id }}">{{ $item->short_description }}</option>
                                        @endforeach
                                    </select>
                                    <div class="c_role invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="col-md-6 negeri">
                                <div class="form-group">
                                <label for="select_negeri_esrs"><b>Negeri</b></label>
                                    <select class="custom-select" name="select_negeri_esrs_e" id="select_negeri_esrs_e">
                                        <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        @foreach($negeri as $item)
                                        <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                        @endforeach
                                    </select>
                                    <div class="c_negeri invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="col-md-6 daerah">
                                <div class="form-group">
                                <label for="select_daerah_esrs"><b>Daerah</b></label>
                                    <select class="custom-select" name="select_daerah_esrs_e" id="select_daerah_esrs_e"></select>
                                    <div class="c_daerah invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="col-md-6 krt">
                                <div class="form-group">
                                <label for="select_krt_esrs"><b>Kawasan Rukun Tetangga</b></label>
                                    <select class="custom-select" name="select_krt_esrs_e" id="select_krt_esrs_e"></select>
                                    <div class="c_krt invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="col-md-6 krt">
                                <div class="form-group">
                                <label for="select_krt_esrs"><b>Skim Rondaan Sukarela</b></label>
                                    <select class="custom-select" name="select_srs_esrs_e" id="select_srs_esrs_e"></select>
                                    <div class="c_srs invalid-feedback text-right"></div>
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
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nama penuh anda">
                                        <div class="c_name invalid-feedback text-right"></div>
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
                                        <input type="text" name="ic_edit" class="form-control" value="{{ old('ic') }}" placeholder="XXXXXX-XX-XXXX" id="no-ic" disabled>
                                        <div class="c_ic invalid-feedback text-right"></div>
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
                                        <input type="text" name="phone" class="form-control phone-number" value="{{ old('phone') }}" placeholder="Cth: 000-00000000" id="no-telefon">
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
                            <div class="col-md-12 for_public">
                                <div class="form-group">
                                    <label class="form-label">Alamat: </label>
                                    <textarea class="form-control" rows="4" name="alamat" id="alamat_srs_edit"></textarea>
                                    <div class="c_address invalid-feedback text-right"></div>
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
                                    <div class="c_status invalid-feedback text-right"></div>
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
@stop


@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style>    
    #user_jpnin_table_filter, #parlimen_table_filter, #dun_table_filter, #pbt_table_filter, #bandar_table_filter  {
        display: none;
    }
    div.dataTables_processing {
        z-index: 1;
    }
    .modal-dialog {
        max-width: 600px;
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



@include('js.pengurusan.j-pengguna-ppd')
