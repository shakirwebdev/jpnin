<!doctype html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}"> 
<link rel="icon" href="{{ asset('assets/images/jata.png') }}" type="image/x-icon">

<title>Lupa Katalaluan Pengguna ke Sistem Maklumat Perpaduan</title>

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
                                <h5><b>Lupa Katalaluan Pengguna</b></h5>
                            </div>
							<div class="form-group">
                                <b>Masukkan No. Kad Pengenalan dan alamat email yang telah didaftarkan. Maklumat katalaluan akan dihantar ke alamat email yang didaftarkan sebelum ini.</b>
                            </div>
                            <div class="form-group">
                                <b>No Kad Pengenalan</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card-o"></i></span>
                                    </div>
                                    <input type="text" name="ic" class="form-control" placeholder="XXXXXXXXXXXX" id="ic" maxlength="12">
                                    <div class="c_ic invalid-feedback text-right"></div>
                                </div>
                            </div>
							<div class="form-group">
                                <b>Alamat Email</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card-o"></i></span>
                                    </div>
                                    <input type="text" name="email" class="form-control" placeholder="contoh@aaaa.com" id="email">
                                    <div class="c_email invalid-feedback text-right"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-footer mt-1">
                        <button type="submit" class="btn btn-round btn-primary btn-block" id="btn_register">Hantar</button>
                        <input type="hidden" name="action_register" value="lupa">
                        <input type="hidden" name="action" id="action_register" value="lupa">
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
<script src="../assets/bundles/lib.vendor.bundle.js"></script>
<script src="../assets/js/core.js"></script>
<script>
    $(document).ready( function () {

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
            btn_text = "Hantar";
            $.ajax({
                url: url,
                type: type,
                data: data,
				error:function(x,e) {
						if (x.status==0) {
							alert('You are offline!!\n Please Check Your Network.');
						} else if(x.status==404) {
							alert('Requested URL not found.');
						} else if(x.status==500) {
							alert('Internel Server Error.');
						} else if(e=='parsererror') {
							alert('Error.\nParsing JSON Request failed.');
						} else if(e=='timeout'){
							alert('Request Time out.');
						} else {
							alert('Unknow Error.\n'+x.responseText);
						}
					}
            }).done(function(response) {
                $('[name=ic]').removeClass("is-invalid");
                $('[name=email]').removeClass("is-invalid");
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'ic') {
                            $('[name=ic]').addClass("is-invalid");
                            $('.c_ic').html(error);
                        }
                        if(index == 'email') {
                            $('[name=email]').addClass("is-invalid");
                            $('.c_email').html(error);
                        }
                    });
                    $('#btn_register').html(btn_text);
                    $('#btn_register').prop('disabled', false);
                } else {
                    $('#register_form').trigger("reset");
                    $('#btn_register').html("Hantar");
                    $('#btn_register').prop('disabled', false);
					
                    window.location.replace("lupakatalaluan");
                    // window.location.href = "{{ route('authentication.login') }}";
                }
            });
    	});
	});
</script>
</body>
</html>
