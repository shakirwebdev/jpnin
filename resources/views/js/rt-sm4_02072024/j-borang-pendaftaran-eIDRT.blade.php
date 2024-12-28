@include('js.modal.j-modal-add-gambar-ajk-krt')
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

		/* Maklumat Kawasan Krt */
            $('#bpe_nama_krt').html("{{$krt_profile->nama_krt}}");
            $('#bpe_alamat_krt').html("{{$krt_profile->alamat_krt}}");
            $('#bpe_negeri_krt').html("{{$krt_profile->negeri_krt}}");
            $('#bpe_daerah_krt').html("{{$krt_profile->daerah_krt}}");
            $('#bpe_parlimen_krt').html("{{$krt_profile->parlimen_krt}}");
            $('#bpe_dun_krt').html("{{$krt_profile->dun_krt}}");
            $('#bpe_pbt_krt').html("{{$krt_profile->pbt_krt}}");

		/* Maklumat Pemohonan Ahli KRT */
            $('#bpe_ajk_alamat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

            $('#bpe_ajk_alamat').on("paste",function(e) {
                e.preventDefault();
            });

            $('#bpe_ajk_berkepentingan_keterangan').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

            $('#bpe_ajk_berkepentingan_keterangan').on("paste",function(e) {
                e.preventDefault();
            });

            $('#bpe_ajk_ic').mask('999999999999');

            $('[name=bpe_ajk_bekepentingan]').click(function(){
                if($('[name=bpe_ajk_bekepentingan]').is(":checked")) {
                    $("[name=bpe_ajk_bekepentingan_interaksi_1]").removeAttr("disabled");
                    $("[name=bpe_ajk_bekepentingan_interaksi_2]").removeAttr("disabled");
                    $("[name=bpe_ajk_bekepentingan_interaksi_3]").removeAttr("disabled");
                    $("[name=bpe_ajk_bekepentingan_interaksi_4]").removeAttr("disabled");
                    $("[name=bpe_ajk_bekepentingan_interaksi_5]").removeAttr("disabled");
                    $("[name=bpe_ajk_berkepentingan_keterangan]").removeAttr("disabled");
                }
                else {
                    $("[name=bpe_ajk_bekepentingan_interaksi_1]").attr("disabled", "disabled");
                    $("[name=bpe_ajk_bekepentingan_interaksi_2]").attr("disabled", "disabled");
                    $("[name=bpe_ajk_bekepentingan_interaksi_3]").attr("disabled", "disabled");
                    $("[name=bpe_ajk_bekepentingan_interaksi_4]").attr("disabled", "disabled");
                    $("[name=bpe_ajk_bekepentingan_interaksi_5]").attr("disabled", "disabled");
                    $("[name=bpe_ajk_berkepentingan_keterangan]").attr("disabled", "disabled");
                }
            });
            $('#bpe_ajk_id').val("{{$krt_ajk->id}}");
            $('#bpe_ajk_status_form').val("{{$krt_ajk->ajk_status_form}}");
            $('#bpe_ajk_gambar').attr('src', "{{ asset('storage/ajk_krt') }}"+"/"+ "{{$krt_ajk->file_avatar}}");
            $('#bpe_ajk_nama').val("{{$krt_ajk->ajk_nama}}");
            $('#bpe_ajk_tarikh_lahir').val("{{$krt_ajk->ajk_tarikh_lahir}}");
            $('#bpe_ajk_k_umur').val("{{$krt_ajk->ajk_kelompok_umur}}");
            $('#bpe_ajk_kaum').val("{{$krt_ajk->ajk_kaum}}");
            $('#bpe_ajk_jantina').val("{{$krt_ajk->ajk_jantina}}");
            $('#bpe_ajk_warganegara').val("{{$krt_ajk->ajk_warganegara}}");
            $('#bpe_ajk_agama').val("{{$krt_ajk->ajk_agama}}");
            $('#bpe_ajk_phone').val("{{$krt_ajk->ajk_phone}}");
            $('#bpe_ajk_ic').val("{{$krt_ajk->ajk_ic}}");
            $('#bpe_ajk_alamat').val("{{$krt_ajk->ajk_alamat}}");
            $('#bpe_ajk_poskod').val("{{$krt_ajk->ajk_poskod}}");
            $('#bpe_ajk_pendidikan_id').val("{{$krt_ajk->ajk_pendidikan_id}}");
            $('#bpe_ajk_profession_id').val("{{$krt_ajk->ajk_profession_id}}");
            $('#bpe_ajk_jawatan_krt_id').val("{{$krt_ajk->ajk_jawatan_krt_id}}");
            $('#bpe_ajk_tarikh_mula').val("{{$krt_ajk->ajk_tarikh_mula}}");
            $('#bpe_ajk_tarikh_akhir').val("{{$krt_ajk->ajk_tarikh_akhir}}");
            $('#mag_krt_ajk_krt_id').val("{{$krt_ajk->id}}");
            var ajk_bekepentingan = "{{$krt_ajk->ajk_bekepentingan}}";
            var ajk_bekepentingan_interaksi_1 = "{{$krt_ajk->ajk_bekepentingan_interaksi_1}}";
            var ajk_bekepentingan_interaksi_2 = "{{$krt_ajk->ajk_bekepentingan_interaksi_2}}";
            var ajk_bekepentingan_interaksi_3 = "{{$krt_ajk->ajk_bekepentingan_interaksi_3}}";
            var ajk_bekepentingan_interaksi_4 = "{{$krt_ajk->ajk_bekepentingan_interaksi_4}}";
            var ajk_bekepentingan_interaksi_5 = "{{$krt_ajk->ajk_bekepentingan_interaksi_5}}";
            if (ajk_bekepentingan == "1") {
                $("input[name=bpe_ajk_bekepentingan]").prop('checked', true);
                $("[name=bpe_ajk_bekepentingan_interaksi_1]").removeAttr("disabled");
                $("[name=bpe_ajk_bekepentingan_interaksi_2]").removeAttr("disabled");
                $("[name=bpe_ajk_bekepentingan_interaksi_3]").removeAttr("disabled");
                $("[name=bpe_ajk_bekepentingan_interaksi_4]").removeAttr("disabled");
                $("[name=bpe_ajk_bekepentingan_interaksi_5]").removeAttr("disabled");
                $("[name=bpe_ajk_berkepentingan_keterangan]").removeAttr("disabled");
            }
            if (ajk_bekepentingan_interaksi_1 == "1") {
                $("input[name=bpe_ajk_bekepentingan_interaksi_1]").prop('checked', true);
            }
            if (ajk_bekepentingan_interaksi_2 == "1") {
                $("input[name=bpe_ajk_bekepentingan_interaksi_2]").prop('checked', true);
            }
            if (ajk_bekepentingan_interaksi_3 == "1") {
                $("input[name=bpe_ajk_bekepentingan_interaksi_3]").prop('checked', true);
            }
            if (ajk_bekepentingan_interaksi_4 == "1") {
                $("input[name=bpe_ajk_bekepentingan_interaksi_4]").prop('checked', true);
            }
            if (ajk_bekepentingan_interaksi_5 == "1") {
                $("input[name=bpe_ajk_bekepentingan_interaksi_5]").prop('checked', true);
            }
            $('#bpe_ajk_berkepentingan_keterangan').val("{{$krt_ajk->ajk_berkepentingan_keterangan}}");

        /* Maklumat Note Kemaskini */
            $('#bpe_status').val("{{$krt_ajk->ajk_status_form}}");
            
            if($('#bpe_status').val() == '6'){
                $("#bpe_perlu_kemaskini").show();
                $('#bpe_status_description').html("{{$krt_ajk->status_description}}");
                $('#bpe_disahkan_note').html("{{$krt_ajk->disahkan_note}}");
            }


        /* Button */
            $('#btn_back').click(function(){
                window.location.href = '{{route('rt-sm4.pendaftaran_ahli_krt_utama')}}';
            });

	});

    /* click add gambar ajk */
		$(document).on('submit', '#form_mag', function(event){
			var info = $('.error_form_mag');
			event.preventDefault();

			var form_data = new FormData();
			form_data.append("mag_file_avatar",  $("#mag_file_avatar")[0].files[0]);
			form_data.append("mag_krt_ajk_krt_id", $("#mag_krt_ajk_krt_id").val() );
			form_data.append("post_add_gambar", "edit" );
			console.log(form_data);

			$('#btn_add').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_add').prop('disabled', true);

			btn_text = 'Tambah&nbsp;&nbsp;<i class="dropdown-icon fa fa-edit"></i>';
			url = "{{ route('rt-sm4.post_add_gambar') }}";
			type = "POST";

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$.ajax({
				url: url,
				type: type,
				data: form_data,
				contentType: false,
            	processData: false,
      			async: false,
			}).done(function(response) {            
				info.hide().find('ul').empty();
				if(response.errors){
					$.each(response.errors, function(index, error){
						info.find('ul').append('<li>'+error+'</li>');
					});
					$('#btn_add').html(btn_text);                
					$('#btn_add').prop('disabled', false);
					info.slideDown();
				} else {
                    window.location.href = "{{route('rt-sm4.borang_pendaftaran_eIDRT','')}}"+"/"+"{{$krt_ajk->id}}";
                    $('#modal_add_gambar').modal('hide');
					
                    
					$('#form_mag').trigger("reset");
					$('#btn_add').html(btn_text);
					$('#btn_add').prop('disabled', false);
					
				}
			});
		});

	/* Btn Tambah */

        //my custom script
        var daftar_ahli_krt_config = {
            routes: {
                daftar_ahli_krt_url: "{{ route('rt-sm4.post_pendaftaran_ahli_krt') }}",
            }
        };

        $(document).on('submit', '#form_bpe', function(event){    
            event.preventDefault();
            $('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_next').prop('disabled', true);
            var data = $("#form_bpe").serialize();
            var action = $('#post_pendaftaran_ahli_krt').val();
            var btn_text;
            if (action == 'edit') {
                url = daftar_ahli_krt_config.routes.daftar_ahli_krt_url;
                type = "POST";
                btn_text = 'Hantar Maklumat Ahli KRT&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=bpe_ajk_nama]').removeClass("is-invalid");
                $('[name=bpe_ajk_ic]').removeClass("is-invalid");
                $('[name=bpe_ajk_tarikh_lahir]').removeClass("is-invalid");
                $('[name=bpe_ajk_jantina]').removeClass("is-invalid");
                $('[name=bpe_ajk_k_umur]').removeClass("is-invalid");
                $('[name=bpe_ajk_kaum]').removeClass("is-invalid");
                $('[name=bpe_ajk_warganegara]').removeClass("is-invalid");
                $('[name=bpe_ajk_agama]').removeClass("is-invalid");
                $('[name=bpe_ajk_phone]').removeClass("is-invalid");
                $('[name=bpe_ajk_alamat]').removeClass("is-invalid");
                $('[name=bpe_ajk_poskod]').removeClass("is-invalid");
                $('[name=bpe_ajk_profession_id]').removeClass("is-invalid");
                $('[name=bpe_ajk_pendidikan_id]').removeClass("is-invalid");
                $('[name=bpe_ajk_jawatan_krt_id]').removeClass("is-invalid");
                $('[name=bpe_ajk_tarikh_mula]').removeClass("is-invalid");
                $('[name=bpe_ajk_tarikh_akhir]').removeClass("is-invalid");
                $('[name=bpe_ajk_bekepentingan]').removeClass("is-invalid");
                $('[name=bpe_ajk_bekepentingan_interaksi_1]').removeClass("is-invalid");
                $('[name=bpe_ajk_bekepentingan_interaksi_2]').removeClass("is-invalid");
                $('[name=bpe_ajk_bekepentingan_interaksi_3]').removeClass("is-invalid");
                $('[name=bpe_ajk_bekepentingan_interaksi_4]').removeClass("is-invalid");
                $('[name=bpe_ajk_bekepentingan_interaksi_5]').removeClass("is-invalid");
                $('[name=bpe_ajk_berkepentingan_keterangan]').removeClass("is-invalid");

                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'bpe_ajk_nama') {
                            $('[name=bpe_ajk_nama]').addClass("is-invalid");
                            $('.error_bpe_ajk_nama').html(error);
                        }

                        if(index == 'bpe_ajk_ic') {
                            $('[name=bpe_ajk_ic]').addClass("is-invalid");
                            $('.error_bpe_ajk_ic').html(error);
                        }

                        if(index == 'bpe_ajk_tarikh_lahir') {
                            $('[name=bpe_ajk_tarikh_lahir]').addClass("is-invalid");
                            $('.error_bpe_ajk_tarikh_lahir').html(error);
                        }

                        if(index == 'bpe_ajk_jantina') {
                            $('[name=bpe_ajk_jantina]').addClass("is-invalid");
                            $('.error_bpe_ajk_jantina').html(error);
                        }

                        if(index == 'bpe_ajk_k_kaum') {
                            $('[name=bpe_ajk_k_kaum]').addClass("is-invalid");
                            $('.error_bpe_ajk_k_kaum').html(error);
                        }

                        if(index == 'bpe_ajk_kaum') {
                            $('[name=bpe_ajk_kaum]').addClass("is-invalid");
                            $('.error_bpe_ajk_kaum').html(error);
                        }

                        if(index == 'bpe_ajk_warganegara') {
                            $('[name=bpe_ajk_warganegara]').addClass("is-invalid");
                            $('.error_bpe_ajk_warganegara').html(error);
                        }

                        if(index == 'bpe_ajk_agama') {
                            $('[name=bpe_ajk_agama]').addClass("is-invalid");
                            $('.error_bpe_ajk_agama').html(error);
                        }

                        if(index == 'bpe_ajk_phone') {
                            $('[name=bpe_ajk_phone]').addClass("is-invalid");
                            $('.error_bpe_ajk_phone').html(error);
                        }

                        if(index == 'bpe_ajk_alamat') {
                            $('[name=bpe_ajk_alamat]').addClass("is-invalid");
                            $('.error_bpe_ajk_alamat').html(error);
                        }

                        if(index == 'bpe_ajk_poskod') {
                            $('[name=bpe_ajk_poskod]').addClass("is-invalid");
                            $('.error_bpe_ajk_poskod').html(error);
                        }

                        if(index == 'bpe_ajk_profession_id') {
                            $('[name=bpe_ajk_profession_id]').addClass("is-invalid");
                            $('.error_bpe_ajk_profession_id').html(error);
                        }

                        if(index == 'bpe_ajk_pendidikan_id') {
                            $('[name=bpe_ajk_pendidikan_id]').addClass("is-invalid");
                            $('.error_bpe_ajk_pendidikan_id').html(error);
                        }

                        if(index == 'bpe_ajk_jawatan_krt_id') {
                            $('[name=bpe_ajk_jawatan_krt_id]').addClass("is-invalid");
                            $('.error_bpe_ajk_jawatan_krt_id').html(error);
                        }

                        if(index == 'bpe_ajk_tarikh_mula') {
                            $('[name=bpe_ajk_tarikh_mula]').addClass("is-invalid");
                            $('.error_bpe_ajk_tarikh_mula').html(error);
                        }

                        if(index == 'bpe_ajk_tarikh_akhir') {
                            $('[name=bpe_ajk_tarikh_akhir]').addClass("is-invalid");
                            $('.error_bpe_ajk_tarikh_akhir').html(error);
                        }

                        if(index == 'bpe_ajk_berkepentingan_keterangan') {
                            $('[name=bpe_ajk_berkepentingan_keterangan]').addClass("is-invalid");
                            $('.error_bpe_ajk_berkepentingan_keterangan').html(error);
                        }

                    });
                    $('#btn_next').html(btn_text);                
                    $('#btn_next').prop('disabled', false);            
                } else {
                    $('#btn_next').html(btn_text);
                    $('#btn_next').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm4.pendaftaran_ahli_krt_utama')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
@stop