@extends('layout.authentication')
@section('title', 'Pendaftaran Akses dan Akaun Baru')


@section('content')
<style>
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
<div class="section-body mt-3">
    <div class="container-fluid">
        <div class="row clearfix">            
            <div class="col-lg-8 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-center">Pendaftaran Baru Pengguna Sistem Maklumat Perpaduan</h3>
                    </div>
                    <div class="card-body">
                        <div class="row ml-1 mb-4">
                            <small>Isi semua ruangan dibawah dengan maklumat yang sah dan tekan butang <strong>Daftar Baru</strong> untuk melakukan proses pendaftaran.</small>
                        </div>
                        <form method="POST" action="{{ route('authentication.doregister') }}">
                            @csrf
                            <div class="row clearfix">                                
                                <div class="col-lg-12 col-md-12">                                                                       
                                    <h3 class="card-title">Maklumat Akses</h3>
                                    <div class="form-group">
                                        <!-- <b>Kata nama</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-mouse-pointer"></i></span>
                                            </div>
                                            <input type="text" name="username" class="form-control @if ($errors->has('username')) is-invalid @endif" value="{{ old('username') }}" placeholder="kata nama">
                                            @if($errors->has('username'))
                                            <div class="invalid-feedback text-right">{{ $errors->first('username') }}</div>
                                            @endif                                            
                                        </div> -->
                                        <b>No Kad Pengenalan</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-id-card-o"></i></span>
                                            </div>
                                            <input type="text" name="ic" class="form-control @if ($errors->has('ic')) is-invalid @endif" value="{{ old('ic') }}" placeholder="XXXXXX-XX-XXXX" id="no-ic">
                                            @if($errors->has('ic'))
                                            <div class="invalid-feedback text-right">{{ $errors->first('ic') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group controls show-hide-wpd">
                                        <b>Kata laluan</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input type="password" name="password_1" class="form-control @if ($errors->has('password_1')) is-invalid @endif" value="{{ old('password_1') }}" placeholder="kata laluan anda">
                                            @if($errors->has('password_1'))
                                            <div class="invalid-feedback text-right">{{ $errors->first('password_1') }}</div>
                                            @endif
                                            <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                        </div>
                                    </div>
                                    <div class="form-group controls show-hide-wpd">
                                        <b>Kata laluan (taip semula)</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input type="password" name="password_2" class="form-control @if ($errors->has('password_2')) is-invalid @endif" value="{{ old('password_2') }}" placeholder="kata laluan (taip semula))">
                                            @if($errors->has('password_2'))
                                            <div class="invalid-feedback text-right">{{ $errors->first('password_2') }}</div>
                                            @endif
                                            <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                        </div>
                                    </div>
                                    <h3 class="card-title">Maklumat Personel</h3>
                                    <div class="form-group">
                                        <b>Nama penuh</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-mouse-pointer"></i></span>
                                            </div>
                                            <input type="text" name="name" class="form-control @if ($errors->has('name')) is-invalid @endif" value="{{ old('name') }}" placeholder="nama penuh anda">
                                            @if($errors->has('name'))
                                            <div class="invalid-feedback text-right">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group controls">
                                        <div class="row clearfix">
                                            <!-- <div class="col-lg-6 col-md-6">
                                                
                                            </div> -->
                                            <div class="col-lg-12 col-md-12">
                                                <b>No Telefon</b>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                                    </div>
                                                    <input type="text" name="phone" class="form-control phone-number @if ($errors->has('phone')) is-invalid @endif" value="{{ old('phone') }}" placeholder="Cth: 000-00000000" id="no-telefon">
                                                    @if($errors->has('phone'))
                                                    <div class="invalid-feedback text-right">{{ $errors->first('phone') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <b>Alamat email</b>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                                </div>
                                                <input type="email" name="email" class="form-control @if ($errors->has('email')) is-invalid @endif" value="{{ old('email') }}" placeholder="Cth: ali@email.com" id="email">
                                                @if($errors->has('email'))
                                                <div class="invalid-feedback text-right">{{ $errors->first('email') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-6 col-md-6">
                                                <b>Kod Sekuriti</b>
                                                <div class="input-group mb-3 captcha">
                                                    <span class="refereshrecapcha">{!! captcha_img() !!}</span>
                                                    &nbsp;
                                                    <button type="button" class="btn btn-warning btn-refresh" onclick="refreshCaptcha()"><i class="fa fa-refresh"></i></button>
                                                    &nbsp;
                                                    <input id="captcha" maxlength="4" name="captcha" type="text" class="form-control @if ($errors->has('captcha')) is-invalid @endif" placeholder="Kod sekuriti">
                                                    @if($errors->has('captcha'))
                                                    <div class="invalid-feedback text-right">{{ $errors->first('captcha') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 text-right">
                                                <div class="mb-0">&nbsp;</div>                                                
                                                <button type="submit" class="btn btn-lg btn-round btn-primary">Daftar Baru</button> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                                                     
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                    <table class="table card-table mt-2 small">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <p class="mb-0">Mengapa perlu saya mendaftar akaun baru disini?</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="width45"><span class="avatar avatar-green"><i class="fa fa-check"></i></span></td>
                                <td>
                                    <p class="mb-0">Membuat permohonan Penetapan Kawasan Rukun Tetangga (KRT), dan Skim Rondaan Sukarela (SRS)</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="width45"><span class="avatar avatar-green"><i class="fa fa-check"></i></span></td>
                                <td>
                                    <p class="mb-0">Membuat semakan permohonan Penetapan Kawasan Rukun Tetangga (KRT), dan Skim Rondaan Sukarela (SRS)</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="width45"><span class="avatar avatar-green"><i class="fa fa-check"></i></span></td>
                                <td>
                                    <p class="mb-0">Tuntutan akaun pengguna ke atas Kawasan Rukun Tetangga yang telah berdaftar</p>
                                </td>
                            </tr>
                        </tbody>
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert">
                            <div class="mb-2"><small>Jika anda telah mendaftar dengan Sistem Maklumat Perpaduan versi 2.0, sila klik butang dibawah untuk log masuk:</div>
                            <button type="button" class="btn btn-primary btn-xs mb-2" onclick="window.location.href = '{{route('authentication.login')}}';">Log Masuk</button>
                            <br>
                            atau,
                            <a href="{{route('authentication.login')}}" target="_blank">Terlupa Kata Laluan?</a>.</small>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </table>
            </div>
        </div>
    </div>            
</div>
@stop

@section('page-styles')

@stop

@section('page-script')
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>

<script>
    $(document).ready( function () {
        $('.icon-eye.show-pwd').click(function () {
            $(this).toggleClass("active");
            var input=$(this).parent().find("input");
            if(input.attr("type")=="text")
                input.attr("type","password");
            else
                input.attr("type","text");
        });

        $('#no-ic').mask('999999999999');
        $('#email').inputmask({ alias: "email" });
    });

    function refreshCaptcha(){
        $.ajax({
            url: "/secure/refresh_captcha",
            type: 'get',
            dataType: 'html',        
            success: function(json) {
                $('.refereshrecapcha').html(json);
            },
            error: function(data) {
                alert('Try Again.');
            }
        });
    }
</script>
@stop