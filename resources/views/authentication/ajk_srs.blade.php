@extends('layout.authentication')
@section('title', 'Maklumat Ahli JawatanKuasa SRS_Ahli_Peronda_Pekerjaan')


@section('content')

<div class="section-body mt-3">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-3 col-md-12">
                &nbsp;
            </div>
            <div class="col-lg-5 col-md-12">
            <div class="card">
                <br>
                <div class="text-center mb-2">
                    <img src="" class="avatar" alt="Profile Image" id="ajk_gambar" name="ajk_gambar" width="230px"/>
                </div>
                <div class="card-body">
                    <form action="#" id="register_form">
                        {{ csrf_field() }}
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12">
                                <h5 class="card-title text-center"><b>Maklumat Ahli Jawatankuasa SRS</b></h5>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <br>
                                <p>1. Maklumat Peribadi Ahli</p>
                                <hr class="mt-1">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <b>Nama :</b>
                                    <input type="text" class="form-control" name="ajk_nama" id="ajk_nama" placeholder="Nama" disabled>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Jantina: </label>
                                    <input type="text" class="form-control" name="ajk_jantina" id="ajk_jantina" placeholder="Jantina" disabled>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Warganegara: </label>
                                    <input type="text" class="form-control" name="ajk_warganegara" id="ajk_warganegara" placeholder="Warganegara" disabled>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">No Telefon: </label>
                                    <input type="text" class="form-control" name="ajk_phone" id="ajk_phone" placeholder="No Telefon" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">No Kad Pengenalan: </label>
                                    <input type="text" class="form-control" name="ajk_no_ic" id="ajk_no_ic" placeholder="No Kad Pengenalan" disabled>
                                </div>
                                <div class="form-group">
                                    <b>Tarikh Lahir: </b>
                                    <input type="text" class="form-control" name="ajk_tarikh_lahir" id="ajk_tarikh_lahir" placeholder="Tarikh Lahir" disabled>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Kaum: </label>
                                    <input type="text" class="form-control" name="ajk_kaum" id="ajk_kaum" placeholder="Kaum" disabled>
                                </div>
                                <div class="form-group">
                                    
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Alamat: </label>
                                    <textarea class="form-control" rows="5" name="ajk_alamat" id="ajk_alamat" disabled></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Poskod: </label>
                                    <input type="text" class="form-control" name="ajk_poskod" id="ajk_poskod" placeholder="Poskod" disabled>
                                </div>
                            </div>
                            <!-- <div class="col-lg-6 col-md-6 col-sm-6">
                                                    
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <br>
                                <p>2. Maklumat Jawatan AJK KRT</p>
                                <hr class="mt-1">
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Jawatan: </label>
                                    <input type="text" class="form-control" name="ajk_jawatan" id="ajk_jawatan" placeholder="Jawatan" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Tarikh Lantikan Ajk: </label>
                                    <input type="text" class="form-control" name="ajk_tarikh_mula" id="ajk_tarikh_mula" placeholder="Tarikh Lantikan Ajk" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Tarikh Tamat Ajk: </label>
                                    <input type="text" class="form-control" name="ajk_tarikh_akhir" id="ajk_tarikh_akhir" placeholder="Tarikh Tamat Ajk" disabled>
                                </div>
                            </div> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>            
</div>
@stop



@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<style type="text/css">
	.series-frame {
	  /*max-width: 600px;*/
	  display: flex;
	  justify-content: space-between;
	  align-items: center;
	  box-sizing: border-box;
	  border: 2px solid #113f50;
	  /*margin: 30px;*/
	  padding: 10px;
	}
    .blink {
        animation: blinker 1.0s linear infinite;
        color: #1c87c9;
        font-weight: bold;
        font-family: sans-serif;
    }
    @keyframes blinker {
        50% {
          opacity: 0;
        }
      }
    .avatar {
        vertical-align: middle;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        border-color: black;
    }
</style>
<script type="text/javascript"> 
    $(document).ready( function () {

        /* Maklumat Pemohonan Ahli KRT */
            $('#ajk_gambar').attr('src', "{{ asset('storage/ahli_peronda_srs') }}"+"/"+ "{{$srs_ahli_peronda->file_gambar_profile}}");
            $('#ajk_nama').val("{{$srs_ahli_peronda->peronda_nama}}");
            $('#ajk_jantina').val("{{$srs_ahli_peronda->peronda_jantina}}");
            $('#ajk_warganegara').val("{{$srs_ahli_peronda->peronda_warganegara}}");
            $('#ajk_phone').val("{{$srs_ahli_peronda->peronda_phone}}");
            $('#ajk_no_ic').val("{{$srs_ahli_peronda->peronda_ic}}");
            $('#ajk_tarikh_lahir').val("{{$srs_ahli_peronda->peronda_tarikh_lahir}}");
            $('#ajk_kaum').val("{{$srs_ahli_peronda->peronda_kaum}}");
            $('#ajk_alamat').val("{{$srs_ahli_peronda->peronda_alamat}}");
            $('#ajk_poskod').val("{{$srs_ahli_peronda->peronda_poskod}}");
    });

</script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop