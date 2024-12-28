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
            $('#plak5_nama_krt').html("{{$laporan_aktiviti->nama_krt}}");
            $('#plak5_alamat_krt').html("{{$laporan_aktiviti->alamat_krt}}");
            $('#plak5_negeri_krt').html("{{$laporan_aktiviti->negeri_krt}}");
            $('#plak5_parlimen_krt').html("{{$laporan_aktiviti->parlimen_krt}}");
            $('#plak5_pbt_krt').html("{{$laporan_aktiviti->pbt_krt}}");
            $('#plak5_daerah_krt').html("{{$laporan_aktiviti->daerah_krt}}");
            $('#plak5_dun_krt').html("{{$laporan_aktiviti->dun_krt}}");

        /* Maklumat Tempat Aktiviti Perpaduan */
            $('#plak5_state_id').val("{{$laporan_aktiviti->state_id}}");
            $('#plak5_daerah_id').val("{{$laporan_aktiviti->daerah_id}}");
            $('#plak5_aktiviti_tempat').val("{{$laporan_aktiviti->aktiviti_tempat}}");
            var aktiviti_kawasan_DL = "{{$laporan_aktiviti->aktiviti_kawasan_DL}}";
		    $("input[name=plak5_aktiviti_kawasan_DL][value=" + aktiviti_kawasan_DL + "]").prop('checked', true);

        /* Maklumat Aktiviti Perpaduan */
            $('#plak6_aktiviti_ringkasan_program').html("{{$laporan_aktiviti->aktiviti_ringkasan_program}}");
            var aktiviti_post_mortem = "{{$laporan_aktiviti->aktiviti_post_mortem}}";
            if (aktiviti_post_mortem == "1") {
                $("input[name=plak6_aktiviti_post_mortem]").prop('checked', true);
            }
            var aktiviti_soal_selidik = "{{$laporan_aktiviti->aktiviti_soal_selidik}}";
            if (aktiviti_soal_selidik == "1") {
                $("input[name=plak6_aktiviti_soal_selidik]").prop('checked', true);
            }
            var aktiviti_pemerhatian = "{{$laporan_aktiviti->aktiviti_pemerhatian}}";
            if (aktiviti_pemerhatian == "1") {
                $("input[name=plak6_aktiviti_pemerhatian]").prop('checked', true);
            }
            var aktiviti_temubual = "{{$laporan_aktiviti->aktiviti_temubual}}";
            if (aktiviti_temubual == "1") {
                $("input[name=plak6_aktiviti_temubual]").prop('checked', true);
            }
            $('#plak6_aktiviti_kekuatan').html("{{$laporan_aktiviti->aktiviti_kekuatan}}");
            $('#plak6_aktiviti_keberkesanan').html("{{$laporan_aktiviti->aktiviti_keberkesanan}}");
            $('#plak6_aktiviti_penambahbaikan').html("{{$laporan_aktiviti->aktiviti_penambahbaikan}}");
            $('#plak6_aktiviti_laporan_id').val("{{$laporan_aktiviti->id}}");
            $('#plak6_aktiviti_ringkasan_program').summernote({
				height: 200,
				callbacks: {
					onImageUpload: function (data) {
						data.pop();
					},
					onPaste: function (e) {
						e.preventDefault();
						document.execCommand('insertText', false, bufferText);
					}
				}
			});

            $('#plak6_aktiviti_kekuatan').summernote({
				height: 200,
				callbacks: {
					onImageUpload: function (data) {
						data.pop();
					},
					onPaste: function (e) {
						e.preventDefault();
						document.execCommand('insertText', false, bufferText);
					}
				}
			});

            $('#plak6_aktiviti_keberkesanan').summernote({
				height: 200,
				callbacks: {
					onImageUpload: function (data) {
						data.pop();
					},
					onPaste: function (e) {
						e.preventDefault();
						document.execCommand('insertText', false, bufferText);
					}
				}
			});

            $('#plak6_aktiviti_penambahbaikan').summernote({
				height: 200,
				callbacks: {
					onImageUpload: function (data) {
						data.pop();
					},
					onPaste: function (e) {
						e.preventDefault();
						document.execCommand('insertText', false, bufferText);
					}
				}
			});

        /* Maklumat Note Kemaskini */
            $('#plak_status').val("{{$laporan_aktiviti->aktiviti_status}}");
            
            if($('#plak_status').val() == '4'){
                $("#plak_perlu_kemaskini").show();
                $('#plak_status_description').html("{{$laporan_aktiviti->status_description}}");
                $('#plak_disahkan_note').html("{{$laporan_aktiviti->disahkan_note}}");
            }

            /* Button */
            $('#btn_back').click(function(){
                window.location.href = '{{route('rt-sm6.penyediaan_laporan_aktiviti_krt_2','')}}'+'/'+"{{$laporan_aktiviti->id}}";
            });
        
    });

   //my custom script
    var update_penyediaan_laporan_aktiviti_config = {
        routes: {
            update_penyediaan_laporan_aktiviti_url: "{{ route('rt-sm6.post_penyediaan_laporan_aktiviti_krt_2') }}",
        }
    };

	$(document).on('submit', '#form_ppak6', function(event){    
        event.preventDefault();
        $('#btn_sumbit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
        $('#btn_sumbit').prop('disabled', true);
        var data   = $("#form_ppak6").serialize();
        var action = $('#update_penyediaan_laporan_aktiviti').val();
        var btn_text;
        if (action == 'edit') {
            url = update_penyediaan_laporan_aktiviti_config.routes.update_penyediaan_laporan_aktiviti_url;
            type = "POST";
            btn_text = 'Seterusnya &nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
        } 
		$.ajax({
            url: url,
            type: type,
            data: data,
        }).done(function(response) {        
            $('[name=plak6_aktiviti_ringkasan_program]').removeClass("is-invalid");
            $('[name=plak6_aktiviti_post_mortem]').removeClass("is-invalid");
			$('[name=plak6_aktiviti_soal_selidik]').removeClass("is-invalid");
            $('[name=plak6_aktiviti_pemerhatian]').removeClass("is-invalid");
            $('[name=plak6_aktiviti_temubual]').removeClass("is-invalid");
            $('[name=plak6_aktiviti_kekuatan]').removeClass("is-invalid");
            $('[name=plak6_aktiviti_keberkesanan]').removeClass("is-invalid");
            $('[name=plak6_aktiviti_penambahbaikan]').removeClass("is-invalid");
            
            if(response.errors){
                $.each(response.errors, function(index, error){
                    if(index == 'plak6_aktiviti_ringkasan_program') {
                        $('[name=plak6_aktiviti_ringkasan_program]').addClass("is-invalid");
                        $('.error_plak6_aktiviti_ringkasan_program').html(error);
                    }

                    if(index == 'plak6_aktiviti_post_mortem') {
                        $('[name=plak6_aktiviti_post_mortem]').addClass("is-invalid");
                        $('.error_plak6_aktiviti_post_mortem').html(error);
                    }

					if(index == 'plak6_aktiviti_soal_selidik') {
                        $('[name=plak6_aktiviti_soal_selidik]').addClass("is-invalid");
                        $('.error_plak6_aktiviti_soal_selidik').html(error);
                    }

                    if(index == 'plak6_aktiviti_pemerhatian') {
                        $('[name=plak6_aktiviti_pemerhatian]').addClass("is-invalid");
                        $('.error_plak6_aktiviti_pemerhatian').html(error);
                    }

                    if(index == 'plak6_aktiviti_temubual') {
                        $('[name=plak6_aktiviti_temubual]').addClass("is-invalid");
                        $('.error_plak6_aktiviti_temubual').html(error);
                    }

                    if(index == 'plak6_aktiviti_kekuatan') {
                        $('[name=plak6_aktiviti_kekuatan]').addClass("is-invalid");
                        $('.error_plak6_aktiviti_kekuatan').html(error);
                    }

                    if(index == 'plak6_aktiviti_keberkesanan') {
                        $('[name=plak6_aktiviti_keberkesanan]').addClass("is-invalid");
                        $('.error_plak6_aktiviti_keberkesanan').html(error);
                    }

                    if(index == 'plak6_aktiviti_penambahbaikan') {
                        $('[name=plak6_aktiviti_penambahbaikan]').addClass("is-invalid");
                        $('.error_plak6_aktiviti_penambahbaikan').html(error);
                    }

                });
                $('#btn_sumbit').html(btn_text);                
                $('#btn_sumbit').prop('disabled', false);            
            } else {
				$('#btn_sumbit').html(btn_text);
                $('#btn_sumbit').prop('disabled', false); 
				window.location.href = "{{route('rt-sm6.penyediaan_laporan_aktiviti_krt')}}";
            }
        });
    });

    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop