@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
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
            $('#ppak5_nama_krt').html("{{$perancangan_aktiviti->nama_krt}}");
            $('#ppak5_alamat_krt').html("{{$perancangan_aktiviti->alamat_krt}}");
            $('#ppak5_negeri_krt').html("{{$perancangan_aktiviti->negeri_krt}}");
            $('#ppak5_parlimen_krt').html("{{$perancangan_aktiviti->parlimen_krt}}");
            $('#ppak5_pbt_krt').html("{{$perancangan_aktiviti->pbt_krt}}");
            $('#ppak5_daerah_krt').html("{{$perancangan_aktiviti->daerah_krt}}");
            $('#ppak5_dun_krt').html("{{$perancangan_aktiviti->dun_krt}}");

        /* Maklumat Tempat Aktiviti Perpaduan */
            $('#ppak5_state_id').val("{{$perancangan_aktiviti->state_id}}");
            $('#ppak5_daerah_id').val("{{$perancangan_aktiviti->daerah_id}}");
            $('#ppak5_aktiviti_tempat').val("{{$perancangan_aktiviti->aktiviti_tempat}}");
            var aktiviti_kawasan_DL = "{{$perancangan_aktiviti->aktiviti_kawasan_DL}}";
		    $("input[name=ppak5_aktiviti_kawasan_DL][value=" + aktiviti_kawasan_DL + "]").prop('checked', true);

        /* Maklumat Aktiviti Perpaduan */
            $('#ppak6_aktiviti_ringkasan_program').html("{{$perancangan_aktiviti->aktiviti_ringkasan_program}}");
            var aktiviti_post_mortem = "{{$perancangan_aktiviti->aktiviti_post_mortem}}";
            if (aktiviti_post_mortem == "1") {
                $("input[name=ppak6_aktiviti_post_mortem]").prop('checked', true);
            }
            var aktiviti_soal_selidik = "{{$perancangan_aktiviti->aktiviti_soal_selidik}}";
            if (aktiviti_soal_selidik == "1") {
                $("input[name=ppak6_aktiviti_soal_selidik]").prop('checked', true);
            }
            var aktiviti_pemerhatian = "{{$perancangan_aktiviti->aktiviti_pemerhatian}}";
            if (aktiviti_pemerhatian == "1") {
                $("input[name=ppak6_aktiviti_pemerhatian]").prop('checked', true);
            }
            var aktiviti_temubual = "{{$perancangan_aktiviti->aktiviti_temubual}}";
            if (aktiviti_temubual == "1") {
                $("input[name=ppak6_aktiviti_temubual]").prop('checked', true);
            }
            $('#ppak6_aktiviti_kekuatan').html("{{$perancangan_aktiviti->aktiviti_kekuatan}}");
            $('#ppak6_aktiviti_keberkesanan').html("{{$perancangan_aktiviti->aktiviti_keberkesanan}}");
            $('#ppak6_aktiviti_penambahbaikan').html("{{$perancangan_aktiviti->aktiviti_penambahbaikan}}");
            $('#ppak6_aktiviti_perancangan_id').val("{{$perancangan_aktiviti->id}}");
            $('#ppak6_aktiviti_ringkasan_program').summernote({
                height: 200,
                callbacks: {
					onImageUpload: function (data) {
						data.pop();
					}
				}
            });

            $('#ppak6_aktiviti_kekuatan').summernote({
                height: 200,
                callbacks: {
					onImageUpload: function (data) {
						data.pop();
					}
				}
            });

            $('#ppak6_aktiviti_keberkesanan').summernote({
                height: 200,
                callbacks: {
					onImageUpload: function (data) {
						data.pop();
					}
				}
            });

            $('#ppak6_aktiviti_penambahbaikan').summernote({
                height: 200,
                callbacks: {
					onImageUpload: function (data) {
						data.pop();
					}
				}
            });

            

        /* Maklumat Note Kemaskini */
            $('#ppak_status').val("{{$perancangan_aktiviti->aktiviti_status}}");
            
            if($('#ppak_status').val() == '4'){
                $("#ppak_perlu_kemaskini").show();
                $('#ppak_status_description').html("{{$perancangan_aktiviti->status_description}}");
                $('#ppak_disahkan_note').html("{{$perancangan_aktiviti->disahkan_note}}");
            }

        /* Button */
            $('#btn_back').click(function(){
                window.location.href = '{{route('rt-sm6.penyediaan_perancangan_aktiviti_krt_2','')}}'+'/'+"{{$perancangan_aktiviti->id}}";
            });
        
    });

   //my custom script
    var update_penyediaan_perancangan_aktiviti_config = {
        routes: {
            update_penyediaan_perancangan_aktiviti_url: "{{ route('rt-sm6.post_penyediaan_perancangan_aktiviti_krt_2') }}",
        }
    };

	$(document).on('submit', '#form_ppak6', function(event){    
        event.preventDefault();
        $('#btn_sumbit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
        $('#btn_sumbit').prop('disabled', true);
        var data   = $("#form_ppak6").serialize();
        var action = $('#update_penyediaan_perancangan_aktiviti').val();
        var btn_text;
        if (action == 'edit') {
            url = update_penyediaan_perancangan_aktiviti_config.routes.update_penyediaan_perancangan_aktiviti_url;
            type = "POST";
            btn_text = 'Hantar Perancang Aktiviti Perpaduan &nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
        } 
		$.ajax({
            url: url,
            type: type,
            data: data,
        }).done(function(response) {        
            $('[name=ppak6_aktiviti_ringkasan_program]').removeClass("is-invalid");
            // $('[name=ppak6_aktiviti_post_mortem]').removeClass("is-invalid");
			// $('[name=ppak6_aktiviti_soal_selidik]').removeClass("is-invalid");
            // $('[name=ppak6_aktiviti_pemerhatian]').removeClass("is-invalid");
            // $('[name=ppak6_aktiviti_temubual]').removeClass("is-invalid");
            // $('[name=ppak6_aktiviti_kekuatan]').removeClass("is-invalid");
            // $('[name=ppak6_aktiviti_keberkesanan]').removeClass("is-invalid");
            // $('[name=ppak6_aktiviti_penambahbaikan]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'ppak6_aktiviti_ringkasan_program') {
                        $('[name=ppak6_aktiviti_ringkasan_program]').addClass("is-invalid");
                        $('.error_ppak6_aktiviti_ringkasan_program').html(error);
                    }

                    // if(index == 'ppak6_aktiviti_post_mortem') {
                    //     $('[name=ppak6_aktiviti_post_mortem]').addClass("is-invalid");
                    //     $('.error_ppak6_aktiviti_post_mortem').html(error);
                    // }

					// if(index == 'ppak6_aktiviti_soal_selidik') {
                    //     $('[name=ppak6_aktiviti_soal_selidik]').addClass("is-invalid");
                    //     $('.error_ppak6_aktiviti_soal_selidik').html(error);
                    // }

                    // if(index == 'ppak6_aktiviti_pemerhatian') {
                    //     $('[name=ppak6_aktiviti_pemerhatian]').addClass("is-invalid");
                    //     $('.error_ppak6_aktiviti_pemerhatian').html(error);
                    // }

                    // if(index == 'ppak6_aktiviti_temubual') {
                    //     $('[name=ppak6_aktiviti_temubual]').addClass("is-invalid");
                    //     $('.error_ppak6_aktiviti_temubual').html(error);
                    // }

                    // if(index == 'ppak6_aktiviti_kekuatan') {
                    //     $('[name=ppak6_aktiviti_kekuatan]').addClass("is-invalid");
                    //     $('.error_ppak6_aktiviti_kekuatan').html(error);
                    // }

                    // if(index == 'ppak6_aktiviti_keberkesanan') {
                    //     $('[name=ppak6_aktiviti_keberkesanan]').addClass("is-invalid");
                    //     $('.error_ppak6_aktiviti_keberkesanan').html(error);
                    // }

                    // if(index == 'ppak6_aktiviti_penambahbaikan') {
                    //     $('[name=ppak6_aktiviti_penambahbaikan]').addClass("is-invalid");
                    //     $('.error_ppak6_aktiviti_penambahbaikan').html(error);
                    // }

                });
                $('#btn_sumbit').html(btn_text);                
                $('#btn_sumbit').prop('disabled', false);            
            } else {
				$('#btn_sumbit').html(btn_text);
                $('#btn_sumbit').prop('disabled', false); 
				window.location.href = "{{route('rt-sm6.penyediaan_perancangan_aktiviti_krt')}}";
            }
        });
    });

    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop