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
</style>
<script type="text/javascript">    

	$(document).ready( function () {

		/* Maklumat Kawasan Krt */
            $('#pkpd_nama_krt').html("{{$krt_profile->nama_krt}}");
            $('#pkpd_alamat_krt').html("{{$krt_profile->alamat_krt}}");
            $('#pkpd_negeri_krt').html("{{$krt_profile->negeri_krt}}");
            $('#pkpd_parlimen_krt').html("{{$krt_profile->parlimen_krt}}");
            $('#pkpd_pbt_krt').html("{{$krt_profile->pbt_krt}}");
            $('#pkpd_daerah_krt').html("{{$krt_profile->daerah_krt}}");
            $('#pkpd_dun_krt').html("{{$krt_profile->dun_krt}}");

        /* Maklumat Laporan Pemulihan KRT */
            $('#pkpd1_krt_profile_id').val("{{$krt_profile->id}}");

            $('#pkpd1_pemulihan_krt_id').val("{{$krt_profile->krt_pemulihan_id}}");
            $('#pkpd1_pemulihan_tempoh_bulan').val("{{$krt_profile->pemulihan_tempoh_bulan}}");
            $('#pkpd1_pemulihan_punca_tidak_aktif').val("{{$krt_profile->pemulihan_punca_tidak_aktif}}");
            $('#pkpd1_pemulihan_suku_thn_1').val("{{$krt_profile->pemulihan_suku_thn_1}}");
            $('#pkpd1_pemulihan_suku_thn_2').val("{{$krt_profile->pemulihan_suku_thn_2}}");
            $('#pkpd1_pemulihan_suku_thn_3').val("{{$krt_profile->pemulihan_suku_thn_3}}");
            $('#pkpd1_pemulihan_suku_thn_4').val("{{$krt_profile->pemulihan_suku_thn_4}}");
            $('#pkpd1_pemulihan_tempoh_pelaksanaan').val("{{$krt_profile->pemulihan_tempoh_pelaksanaan}}");
            $('#pkpd1_pemulihan_cadangan_ppd').val("{{$krt_profile->pemulihan_cadangan_ppd}}");
            $('#pkpd1_pemulihan_cadangan_hq').val("{{$krt_profile->pemulihan_cadangan_hq}}");

        /* Maklumat Note Kemaskini */
            $('#pkpd_status').val("{{$krt_profile->status}}");
            
            if($('#pkpd_status').val() == '3'){
                $("#pkpd_perlu_kemaskini").show();
                $('#pkpd_status_description').html("{{$krt_profile->status_description}}");
                $('#pkpd_disemak_note').html("{{$krt_profile->disemak_note}}");
                $("#btn_submit").hide();
                $("#btn_submit2").show();
            }

        /* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{ route('rt-sm11.pemulihan_krt_ppd') }}";
            });
        
    });

    //my custom script
        var add_laporan_pemulihan_config = {
            routes: {
                add_laporan_pemulihan_url: "{{ route('rt-sm11.post_laporan_pemulihan') }}",
                edit_laporan_pemulihan_url: "{{ route('rt-sm11.post_laporan_pemulihan2') }}",
            }
        };

        $(document).on('click', '#btn_submit', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data   = $("#form_pkpd1").serialize();
            var action = $('#post_laporan_pemulihan').val();
            var btn_text;
            if (action == 'add') {
                url = add_laporan_pemulihan_config.routes.add_laporan_pemulihan_url;
                type = "POST";
                btn_text = 'Hantar Laporan Pemulihan KRT &nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=pkpd1_pemulihan_tempoh_bulan]').removeClass("is-invalid");
                $('[name=pkpd1_pemulihan_punca_tidak_aktif]').removeClass("is-invalid");
                $('[name=pkpd1_pemulihan_suku_thn_1]').removeClass("is-invalid");
                $('[name=pkpd1_pemulihan_suku_thn_2]').removeClass("is-invalid");
                $('[name=pkpd1_pemulihan_suku_thn_3]').removeClass("is-invalid");
                $('[name=pkpd1_pemulihan_suku_thn_4]').removeClass("is-invalid");
                $('[name=pkpd1_pemulihan_tempoh_pelaksanaan]').removeClass("is-invalid");
                $('[name=pkpd1_pemulihan_cadangan_ppd]').removeClass("is-invalid");
                $('[name=pkpd1_pemulihan_cadangan_hq]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'pkpd1_pemulihan_tempoh_bulan') {
                            $('[name=pkpd1_pemulihan_tempoh_bulan]').addClass("is-invalid");
                            $('.error_pkpd1_pemulihan_tempoh_bulan').html(error);
                        }

                        if(index == 'pkpd1_pemulihan_punca_tidak_aktif') {
                            $('[name=pkpd1_pemulihan_punca_tidak_aktif]').addClass("is-invalid");
                            $('.error_pkpd1_pemulihan_punca_tidak_aktif').html(error);
                        }

                        if(index == 'pkpd1_pemulihan_suku_thn_1') {
                            $('[name=pkpd1_pemulihan_suku_thn_1]').addClass("is-invalid");
                            $('.error_pkpd1_pemulihan_suku_thn_1').html(error);
                        }

                        if(index == 'pkpd1_pemulihan_suku_thn_2') {
                            $('[name=pkpd1_pemulihan_suku_thn_2]').addClass("is-invalid");
                            $('.error_pkpd1_pemulihan_suku_thn_2').html(error);
                        }

                        if(index == 'pkpd1_pemulihan_suku_thn_3') {
                            $('[name=pkpd1_pemulihan_suku_thn_3]').addClass("is-invalid");
                            $('.error_pkpd1_pemulihan_suku_thn_3').html(error);
                        }

                        if(index == 'pkpd1_pemulihan_suku_thn_4') {
                            $('[name=pkpd1_pemulihan_suku_thn_4]').addClass("is-invalid");
                            $('.error_pkpd1_pemulihan_suku_thn_4').html(error);
                        }

                        if(index == 'pkpd1_pemulihan_tempoh_pelaksanaan') {
                            $('[name=pkpd1_pemulihan_tempoh_pelaksanaan]').addClass("is-invalid");
                            $('.error_pkpd1_pemulihan_tempoh_pelaksanaan').html(error);
                        }

                        if(index == 'pkpd1_pemulihan_cadangan_ppd') {
                            $('[name=pkpd1_pemulihan_cadangan_ppd]').addClass("is-invalid");
                            $('.error_pkpd1_pemulihan_cadangan_ppd').html(error);
                        }

                        if(index == 'pkpd1_pemulihan_cadangan_hq') {
                            $('[name=pkpd1_pemulihan_cadangan_hq]').addClass("is-invalid");
                            $('.error_pkpd1_pemulihan_cadangan_hq').html(error);
                        }

                    });
                    $('#btn_submit').html(btn_text);                
                    $('#btn_submit').prop('disabled', false);            
                } else {
                    $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm11.pemulihan_krt_ppd')}}";
                }
            });
        });

        $(document).on('click', '#btn_submit2', function(event){    
            event.preventDefault();
            $('#btn_submit2').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit2').prop('disabled', true);
            var data   = $("#form_pkpd1").serialize();
            var action = $('#post_laporan_pemulihan2').val();
            var btn_text;
            if (action == 'edit') {
                url = add_laporan_pemulihan_config.routes.edit_laporan_pemulihan_url;
                type = "POST";
                btn_text = 'Hantar Laporan Pemulihan KRT &nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=pkpd1_pemulihan_tempoh_bulan]').removeClass("is-invalid");
                $('[name=pkpd1_pemulihan_punca_tidak_aktif]').removeClass("is-invalid");
                $('[name=pkpd1_pemulihan_suku_thn_1]').removeClass("is-invalid");
                $('[name=pkpd1_pemulihan_suku_thn_2]').removeClass("is-invalid");
                $('[name=pkpd1_pemulihan_suku_thn_3]').removeClass("is-invalid");
                $('[name=pkpd1_pemulihan_suku_thn_4]').removeClass("is-invalid");
                $('[name=pkpd1_pemulihan_tempoh_pelaksanaan]').removeClass("is-invalid");
                $('[name=pkpd1_pemulihan_cadangan_ppd]').removeClass("is-invalid");
                $('[name=pkpd1_pemulihan_cadangan_hq]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'pkpd1_pemulihan_tempoh_bulan') {
                            $('[name=pkpd1_pemulihan_tempoh_bulan]').addClass("is-invalid");
                            $('.error_pkpd1_pemulihan_tempoh_bulan').html(error);
                        }

                        if(index == 'pkpd1_pemulihan_punca_tidak_aktif') {
                            $('[name=pkpd1_pemulihan_punca_tidak_aktif]').addClass("is-invalid");
                            $('.error_pkpd1_pemulihan_punca_tidak_aktif').html(error);
                        }

                        if(index == 'pkpd1_pemulihan_suku_thn_1') {
                            $('[name=pkpd1_pemulihan_suku_thn_1]').addClass("is-invalid");
                            $('.error_pkpd1_pemulihan_suku_thn_1').html(error);
                        }

                        if(index == 'pkpd1_pemulihan_suku_thn_2') {
                            $('[name=pkpd1_pemulihan_suku_thn_2]').addClass("is-invalid");
                            $('.error_pkpd1_pemulihan_suku_thn_2').html(error);
                        }

                        if(index == 'pkpd1_pemulihan_suku_thn_3') {
                            $('[name=pkpd1_pemulihan_suku_thn_3]').addClass("is-invalid");
                            $('.error_pkpd1_pemulihan_suku_thn_3').html(error);
                        }

                        if(index == 'pkpd1_pemulihan_suku_thn_4') {
                            $('[name=pkpd1_pemulihan_suku_thn_4]').addClass("is-invalid");
                            $('.error_pkpd1_pemulihan_suku_thn_4').html(error);
                        }

                        if(index == 'pkpd1_pemulihan_tempoh_pelaksanaan') {
                            $('[name=pkpd1_pemulihan_tempoh_pelaksanaan]').addClass("is-invalid");
                            $('.error_pkpd1_pemulihan_tempoh_pelaksanaan').html(error);
                        }

                        if(index == 'pkpd1_pemulihan_cadangan_ppd') {
                            $('[name=pkpd1_pemulihan_cadangan_ppd]').addClass("is-invalid");
                            $('.error_pkpd1_pemulihan_cadangan_ppd').html(error);
                        }

                        if(index == 'pkpd1_pemulihan_cadangan_hq') {
                            $('[name=pkpd1_pemulihan_cadangan_hq]').addClass("is-invalid");
                            $('.error_pkpd1_pemulihan_cadangan_hq').html(error);
                        }

                    });
                    $('#btn_submit2').html(btn_text);                
                    $('#btn_submit2').prop('disabled', false);            
                } else {
                    $('#btn_submit2').html(btn_text);
                    $('#btn_submit2').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm11.pemulihan_krt_ppd')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop