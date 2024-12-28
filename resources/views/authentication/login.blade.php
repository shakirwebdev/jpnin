<!doctype html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<link rel="icon" href="{{ asset('assets/images/jata.png') }}" type="image/x-icon">

<title>Log masuk ke Sistem Maklumat Perpaduan</title>

<!-- Bootstrap Core and vandor -->
<link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.min.css" />

<!-- Core css -->
<link rel="stylesheet" href="../assets/css/main.css"/>
<link rel="stylesheet" href="../assets/css/theme1.css"/>
<script>
	function show_popup()
	{
		document.getElementById("myDialog").showModal(); 
	}
</script>
</head>
<body class="font-montserrat sidebar_dark">
<style>
    .show-pwd {
        position: absolute;
        right: 0px;
        top: 0px;
        height: 35px;
        text-align: center;
        cursor: pointer;
    }

    .auth .auth_left {
        /* background: #203979; */
        background: #263f7d;
        z-index: 1; /* Sit on top - higher than any other z-index in your site*/
        width: 490px !important;
    }

    .auth .auth_right {
        /* background: url("/images/Login_Page/background_login_1.png"); */
        /* background: url("/images/Login_Page/new_bg_1.jpg"); */
        /* background: url("/images/Login_Page/new_bg_2.jpg"); */
        /* background: url("/images/Login_Page/new_bg_3.jpg"); */
        /* background: url("/images/Login_Page/new_bg_4.jpg"); */
        /* background: url("/images/Login_Page/new_bg_5.jpg"); */
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

    .card-top {
        background-color: transparent !important;
        margin-bottom: 1px !important;
        font-size: 20px !important;
        color: #f5f5f3;
        /* font-weight: bold; */

    }
    
</style>
@include('modal.modal-bantuan')
<div class="auth">
    <div class="auth_left">
        <div class="row">
            <div class=" card card-top" style="display:block !important; font-size: 16px !important;">
                SELAMAT DATANG KE <br><span style="font-size: 20px !important;" class="font-weight-bold">SISTEM MAKLUMAT PERPADUAN v2</span>
            </div>
            <div class="card" style="font-size: 12px !important;">
                <!-- <div class="text-center mb-2">
                    <img src="{{ asset('assets/images/jata.png') }}" width="100px">
                </div> -->
                <div class="card-body">
                    <form method="POST" action="{{ route('authentication.dologin') }}" id="form_login">
                        @csrf
                        <div class="card-title">
                            <!-- <span class="font-weight-bold" style="font-size: 19px !important;">SISTEM MAKLUMAT PERPADUAN v2</span>
                            <br> -->
                            <span>Sila Masukkan No. Kad Pengenalan dan Kata Laluan:</span>
                        </div>
                        @if(\Session::has('error'))
                            <div class="form-group">
                                <div class="col-lg-12 alert alert-danger text-sm-left">
                                    <small>{{\Session::get('error')}}</small>
                                </div>
                            </div>
                        @endif
                        @if(\Session::has('success'))
                            <div class="form-group">
                                <div class="col-lg-12 alert alert-success text-sm-left">
                                    <small>{{\Session::get('success')}}</small>
                                </div>
                            </div>
                        @endif
						<div class="form-group">
						<input id="txtaction" type="hidden" name="txtaction" value="{{ old('txtaction') }}" class="form-control @error('txtaction') is-invalid @enderror">
						@error('txtaction')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
						</div>
                        <div class="form-group">
                            <label class="form-label">NO KAD PENGENALAN</label>
                            <input id="ic" type="text" class="form-control @error('ic') is-invalid @enderror" name="ic" value="{{ old('ic') }}" autocomplete="ic" autofocus>
                            @error('ic')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
						<div class="form-group controls show-hide-wpd">                                        
                            <label class="form-label">KATA LALUAN</label>
                            <div class="input-group mb-3">                                           
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
                                <div class="input-group-prepend">
                                    <span id="mata1" name="mata1" class="input-group-text show-pwd" data-toggle="tooltip" title="" ><i class="fa fa-eye"></i></span>
                                </div>
									<dialog id="myDialog" style="width:40%; background-color:#CCCCCC; border-color:#FF0000;">
											<div style="width:100%; padding-left:5px;">
												<h><span style="font-size:16px; color:#FF0000;"><center><strong>PERHATIAN !</strong></center></span></h>
												<h><span style="font-size:14px; font-weight:bold"><center>SILA KEMASKINI KATA LALUAN SISMAP ANDA.</center></span></h>
												<br><h><span style="font-size:14px;">Bagi tujuan keselamatan, pihak JPNIN ingin memohon semua pengguna SISMAP mengemaskini kata laluan mengikut format yang ditetapkan.</span></h>
											</div>
											<br>
											<div style="padding-left:20px; width:100%;">
													<div class="form-group w-50">
														<label class="form-label">NO KAD PENGENALAN</label>
														<input id="ic2" type="text" class="form-control" name="ic2" value="{{ old('ic') }}" autocomplete="ic2" readonly="readonly">
													</div>
													<div class="form-group controls show-hide-wpd">                                        
														<label class="form-label">KATA LALUAN</label>
														<div class="input-group mb-3 w-50">                                           
															<input id="password2" type="password" class="form-control @error('password2') is-invalid @enderror" name="password2" autocomplete="current-password">
															<div class="input-group-prepend">
																<span id="mata2" name="mata2" class="input-group-text show-pwd" data-toggle="tooltip" title="" ><i class="fa fa-eye"></i></span>
															</div>
															@error('password2')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
													</div>
													<div class="form-group controls show-hide-wpd">                                        
														<label class="form-label">PENGESAHAN KATA LALUAN</label>
														<div class="input-group mb-3 w-50">                                           
															<input id="password3" type="password" class="form-control @error('password3') is-invalid @enderror" name="password3" autocomplete="current-password">
															<div class="input-group-prepend">
																<span id="mata3" name="mata3" class="input-group-text show-pwd" data-toggle="tooltip" title="" ><i class="fa fa-eye"></i></span>
															</div>
															@error('password3')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
													</div>
													<div class="form-group">
														<label class="form-label">KOD SEKURITI</label>
														<div class="input-group mb-3 captcha w-50">
															<span class="refereshrecapcha">{!! captcha_img() !!}</span>
															&nbsp;
															<button type="button" class="btn btn-warning btn-refresh" onclick="refreshCaptcha()"><i class="fa fa-refresh"></i></button>
															&nbsp;
															<input id="captcha" maxlength="4" name="captcha" type="text" class="form-control @error('captcha') is-invalid @enderror" placeholder="Kod sekuriti">
															@error('captcha')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
														<div style="padding-left:20px; width:100%;">
															<span style="font-size:13px; color:#0000FF;">
																<br>Katalaluan hendaklah mengikut format berikut:
																<br>* Minimum 12 aksara
																<br>* Sekurang-kurangnya SATU(1) abjad huruf BESAR
																<br>* Sekurang-kurangnya SATU(1) nombor
																<br>* Sekurang-kurangnya SATU(1) simbol
															</span>
														</div>
													</div>
													<div style="width:100%; padding-bottom:5px;">
														<button type="button" id="updpwd" name="updpwd" class="btn btn-round btn-primary btn-block">KEMASKINI</button>
													</div>
											</div>
										</dialog>
                            	@error('password')
									@if($message == "The password format is invalid.")
                                		<script>
											show_popup();
										</script>
									@else
										<span class="invalid-feedback" role="alert">
                                    		<strong>{{ $message }}</strong>
                                		</span>
									@endif
								@enderror
							</div>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-round btn-primary btn-block">LOG MASUK</button>
                            <br>
							<div class="row">
								<div class="col-md-6" >
									<a href="{{route('authentication.register')}}"><b>Permohonan KRT Baru?</b></a>
								</div>
								<div class="col-md-6" >
									<a href="{{route('authentication.lupakatalaluan')}}"><b>Lupa katalaluan?</b></a>
								</div>
							</div>
                        </div>
                    </form>
                </div>
            </div> 
            <div class="card" style="margin-bottom:0px; height: 90px !important; box-shadow: 0 15px 25px rgba(129, 124, 124, 0.2); background-color: rgba(8, 2, 2, 0.3);">
                <!-- <div class="row justify-content-center text-center">
                    <div class="col-6">
                        <img src="{{ asset('images/Login_Page/button2.png') }}" width="30%">
                        <label class="light loginfooterlabel d-none d-sm-block">Manual</label>
                    </div>
                    <div class="col-6">
                        <img src="{{ asset('images/Login_Page/button.png') }}" width="30%">
                    </div>
                </div> -->
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="text-center icon-footer" style="margin: 0 auto;">
                            <a class="card-link light" href="{{ asset('manual/ManualSMPv2.rar') }}"><img src="{{ asset('images/Login_Page/manual.png') }}" width="30%"><br>
                            <label class="light loginfooterlabel d-sm-block">Manual</label></a>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center icon-footer" style="margin: 0 auto;">
                            <a class="card-link light" href="#" data-toggle="modal" data-target="#modal_bantuan"><img src="{{ asset('images/Login_Page/help.png') }}" width="30%"><br>
                            <label class="light loginfooterlabel d-sm-block">Bantuan</label></a>
                        </div> 
                    </div>
                    <div class="col-4">
                        <div class="text-center icon-footer" style="margin: 0 auto;">
                            <a class="card-link light" href="https://www.jpnin.gov.my"><img src="{{ asset('images/Login_Page/home.png') }}" width="30%"><br>
                            <label class="light loginfooterlabel d-sm-block">Portal Rasmi</label></a>
                        </div> 
                    </div>
                </div> 
            </div>
            <div class="text-center card card-top" style="font-size: 16px !important;">
            Hak Cipta Terpelihara
                <?php
                    $copyYear = 2022;
                    $curYear = date('Y');
                    echo $copyYear . (($copyYear != $curYear) ? '-' . $curYear : '');
                ?>
                &copy; JPNIN
            </div>
        </div>
    </div>
    <div class="auth_right">
    <br><br>
    <div align="center">
        <!-- <img src="{{ asset('images/Login_Page/perpaduan_logo.png') }}" class="img-fluid" alt="login page"> -->
        <img src="{{ asset('images/Login_Page/jata.png') }}" class="img-fluid" alt="login page" style="width:150px !important; margin-top: 20px; margin-right: 0px !important;">
        <p class="jpnin"><span style="font-size: 20px !important;">JABATAN PERPADUAN NEGARA DAN INTEGRASI NASIONAL</span><br>KEMENTERIAN PERPADUAN NEGARA</p>
    </div>
    <div align="center">
        <!-- <img src="{{ asset('images/Login_Page/sistem_maklumat_perpaduan.png') }}" class="img-fluid" alt="login page" width="500px"> -->
        <p class="smpv2">SMPv2</p>
        <p class="smp">SISTEM MAKLUMAT PERPADUAN Versi 2.0</p>
    </div>
    <div class="auth_right_footer">
        <div style="padding-top: 50px; margin-right:11%;">
            <!-- Hakcipta Terpelihara
            <?php
                $copyYear = 2022;
                $curYear = date('Y');
                echo $copyYear . (($copyYear != $curYear) ? '-' . $curYear : '');
            ?>
            &copy; JPNIN<br> -->
            Aras 7-10, Blok E2, Kompleks E,
            Pusat Pentadbiran Kerajaan Persekutuan,
            62502 PUTRAJAYA<br>
            <!-- <img src="{{ asset('images/Login_Page/keluarga_malaysia.png') }}" style="width: 350px !important; display: block;"> -->
            Paparan Terbaik Dengan Resolusi 1280 x 720 Pelayar Versi Terkini
        </div>
        
        <!-- <img src="{{ asset('images/Login_Page/footer.png') }}" class="img-fluid" alt="login page"> -->
    </div>
    
</div>
<script src="../assets/bundles/lib.vendor.bundle.js"></script>
<script src="../assets/js/core.js"></script>
<script>
    $(document).ready( function () {
	
		$var_txtaction = $('#txtaction').val();
		if($var_txtaction === 'kemaskini')
		{
			show_popup();
		}
        $('#mata1').click(function () {
            $(this).toggleClass("active");
            var input=$("#password");
            if(input.attr("type")=="text") {
                input.attr("type","password");
                $(this).css('color', '');
            } else {
                input.attr("type","text");
                $(this).css('color', 'red');
            }
        });
		$('#mata2').click(function () {
            $(this).toggleClass("active");
            var input=$("#password2");
            if(input.attr("type")=="text") {
                input.attr("type","password");
                $(this).css('color', '');
            } else {
                input.attr("type","text");
                $(this).css('color', 'red');
            }
        });
		$('#mata3').click(function () {
            $(this).toggleClass("active");
            var input=$("#password3");
            if(input.attr("type")=="text") {
                input.attr("type","password");
                $(this).css('color', '');
            } else {
                input.attr("type","text");
                $(this).css('color', 'red');
            }
        });
		$('#updpwd').click(function(){
			$('#txtaction').val('kemaskini');
			$('#form_login').submit();
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