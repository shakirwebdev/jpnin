@extends('layout.authentication')
@section('title', 'Log masuk ke Sistem Maklumat Perpaduan')


@section('content')
<style>
    .show-pwd {
        position: absolute;
        right: 0px;
        top: 0px;
        height: 35px;
        text-align: center;
        cursor: pointer;
    }
</style>
<div class="section-body mt-3">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-3 col-md-12">
                &nbsp;
            </div>
            <div class="col-lg-5 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-center">AKSES SISTEM MAKLUMAT PERPADUAN</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('authentication.dologin') }}">
                            @csrf
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12">                                                                       
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
                                        <label class="form-label">Kata nama</label>
                                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" autocomplete="username" autofocus>

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group controls show-hide-wpd">                                        
                                        <label class="form-label">Kata laluan</label>
                                        <div class="input-group mb-3">                                            
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text show-pwd" data-toggle="tooltip" title="" data-original-title="Tunjukkan katalaluan"><i class="fa fa-eye"></i></span>
                                            </div>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6">
                                    <button type="submit" class="btn btn-round btn-primary">Log Masuk ke Sistem</button>
                                </div>
                                <div class="col-lg-6 col-md-6" style="align-self: flex-end;">
                                    <small><a href="{{route('authentication.register')}}">Akaun baru?</a></small>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>            
</div>
@stop

@section('page-styles')

@stop

@section('page-script')
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>

<script>
    $(document).ready( function () {
        $('.show-pwd').click(function () {
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
    });
</script>
@stop