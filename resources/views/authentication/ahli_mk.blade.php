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
                    <img src="{{ asset('storage/mkp_profile/').'/'.$kad_keahlian_mkp->mkp_file_avatar }}" class="avatar" alt="Profile Image" id="mk_gambar" name="mk_gambar" width="230px"/>
                </div>
                <div class="card-body">
                    <form action="#" id="register_form">
                        {{ csrf_field() }}
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12">
                                <h5 class="card-title text-center"><b>Maklumat Ahli MEDIATOR KOMUNITI</b></h5>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <br>
                                <p>1. Maklumat Peribadi Ahli</p>
                                <hr class="mt-1">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <b>Nama :</b>
                                    <input type="text" class="form-control" name="mk_nama" id="mk_nama" placeholder="Nama" disabled value="{{$kad_keahlian_mkp->user_fullname}}">
                                </div>
                                <div class="form-group">
                                    <b>Tarikh Lahir: </b>
                                    <input type="text" class="form-control" name="mk_tarikh_lahir" id="mk_tarikh_lahir" placeholder="Tarikh Lahir" disabled value="{{$kad_keahlian_mkp->mk_tarikh_lahir}}">
                                </div>
                                <div class="form-group">
                                    <b>Daerah: </b>
                                    <input type="text" class="form-control" name="mk_daerah" id="mk_daerah" placeholder="Daerah" disabled value="{{$kad_keahlian_mkp->mk_daerah}}">
                                </div>
                                <div class="form-group">
                                    <b>Dun:</b>
                                    <input type="text" class="form-control" name="mk_dun" id="mk_dun" placeholder="Dun" disabled value="{{$kad_keahlian_mkp->mk_dun}}">
                                </div>
                                <div class="form-group">
                                    <b>Mukim:</b>
                                    <input type="text" class="form-control" name="mk_mukim" id="mk_mukim" placeholder="Mukim" disabled value="{{$kad_keahlian_mkp->mk_mukim}}">
                                </div>
                                <div class="form-group">
                                    <b>Kaum:</b>
                                    <input type="text" class="form-control" name="mk_kaum" id="mk_kaum" placeholder="Kaum" disabled value="{{$kad_keahlian_mkp->mk_kaum}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Alamat Rumah: </label>
                                    <textarea class="form-control" rows="5" name="mk_alamat_rumah" id="mk_alamat_rumah" disabled>{{$kad_keahlian_mkp->mk_alamat_rumah}}</textarea>
                                </div>
                                <div class="form-group">
                                    <b>No Telefon:</b>
                                    <input type="text" class="form-control" name="mk_telefon" id="mk_telefon" placeholder="No Telefon" disabled value="{{$kad_keahlian_mkp->mk_telefon}}">
                                </div>
                                <div class="form-group">
                                    <b>Kategeri MK: </b>
                                    <input type="text" class="form-control" name="mk_kategori_mkp" id="mk_kategori_mkp" placeholder="Kategeri MK" disabled value="{{$kad_keahlian_mkp->mk_kategori_mkp}}">
                                </div>
                                <div class="form-group">
                                    <b>Kelulusan Akademik: </b>
                                    <input type="text" class="form-control" name="mk_akademik" id="mk_akademik" placeholder="Kelulusan Akademik" disabled value="{{$kad_keahlian_mkp->mk_akademik}}">
                                </div>
                                <div class="form-group">
                                    <b>Tarikh Pelantikan: </b>
                                    <input type="text" class="form-control" name="mk_tarikh_lantik" id="mk_tarikh_lantik" placeholder="Tarikh Pelantikan" disabled value="{{$kad_keahlian_mkp->mk_tarikh_lantik}}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <b> No Kad Pengenalan: </b>
                                    <input type="text" class="form-control" name="mk_no_ic" id="mk_no_ic" placeholder="No Kad Pengenalan" disabled value="{{$kad_keahlian_mkp->mk_no_ic}}">
                                </div>
                                <div class="form-group">
                                    <b>Negeri: </b>
                                    <input type="text" class="form-control" name="mk_negeri" id="mk_negeri" placeholder="Negeri" disabled value="{{$kad_keahlian_mkp->mk_negeri}}">
                                </div>
                                <div class="form-group">
                                    <b>Parlimen: </b>
                                    <input type="text" class="form-control" name="mk_parlimen" id="mk_parlimen" placeholder="Parlimen" disabled value="{{$kad_keahlian_mkp->mk_parlimen}}">
                                </div>
                                <div class="form-group">
                                    <b>PBT: </b>
                                    <input type="text" class="form-control" name="mk_pbt" id="mk_pbt" placeholder="PBT" disabled value="{{$kad_keahlian_mkp->mk_pbt}}">
                                </div>
                                <div class="form-group">
                                    <b>Jantina: </b>
                                    <input type="text" class="form-control" name="mk_jantina" id="mk_jantina" placeholder="Jantina" disabled value="{{$kad_keahlian_mkp->mk_jantina}}">
                                </div>
                                <div class="form-group">
                                    <b>Emel: </b>
                                    <input type="text" class="form-control" name="mk_email" id="mk_email" placeholder="Emel" disabled value="{{$kad_keahlian_mkp->user_fullname}}">
                                </div>
                                <div class="form-group">
                                    <b>Alamat Pejabat: </b>
                                    <textarea class="form-control" rows="5" name="mk_pejabat" id="mk_pejabat" disabled>{{$kad_keahlian_mkp->mk_email}}</textarea>
                                </div>
                                <div class="form-group">
                                    <b>No Telefon Pejabat: </b>
                                    <input type="text" class="form-control" name="mk_phone_pejabat" id="mk_phone_pejabat" placeholder="No Telefon Pejabat" disabled value="{{$kad_keahlian_mkp->mk_phone_pejabat}}">
                                </div>
                                <div class="form-group">
                                    <b>Tahap MKP: </b>
                                    <input type="text" class="form-control" name="mk_tahap" id="mk_tahap" placeholder="Tahap MKP" disabled value="{{$kad_keahlian_mkp->mk_tahap}}">
                                </div>
                                <div class="form-group">
                                    <b>Pengkhususan (kemahiran): </b>
                                    <input type="text" class="form-control" name="mk_kemahiran" id="mk_kemahiran" placeholder="Pengkhususan" disabled value="{{$kad_keahlian_mkp->mk_kemahiran}}">
                                </div>
                            </div>
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
            $('#mk_gambar').attr('src', "{{ asset('storage/mkp_profile') }}"+"/"+ "{{$kad_keahlian_mkp->mkp_file_avatar}}");
            $('#mk_nama').val("{{$kad_keahlian_mkp->user_fullname}}");\
            $('#mk_tarikh_lahir').val("{{$kad_keahlian_mkp->mk_tarikh_lahir}}");
            $('#mk_daerah').val("{{$kad_keahlian_mkp->mk_daerah}}");
            $('#mk_dun').val("{{$kad_keahlian_mkp->mk_dun}}");
            $('#mk_mukim').val("{{$kad_keahlian_mkp->mk_mukim}}");
            $('#mk_kaum').val("{{$kad_keahlian_mkp->mk_mukim}}");
            $('#mk_alamat_rumah').val("{{$kad_keahlian_mkp->mk_alamat_rumah}}");
            $('#mk_telefon').val("{{$kad_keahlian_mkp->mk_telefon}}");
            $('#mk_kategori_mkp').val("{{$kad_keahlian_mkp->mk_kategori_mkp}}");
            $('#mk_akademik').val("{{$kad_keahlian_mkp->mk_akademik}}");
            $('#mk_tarikh_lantik').val("{{$kad_keahlian_mkp->mk_tarikh_lantik}}");
            $('#mk_no_ic').val("{{$kad_keahlian_mkp->mk_no_ic}}");
            $('#mk_negeri').val("{{$kad_keahlian_mkp->mk_negeri}}");
            $('#mk_parlimen').val("{{$kad_keahlian_mkp->mk_parlimen}}");
            $('#mk_pbt').val("{{$kad_keahlian_mkp->mk_pbt}}");
            $('#mk_jantina').val("{{$kad_keahlian_mkp->mk_jantina}}");
            $('#mk_email').val("{{$kad_keahlian_mkp->mk_email}}");
            $('#mk_pejabat').val("{{$kad_keahlian_mkp->mk_pejabat}}");
            $('#mk_phone_pejabat').val("{{$kad_keahlian_mkp->mk_phone_pejabat}}");
            $('#mk_tahap').val("{{$kad_keahlian_mkp->mk_tahap}}");
            $('#mk_kemahiran').val("{{$kad_keahlian_mkp->mk_kemahiran}}");
            
    });

</script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop