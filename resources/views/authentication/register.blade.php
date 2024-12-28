<!doctype html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<link rel="icon" href="{{ asset('assets/images/jata.png') }}" type="image/x-icon">

<title>Daftar Pengguna Baru ke Sistem Maklumat Perpaduan</title>

<!-- Bootstrap Core and vandor -->
<link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.min.css" />

<!-- Core css -->
<link rel="stylesheet" href="../assets/css/main.css"/>
<link rel="stylesheet" href="../assets/css/theme1.css"/>

</head>
<body class="font-montserrat sidebar_dark">
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

    .auth .auth_left {
        background: #203979;
    }

    .auth .auth_right {
        /* background: url("/images/Login_Page/background_login_1.png");
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        background-size: cover;
        height: 100%; */

        background: url("/images/Login_Page/new_bg_6.jpg");
        background-repeat: no-repeat;
        background-position: center;
        /* background-attachment: fixed; */
        background-size: cover;
        height: 100%;
        text-align: right !important;
        padding-right: 50px;
    }

    img {
        /* display: block; */
        margin-left: auto;
        margin-right: auto;
    }

    table {
        margin:5px;
        font-size:14px;
        font-weight: 900;
        border-collapse: collapse;
    }
    th{
        font-weight: normal;
    }

    .auth_right_footer {
        position: fixed;
        /* left: 0; */
        bottom: 0;
        height: 120px;
        /* background-color: #203979; */
        /* background-color: #004660; */
        color: white;
        text-align: right;
        width: calc(100% - 400px);
        font-size: 12px;
    }

    .jpnin {
        font-weight: bold;
        color: #ffffff;
        font-size: 16px;
        margin-bottom: 50px;
        text-shadow: 2px 2px #203979;
    }

    .smp {
        font-weight: bold;
        /* color: #1c3269; */
        color: #ffffff;
        font-size: 30px;
        text-shadow: 3px 3px #203979;
    }

    .smpv2 {
        font-weight: bold;
        color: #ffffff;
        font-size: 70px;
        text-shadow: 4px 4px #203979;
        margin-bottom: 1px !important;
    }

</style>
<div class="auth">
    <div class="auth_left">
        <div class="card">
            <!-- <div class="text-center mb-2">
                <img src="{{ asset('assets/images/jata.png') }}" width="100px">
            </div> -->
            <div class="card-body" style="padding: 5px 20px 5px 20px !important;">
                <!-- <form method="POST" action="{{ route('authentication.doregister') }}">
                    @csrf -->
                <form action="#" id="register_form">
                    {{ csrf_field() }}
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12">
                            <!-- <h3 class="card-title">Daftar Pengguna Baru</h3> -->
                            @if(\Session::has('success'))
                                <div class="form-group">
                                    <div class="col-lg-12 alert alert-success text-sm-left">
                                        <small>{{\Session::get('success')}}</small>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <h5><b>Daftar Pengguna Baru (Orang Awam)</b></h5>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="jenis_pengguna" value="3" checked>
                                        <span class="custom-control-label">Orang Awam KRT</span>
                                    </label>
                                </div>
                                <!-- <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="jenis_pengguna" value="2">
                                        <span class="custom-control-label">Ibu Bapa e-TP</span>
                                    </label>
                                </div>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input enable_tb" name="jenis_pengguna" value="3">
                                        <span class="custom-control-label">Guru e-TP</span>
                                    </label>
                                </div> -->
                            </div>
                            <div class="form-group">
                                <b>No Kad Pengenalan</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card-o"></i></span>
                                    </div>
                                    <input type="text" name="ic" class="form-control" placeholder="XXXXXX-XX-XXXX" id="no-ic" maxlength="12">
                                    <!-- @if($errors->has('ic'))
                                    <div class="invalid-feedback text-right">{{ $errors->first('ic') }}</div>
                                    @endif -->
                                    <div class="c_ic invalid-feedback text-right"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group controls show-hide-wpd">
                                <b>Kata laluan</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-key"></i></span>
                                    </div>
                                    <input type="password" name="password_1" class="form-control" placeholder="kata laluan anda">
                                    <!-- @if($errors->has('password_1'))
                                    <div class="invalid-feedback text-right">{{ $errors->first('password_1') }}</div>
                                    @endif -->
                                    <div class="c_password_1 invalid-feedback text-right"></div>
                                    <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group controls show-hide-wpd">
                                <b>Kata laluan (taip semula)</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-key"></i></span>
                                    </div><input type="password" name="password_2" class="form-control" placeholder="kata laluan (taip semula))">
                                    <!-- @if($errors->has('password_2'))
                                    <div class="invalid-feedback text-right">{{ $errors->first('password_2') }}</div>
                                    @endif -->
                                    <div class="c_password_2 invalid-feedback text-right"></div>
                                    <span class="icon-eye show-pwd"><span style="display: block; position: relative; top: -15px; width: 20px; right: -12px;" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tunjukkan kata laluan">&nbsp;</span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                          <hr class="mt-1">
                            <h3 class="card-title mb-2">Maklumat Personel</h3>
                            <div class="form-group">
                                <b>Nama penuh</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-mouse-pointer"></i></span>
                                    </div>
                                    <input type="text" name="name" class="form-control" placeholder="nama penuh anda">
                                    <!-- @if($errors->has('name'))
                                    <div class="invalid-feedback text-right">{{ $errors->first('name') }}</div>
                                    @endif -->
                                    <div class="c_name invalid-feedback text-right"></div>
                                </div>
                            </div>
                            <div class="form-group controls">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12">
                                        <b>No Telefon</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                            </div>
                                            <input type="text" name="phone" class="form-control phone-number" placeholder="Cth: 000-00000000" id="no-telefon">
                                            <!-- @if($errors->has('phone'))
                                            <div class="invalid-feedback text-right">{{ $errors->first('phone') }}</div>
                                            @endif -->
                                            <div class="c_name invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <b>Alamat email</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                            </div>
                                            <input type="email" name="email" class="form-control" placeholder="Cth: ali@email.com" id="email">
                                            <!-- @if($errors->has('email'))
                                            <div class="invalid-feedback text-right">{{ $errors->first('email') }}</div>
                                            @endif -->
                                            <div class="c_email invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6" style="display:none;" id="display_state">
                                        <div class="form-group">
                                            <b>Negeri</b>
                                            <select class="form-control" name="state" id="state" >
                                            <option value="" selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                @foreach($state as $item)
                                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                @endforeach
                                            </select>
                                            <div class="c_state invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6" style="display:none;" id="display_daerah">
                                        <div class="form-group">
                                            <b>Daerah</b>
                                            <select class="form-control" name="daerah" id="daerah" disabled>
                                            <option value="" selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            </select>
                                            <div class="c_daerah invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12" style="display:none;" id="display_tabika">
                                         <div class="form-group">
                                            <b>Tabika</b>
                                            <select class="form-control" name="tabika" id="tabika" disabled>
                                            <option value="" selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            </select>
                                            <div class="c_tabika invalid-feedback text-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <b>Kod Sekuriti</b>
                                    <div class="input-group mb-3 captcha">
                                        <span class="refereshrecapcha">{!! captcha_img() !!}</span>
                                        &nbsp;
                                        <button type="button" class="btn btn-warning btn-refresh" onclick="refreshCaptcha()"><i class="fa fa-refresh"></i></button>
                                        &nbsp;
                                        <input id="captcha" maxlength="4" name="captcha" type="text" class="form-control placeholder="Kod sekuriti">
                                        <!-- @if($errors->has('captcha'))
                                        <div class="invalid-feedback text-right">{{ $errors->first('captcha') }}</div>
                                        @endif -->
                                        <div class="c_captcha invalid-feedback text-right"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-footer mt-1">
                        <button type="submit" class="btn btn-round btn-primary btn-block" id="btn_register">Daftar Baru</button>
                        <input type="hidden" name="action_register" value="add">
                        <input type="hidden" name="action" id="action_register" value="add">
                    </div>
                </form>
            </div>
            <div class="text-center text-muted">
                Klik untuk log masuk. <a href="{{route('authentication.login')}}">Log Masuk</a>
            </div>
        </div>
    </div>
    <div class="auth_right">
    <br><br>
    <div>
        <!-- <img src="{{ asset('images/Login_Page/perpaduan_logo.png') }}" class="img-fluid" alt="login page"> -->
        <img src="{{ asset('images/Login_Page/jata.png') }}" class="img-fluid" alt="login page" style="width:150px !important; margin-top: 20px; margin-right: 0px !important;">
        <p class="jpnin"><span style="font-size: 20px !important;">JABATAN PERPADUAN NEGARA DAN INTEGRASI NASIONAL</span><br>KEMENTERIAN PERPADUAN NEGARA</p>
    </div>
    <div>
        <!-- <img src="{{ asset('images/Login_Page/sistem_maklumat_perpaduan.png') }}" class="img-fluid" alt="login page" width="500px"> -->
        <p class="smpv2">SMPv2</p>
        <p class="smp">SISTEM MAKLUMAT PERPADUAN Versi 2.0</p>
    </div>
    <div class="auth_right_footer">
      <div style="padding-top: 50px; margin-right:16%;">
          Aras 7-10, Blok E2, Kompleks E,
          Pusat Pentadbiran Kerajaan Persekutuan,
          62502 PUTRAJAYA<br>
          <!-- <img src="{{ asset('images/Login_Page/keluarga_malaysia.png') }}" style="width: 350px !important; display: block;"> -->
          Paparan Terbaik Dengan Resolusi 1280 x 720 Pelayar Versi Terkini
      </div>
    </div>
    </div>
</div>
TEST
<script src="../assets/bundles/lib.vendor.bundle.js"></script>
<script src="../assets/js/core.js"></script>
<script>
    $(document).ready( function () {

        $('input:radio').click(function() {
            if($(this).hasClass('enable_tb')) {
                $('#display_state').show();
                $('#display_daerah').show();
                $('#display_tabika').show();
            }else{
                $('#display_state').hide();
            $('#display_daerah').hide();
            $('#display_tabika').hide();
            }
        });

        //my custom script
		var register_config = {
			routes: {
				register_url: "{{ route('authentication.register') }}",
			}
		};

        $("#state").on( 'change', function () {
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#daerah').find('option').remove();
            $('#daerah').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: register_config.routes.register_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#daerah').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj)
                        {
                            $('#daerah')
                            .append($('<option>')
                            .text(obj.daerah_description)
                            .attr('value', obj.daerah_id));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        });

        $("#daerah").on( 'change', function () {
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#tabika').find('option').remove();
            $('#tabika').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: register_config.routes.register_url,
                    data: {type: 'get_tabika', value: value},
                    success: function (data) {
                        $('#tabika').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj)
                        {
                            $('#tabika')
                            .append($('<option>')
                            .text(obj.tbk_nama)
                            .attr('value', obj.id));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        });

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

    //my custom script
    var register_config = {
            routes: {
                register_url: "{{ route('authentication.doregister') }}",

            }
        };

    // click submit register
        $(document).on('submit', '#register_form', function(event){
            event.preventDefault();
            $('#btn_register').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_register').prop('disabled', true);
            var data = $("#register_form").serialize();
            var action = $('#action_register').val();
            var btn_text;
            url = register_config.routes.register_url;
            type = "POST";
            btn_text = "Daftar Baru";
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {
                $('[name=jenis_pengguna]').removeClass("is-invalid");
                $('[name=ic]').removeClass("is-invalid");
                $('[name=password_1]').removeClass("is-invalid");
                $('[name=password_2]').removeClass("is-invalid");
                $('[name=name]').removeClass("is-invalid");
                $('[name=phone]').removeClass("is-invalid");
                $('[name=email]').removeClass("is-invalid");
                $('[name=state]').removeClass("is-invalid");
                $('[name=daerah]').removeClass("is-invalid");
                $('[name=tabika]').removeClass("is-invalid");
                $('[name=captcha]').removeClass("is-invalid");

                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'ic') {
                            $('[name=ic]').addClass("is-invalid");
                            $('.c_ic').html(error);
                        }

                        if(index == 'password_1') {
                            $('[name=password_1], [name=password_2]').addClass("is-invalid");
                            $('.c_password_1').html(error);
                        }

                        if(index == 'name') {
                            $('[name=name]').addClass("is-invalid");
                            $('.c_name').html(error);
                        }

                        if(index == 'ic') {
                            $('[name=ic]').addClass("is-invalid");
                            $('.c_ic').html(error);
                        }

                        if(index == 'phone') {
                            $('[name=phone]').addClass("is-invalid");
                            $('.c_phone').html(error);
                        }

                        if(index == 'email') {
                            $('[name=email]').addClass("is-invalid");
                            $('.c_email').html(error);
                        }if(index == 'state') {$('[name=state]').addClass("is-invalid");
                            $('.c_state').html(error);
                        }

                        if(index == 'daerah') {
                            $('[name=daerah]').addClass("is-invalid");
                            $('.c_daerah').html(error);
                        }

                        if(index == 'daerah') {
                            $('[name=daerah]').addClass("is-invalid");
                            $('.c_daerah').html(error);
                        }

                        if(index == 'tabika') {
                            $('[name=tabika]').addClass("is-invalid");
                            $('.c_tabika').html(error);
                        }
                    });
                    $('#btn_register').html(btn_text);
                    $('#btn_register').prop('disabled', false);
                } else {
                    $('#register_form').trigger("reset");
                    $('#btn_register').html("Daftar Baru");
                    $('#btn_register').prop('disabled', false);
                    window.location.replace("register");
                    // window.location.href = "{{ route('authentication.login') }}";
                }
            });
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
</body>
</html>