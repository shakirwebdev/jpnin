@extends('layout.master')
@section('title', 'Profil Pengguna')

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
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="user-list" role="tabpanel">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <h6><b>MAKLUMAT ASAS PENGGUNA</b></h6>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form action="#" id="user_update_form">
                                                @csrf
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">NAMA: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="user_nama" id="user_nama" placeholder="Nama Pengguna" readonly>
                                                            <div class="error_pk12_krt_bank_nama invalid-feedback text-right"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">NO KAD PENGENALAN: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="no_kp" id="no_kp" placeholder="No Kad Pengenalan" readonly>
                                                            <div class="error_pk12_krt_bank_no_acc invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">NAMA KRT: <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" name="krt_nama" id="krt_nama" placeholder="Nama KRT" readonly>
                                                            <div class="error_pk12_krt_bank_no_evendor invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    
                                            
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">EMEL AKTIF: </label>
                                                            <input type="email" class="form-control" name="user_email" id="user_email">
                                                            <div class="error_user_email invalid-feedback text-right"></div>
                                                        </div>
                                                        
                                                    </div>
                                                       
                                                    
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">NOMBOR TELEFON: </label>
                                                            <input type="text" class="form-control" name="no_phone" id="no_phone">
                                                            <div class="error_no_phone invalid-feedback text-right"></div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-lg-6 col-md-6 col-sm-5">
                                                         <div class="form-group">
                                                            <label class="form-label">KATA LALUAN: <span class="text-red" >*</span></label>
                                                            <input type="password" name="new_password" id="new_password" class="form-control">
                                                            <button type="button" id="togglePassword" class="btn btn-outline-secondary"><i class="far fa-eye"></i></button>
                                                            <div class="error_new_password invalid-feedback text-right"></div>
                                                        </div>
                                                    </div> -->
                                                    <div class=" show-hide-wpd col-lg-6 col-md-6 col-sm-6">                                        
                                                         <label class="form-label">KATA LALUAN:</label>
                                                            <div class="input-group mb-1">                                            
                                                                <input id="new_password" type="password" class="form-control @error('password') is-invalid @enderror" name="new_password" autocomplete="current-password">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text show-pwd" data-toggle="tooltip" style="position: absolute;
        right: 0px;
        top: 0px;
        height: 35px;
        text-align: center;
        cursor: pointer;"><i class="fa fa-eye"></i></span>
                                                                </div>
                                                            </div>
                                                                @error('password')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                  <div class="form-group">
                                                    <b>Kod Sekuriti</b>
                                                    <div class="input-group mb-3 captcha">
                                                        <span class="refereshrecapcha">{!! captcha_img() !!}</span>
                                                        &nbsp;
                                                        <button type="button" class="btn btn-warning btn-refresh" onclick="refreshCaptcha()"><i class="fa fa-refresh"></i></button>
                                                        &nbsp;
                                                        <input id="captcha" maxlength="4" name="captcha" type="text" class="form-control" placeholder="Kod sekuriti">
                                                        <!-- @if($errors->has('captcha'))
                                                        <div class=" c_captcha invalid-feedback text-right">{{ $errors->first('captcha') }}</div>
                                                        @endif -->
                                                        <div class="error_captcha invalid-feedback text-right"></div>
                                                    </div>
                                                  </div>
                                                </div>

                                                <!-- button -->
                                                <div class="text-left">
                                                        <input type="hidden" name="user_profile_id" id="user_profile_id" >
                                                        <input type="hidden" name="user_profile_user_id" id="user_profile_user_id" >
                                                        <input type="hidden" name="update_user_profile" value="edit">
                                                        <input type="hidden" name="action" id="update_user_profile" value="edit">
                                                        <button type="submit" class="btn btn-primary" id="btn_send">Simpan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
                                                </div>
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
    </div>
    @stop


@include('js.j-user-profile')

  
