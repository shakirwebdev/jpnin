
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
            $('#psk_nama_krt').html("{{$sejiwa->nama_krt}}");
            $('#psk_alamat_krt').html("{{$sejiwa->alamat_krt}}");
            $('#psk_negeri_krt').html("{{$sejiwa->negeri_krt}}");
            $('#psk_parlimen_krt').html("{{$sejiwa->parlimen_krt}}");
            $('#psk_pbt_krt').html("{{$sejiwa->pbt_krt}}");
            $('#psk_daerah_krt').html("{{$sejiwa->daerah_krt}}");
            $('#psk_dun_krt').html("{{$sejiwa->dun_krt}}");

        /* Maklumat Am Sejiwa */
            $('#psk1_sejiwa_nama').val("{{$sejiwa->sejiwa_nama}}");
            $('#psk1_sejiwa_tarikh_ditubuhkan').val("{{$sejiwa->sejiwa_tarikh_ditubuhkan}}");
            $('#psk1_sejiwa_pusat_operasi').val("{{$sejiwa->sejiwa_pusat_operasi}}");
           
        /* Maklumat Profile Sejiwa */
            $('#psk2_sejiwa_nama_pengerusi').val("{{$sejiwa->sejiwa_nama_pengerusi}}");
            $('#psk2_sejiwa_phone_pengerusi').val("{{$sejiwa->sejiwa_phone_pengerusi}}");
            $('#psk2_sejiwa_email_pengerusi').val("{{$sejiwa->sejiwa_email_pengerusi}}");
            $('#psk2_sejiwa_ic_pengerusi').val("{{$sejiwa->sejiwa_ic_pengerusi}}");
            $('#psk2_sejiwa_alamat_pengerusi').val("{{$sejiwa->sejiwa_alamat_pengerusi}}");
            $('#psk2_sejiwa_pekerjaan_pengerusi').val("{{$sejiwa->sejiwa_pekerjaan_pengerusi}}");
            $('#psk2_sejiwa_nama_timbalan').val("{{$sejiwa->sejiwa_nama_timbalan}}");
            $('#psk2_sejiwa_phone_timbalan').val("{{$sejiwa->sejiwa_phone_timbalan}}");
            $('#psk2_sejiwa_email_timbalan').val("{{$sejiwa->sejiwa_email_timbalan}}");
            $('#psk2_sejiwa_ic_timbalan').val("{{$sejiwa->sejiwa_ic_timbalan}}");
            $('#psk2_sejiwa_alamat_timbalan').val("{{$sejiwa->sejiwa_alamat_timbalan}}");
            $('#psk2_sejiwa_pekerjaan_timbalan').val("{{$sejiwa->sejiwa_pekerjaan_timbalan}}");
            $('#psk2_sejiwa_pekerjaan_timbalan').val("{{$sejiwa->sejiwa_pekerjaan_timbalan}}");
            $('#psk2_sejiwa_nama_su').val("{{$sejiwa->sejiwa_nama_su}}");
            $('#psk2_sejiwa_phone_su').val("{{$sejiwa->sejiwa_phone_su}}");
            $('#psk2_sejiwa_email_su').val("{{$sejiwa->sejiwa_email_su}}");
            $('#psk2_sejiwa_ic_su').val("{{$sejiwa->sejiwa_ic_su}}");
            $('#psk2_sejiwa_alamat_su').val("{{$sejiwa->sejiwa_alamat_su}}");
            $('#psk2_sejiwa_pekerjaan_su').val("{{$sejiwa->sejiwa_pekerjaan_su}}");
            $('#psk2_sejiwa_ic_pengerusi').mask('999999999999');
            $('#psk2_sejiwa_alamat_pengerusi').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
            $('#psk2_sejiwa_ic_timbalan').mask('999999999999');
            $('#psk2_sejiwa_alamat_timbalan').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
            $('#psk2_sejiwa_ic_su').mask('999999999999');
            $('#psk2_sejiwa_alamat_su').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

            $('#psk3_sejiwa_id').val("{{$sejiwa->id}}");
            
        /* Maklumat Note Kemaskini */
            $('#psk_status').val("{{$sejiwa->status}}");

            if($('#psk_status').val() == '5'){
                $("#psk_perlu_kemaskini").show();
                $('#psk_status_description').html("{{$sejiwa->status_description}}");
                $('#psk_disemak_note').html("{{$sejiwa->disemak_note}}");
            }

            if($('#psk_status').val() == '7'){
                $("#psk_perlu_kemaskini").show();
                $('#psk_status_description').html("{{$sejiwa->status_description}}");
                $('#psk_disahkan_note').html("{{$sejiwa->disahkan_note}}");
            }

	    /* Button */
        $('#btn_back').click(function(){
			window.location.href = "{{ route('rt-sm10.permohonan_sejiwa_krt') }}";
		});

	});

    /* Button Next */

        //my custom script
        var permohonan_sejiwa_config = {
            routes: {
                permohonan_sejiwa_url: "{{ route('rt-sm10.post_profil_sejiwa_krt') }}",
            }
        };

        $(document).on('submit', '#form_psk3', function(event){    
            event.preventDefault();
            $('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_next').prop('disabled', true);
            var data   = $("#form_psk1, #form_psk2, #form_psk3").serialize();
            var action = $('#post_profil_sejiwa_krt').val();
            var btn_text;
            if (action == 'edit') {
                url = permohonan_sejiwa_config.routes.permohonan_sejiwa_url;
                type = "POST";
                btn_text = 'Seterusnya &nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=psk1_sejiwa_nama]').removeClass("is-invalid");
                $('[name=psk1_sejiwa_tarikh_ditubuhkan]').removeClass("is-invalid");
                $('[name=psk1_sejiwa_pusat_operasi]').removeClass("is-invalid");
                $('[name=psk2_sejiwa_nama_pengerusi]').removeClass("is-invalid");
                $('[name=psk2_sejiwa_phone_pengerusi]').removeClass("is-invalid");
                $('[name=psk2_sejiwa_email_pengerusi]').removeClass("is-invalid");
                $('[name=psk2_sejiwa_ic_pengerusi]').removeClass("is-invalid");
                $('[name=psk2_sejiwa_alamat_pengerusi]').removeClass("is-invalid");
                $('[name=psk2_sejiwa_pekerjaan_pengerusi]').removeClass("is-invalid");
                $('[name=psk2_sejiwa_nama_timbalan]').removeClass("is-invalid");
                $('[name=psk2_sejiwa_phone_timbalan]').removeClass("is-invalid");
                $('[name=psk2_sejiwa_email_timbalan]').removeClass("is-invalid");
                $('[name=psk2_sejiwa_ic_timbalan]').removeClass("is-invalid");
                $('[name=psk2_sejiwa_alamat_timbalan]').removeClass("is-invalid");
                $('[name=psk2_sejiwa_pekerjaan_timbalan]').removeClass("is-invalid");
                $('[name=psk2_sejiwa_nama_su]').removeClass("is-invalid");
                $('[name=psk2_sejiwa_phone_su]').removeClass("is-invalid");
                $('[name=psk2_sejiwa_email_su]').removeClass("is-invalid");
                $('[name=psk2_sejiwa_ic_su]').removeClass("is-invalid");
                $('[name=psk2_sejiwa_alamat_su]').removeClass("is-invalid");
                $('[name=psk2_sejiwa_pekerjaan_su]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'psk1_sejiwa_nama') {
                            $('[name=psk1_sejiwa_nama]').addClass("is-invalid");
                            $('.error_psk1_sejiwa_nama').html(error);
                        }

                        if(index == 'psk1_sejiwa_tarikh_ditubuhkan') {
                            $('[name=psk1_sejiwa_tarikh_ditubuhkan]').addClass("is-invalid");
                            $('.error_psk1_sejiwa_tarikh_ditubuhkan').html(error);
                        }

                        if(index == 'psk1_sejiwa_pusat_operasi') {
                            $('[name=psk1_sejiwa_pusat_operasi]').addClass("is-invalid");
                            $('.error_psk1_sejiwa_pusat_operasi').html(error);
                        }

                        if(index == 'psk2_sejiwa_nama_pengerusi') {
                            $('[name=psk2_sejiwa_nama_pengerusi]').addClass("is-invalid");
                            $('.error_psk2_sejiwa_nama_pengerusi').html(error);
                        }

                        if(index == 'psk2_sejiwa_phone_pengerusi') {
                            $('[name=psk2_sejiwa_phone_pengerusi]').addClass("is-invalid");
                            $('.error_psk2_sejiwa_phone_pengerusi').html(error);
                        }

                        if(index == 'psk2_sejiwa_email_pengerusi') {
                            $('[name=psk2_sejiwa_email_pengerusi]').addClass("is-invalid");
                            $('.error_psk2_sejiwa_email_pengerusi').html(error);
                        }

                        if(index == 'psk2_sejiwa_ic_pengerusi') {
                            $('[name=psk2_sejiwa_ic_pengerusi]').addClass("is-invalid");
                            $('.error_psk2_sejiwa_ic_pengerusi').html(error);
                        }

                        if(index == 'psk2_sejiwa_alamat_pengerusi') {
                            $('[name=psk2_sejiwa_alamat_pengerusi]').addClass("is-invalid");
                            $('.error_psk2_sejiwa_alamat_pengerusi').html(error);
                        }

                        if(index == 'psk2_sejiwa_pekerjaan_pengerusi') {
                            $('[name=psk2_sejiwa_pekerjaan_pengerusi]').addClass("is-invalid");
                            $('.error_psk2_sejiwa_pekerjaan_pengerusi').html(error);
                        }

                        if(index == 'psk2_sejiwa_nama_timbalan') {
                            $('[name=psk2_sejiwa_nama_timbalan]').addClass("is-invalid");
                            $('.error_psk2_sejiwa_nama_timbalan').html(error);
                        }

                        if(index == 'psk2_sejiwa_phone_timbalan') {
                            $('[name=psk2_sejiwa_phone_timbalan]').addClass("is-invalid");
                            $('.error_psk2_sejiwa_phone_timbalan').html(error);
                        }

                        if(index == 'psk2_sejiwa_email_timbalan') {
                            $('[name=psk2_sejiwa_email_timbalan]').addClass("is-invalid");
                            $('.error_psk2_sejiwa_email_timbalan').html(error);
                        }

                        if(index == 'psk2_sejiwa_ic_timbalan') {
                            $('[name=psk2_sejiwa_ic_timbalan]').addClass("is-invalid");
                            $('.error_psk2_sejiwa_ic_timbalan').html(error);
                        }

                        if(index == 'psk2_sejiwa_alamat_timbalan') {
                            $('[name=psk2_sejiwa_alamat_timbalan]').addClass("is-invalid");
                            $('.error_psk2_sejiwa_alamat_timbalan').html(error);
                        }

                        if(index == 'psk2_sejiwa_pekerjaan_timbalan') {
                            $('[name=psk2_sejiwa_pekerjaan_timbalan]').addClass("is-invalid");
                            $('.error_psk2_sejiwa_pekerjaan_timbalan').html(error);
                        }

                        if(index == 'psk2_sejiwa_nama_su') {
                            $('[name=psk2_sejiwa_nama_su]').addClass("is-invalid");
                            $('.error_psk2_sejiwa_nama_su').html(error);
                        }

                        if(index == 'psk2_sejiwa_phone_su') {
                            $('[name=psk2_sejiwa_phone_su]').addClass("is-invalid");
                            $('.error_psk2_sejiwa_phone_su').html(error);
                        }

                        if(index == 'psk2_sejiwa_email_su') {
                            $('[name=psk2_sejiwa_email_su]').addClass("is-invalid");
                            $('.error_psk2_sejiwa_email_su').html(error);
                        }

                        if(index == 'psk2_sejiwa_ic_su') {
                            $('[name=psk2_sejiwa_ic_su]').addClass("is-invalid");
                            $('.error_psk2_sejiwa_ic_su').html(error);
                        }

                        if(index == 'psk2_sejiwa_alamat_su') {
                            $('[name=psk2_sejiwa_alamat_su]').addClass("is-invalid");
                            $('.error_psk2_sejiwa_alamat_su').html(error);
                        }

                        if(index == 'psk2_sejiwa_pekerjaan_su') {
                            $('[name=psk2_sejiwa_pekerjaan_su]').addClass("is-invalid");
                            $('.error_psk2_sejiwa_pekerjaan_su').html(error);
                        }

                    });
                    $('#btn_next').html(btn_text);                
                    $('#btn_next').prop('disabled', false);            
                } else {
                    $('#btn_next').html(btn_text);
                    $('#btn_next').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm10.permohonan_sejiwa_krt_2','')}}"+"/"+"{{$sejiwa->id}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
@stop