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

		//my custom script
		var mohon_student_tp_p_config = {
			routes: {
				mohon_student_tp_p_url: "/rt/sm27/mohon-student-tp-p/{id}"
			}
		};

		/* Maklumat Tabika Perpaduan */
			$("#mstpp_state_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#mstpp_daerah_id').find('option').remove();
				$('#mstpp_daerah_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: mohon_student_tp_p_config.routes.mohon_student_tp_p_url,
						data: {type: 'get_daerah', value: value},
						success: function (data) {
							$('#mstpp_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#mstpp_daerah_id')
								.append($('<option>')
								.text(obj.daerah_description)
								.attr('value', obj.daerah_id));
							});
						},
						error: function (data) {
							console.log('Error:', data);
						}
					}); 
				}
			});

			$("#mstpp_daerah_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#mstpp_tabika_id').find('option').remove();
				$('#mstpp_tabika_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: mohon_student_tp_p_config.routes.mohon_student_tp_p_url,
						data: {type: 'get_tabika', value: value},
						success: function (data) {
							$('#mstpp_tabika_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#mstpp_tabika_id')
								.append($('<option>')
								.text(obj.tbk_nama)
								.attr('value', obj.id));
							});
						},
						error: function (data) {
							console.log('Error:', data);
						}
					}); 
				}
			});

			$('#mstpp_1_student_alamat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

			$('#mstpp_1_bapa_alamat_office').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

			$('#mstpp_1_student_id').val("{{$tbk_student->id}}");
			$('#mstpp_state_id').val("{{$tbk_student->state_id}}");

			if("{{$tbk_student->state_id}}" !== ''){
				var value = "{{$tbk_student->state_id}}";
				$('#mstpp_daerah_id').prop("disabled", false);
				$.ajax({
					type: "GET",
					url: mohon_student_tp_p_config.routes.mohon_student_tp_p_url,
					data: {type: 'get_daerah', value: value},
					success: function (data) {
						
						$('#mstpp_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#mstpp_daerah_id')
							.append($('<option>')
							.text(obj.daerah_description)
							.attr('value', obj.daerah_id));
							$('#mstpp_daerah_id').val("{{$tbk_student->daerah_id}}");
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}else{
				
			}

			if("{{$tbk_student->daerah_id}}" !== ''){
				var value = "{{$tbk_student->daerah_id}}";
				$('#mstpp_tabika_id').prop("disabled", false);
				$.ajax({
					type: "GET",
					url: mohon_student_tp_p_config.routes.mohon_student_tp_p_url,
					data: {type: 'get_tabika', value: value},
					success: function (data) {
						
						$('#mstpp_tabika_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#mstpp_tabika_id')
							.append($('<option>')
							.text(obj.tbk_nama)
							.attr('value', obj.id));
							$('#mstpp_tabika_id').val("{{$tbk_student->tabika_id}}");
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}else{
				
			}
			
			$('#mstpp_1_student_nama').val("{{$tbk_student->student_nama}}");
			$('#mstpp_1_student_sijil_lahir').val("{{$tbk_student->student_sijil_lahir}}");
			$('#mstpp_1_student_agama_id').val("{{$tbk_student->student_agama_id}}");
			$('#mstpp_1_student_kaum_id').val("{{$tbk_student->student_kaum_id}}");
			$('#mstpp_1_student_mykid').val("{{$tbk_student->student_mykid}}");
			$('#mstpp_1_student_tarikh_lahir').val("{{$tbk_student->student_tarikh_lahir}}");
			$('#mstpp_1_student_jantina_id').val("{{$tbk_student->student_jantina_id}}");
			$('#mstpp_1_student_kesihatan').val("{{$tbk_student->student_kesihatan}}");
			$('#mstpp_1_student_alamat').val("{{$tbk_student->student_alamat}}");
			$('#mstpp_1_student_jarak_rumah').val("{{$tbk_student->student_jarak_rumah}}");
			$('#mstpp_1_bapa_nama').val("{{$tbk_student->bapa_nama}}");
			$('#mstpp_1_bapa_pekerjaan').val("{{$tbk_student->bapa_pekerjaan}}");
			$('#mstpp_1_bapa_profession_id').val("{{$tbk_student->bapa_profession_id}}");
			$('#mstpp_1_bapa_pendapatan').val("{{$tbk_student->bapa_pendapatan}}");
			$('#mstpp_1_bapa_kerakyatan_id').val("{{$tbk_student->bapa_kerakyatan_id}}");
			$('#mstpp_1_bapa_jumlah_pendapatan').val("{{$tbk_student->bapa_jumlah_pendapatan}}");
			$('#mstpp_1_bapa_ic').val("{{$tbk_student->bapa_ic}}");
			$('#mstpp_1_bapa_alamat_office').val("{{$tbk_student->bapa_alamat_office}}");
			$('#mstpp_1_bapa_phone_office').val("{{$tbk_student->bapa_phone_office}}");
			$('#mstpp_1_bapa_phone').val("{{$tbk_student->bapa_phone}}");
			$('#mstpp_1_bapa_phone_rumah').val("{{$tbk_student->bapa_phone_rumah}}");

		/* Maklumat Note Kemaskini */
			$('#mstpp_student_status').val("{{$tbk_student->student_status}}");

			if($('#mstpp_student_status').val() == '4'){
				$("#mstpp_perlu_kemaskini").show();
				$('#mstpp_status_description').html("{{$tbk_student->status_description}}");
				$('#mstpp_disahkan_note').html("{{$tbk_student->disahkan_note}}");
			}

			if($('#mstpp_student_status').val() == '6'){
				$("#mstpp_perlu_kemaskini").show();
				$('#mstpp_status_description').html("{{$tbk_student->status_description}}");
				$('#mstpp_diluluskan_note').html("{{$tbk_student->diluluskan_note}}");
			}

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm27.senarai_permohonan_student_tp_p') }}";
			});

	});

	/* Button Seterusnya */
		//my custom script
        var edit_permohonan_student_config = {
            routes: {
                edit_permohonan_student_url: "{{ route('rt-sm27.post_permohonan_student_tp_1') }}",
            }
        };

		$(document).on('submit', '#form_mstpp_1', function(event){    
            event.preventDefault();
            $('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_next').prop('disabled', true);
            var data = $("#form_mstpp, #form_mstpp_1").serialize();
            var action = $('#post_permohonan_student_tp_1').val();
            var btn_text;
            if (action == 'edit') {
                url = edit_permohonan_student_config.routes.edit_permohonan_student_url;
                type = "POST";
                btn_text = 'Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=mstpp_state_id]').removeClass("is-invalid");
                $('[name=mstpp_daerah_id]').removeClass("is-invalid");
                $('[name=mstpp_tabika_id]').removeClass("is-invalid");
                $('[name=mstpp_1_student_nama]').removeClass("is-invalid");
                $('[name=mstpp_1_student_sijil_lahir]').removeClass("is-invalid");
                $('[name=mstpp_1_student_agama_id]').removeClass("is-invalid");
                $('[name=mstpp_1_student_kaum_id]').removeClass("is-invalid");
                $('[name=mstpp_1_student_mykid]').removeClass("is-invalid");
                $('[name=mstpp_1_student_tarikh_lahir]').removeClass("is-invalid");
                $('[name=mstpp_1_student_jantina_id]').removeClass("is-invalid");
                $('[name=mstpp_1_student_kesihatan]').removeClass("is-invalid");
                $('[name=mstpp_1_student_alamat]').removeClass("is-invalid");
                $('[name=mstpp_1_student_jarak_rumah]').removeClass("is-invalid");
                $('[name=mstpp_1_bapa_nama]').removeClass("is-invalid");
                $('[name=mstpp_1_bapa_pekerjaan]').removeClass("is-invalid");
                $('[name=mstpp_1_bapa_profession_id]').removeClass("is-invalid");
                $('[name=mstpp_1_bapa_pendapatan]').removeClass("is-invalid");
                $('[name=mstpp_1_bapa_kerakyatan_id]').removeClass("is-invalid");
                $('[name=mstpp_1_bapa_jumlah_pendapatan]').removeClass("is-invalid");
                $('[name=mstpp_1_bapa_ic]').removeClass("is-invalid");
                $('[name=mstpp_1_bapa_alamat_office]').removeClass("is-invalid");
				$('[name=mstpp_1_bapa_phone_office]').removeClass("is-invalid");
				$('[name=mstpp_1_bapa_phone]').removeClass("is-invalid");
				$('[name=mstpp_1_bapa_phone_rumah]').removeClass("is-invalid");

                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'mstpp_state_id') {
                            $('[name=mstpp_state_id]').addClass("is-invalid");
                            $('.error_mstpp_state_id').html(error);
                        }

                        if(index == 'mstpp_daerah_id') {
                            $('[name=mstpp_daerah_id]').addClass("is-invalid");
                            $('.error_mstpp_daerah_id').html(error);
                        }

                        if(index == 'mstpp_tabika_id') {
                            $('[name=mstpp_tabika_id]').addClass("is-invalid");
                            $('.error_mstpp_tabika_id').html(error);
                        }

                        if(index == 'mstpp_1_student_nama') {
                            $('[name=mstpp_1_student_nama]').addClass("is-invalid");
                            $('.error_mstpp_1_student_nama').html(error);
                        }

                        if(index == 'mstpp_1_student_sijil_lahir') {
                            $('[name=mstpp_1_student_sijil_lahir]').addClass("is-invalid");
                            $('.error_mstpp_1_student_sijil_lahir').html(error);
                        }

                        if(index == 'mstpp_1_student_agama_id') {
                            $('[name=mstpp_1_student_agama_id]').addClass("is-invalid");
                            $('.error_mstpp_1_student_agama_id').html(error);
                        }

                        if(index == 'mstpp_1_student_kaum_id') {
                            $('[name=mstpp_1_student_kaum_id]').addClass("is-invalid");
                            $('.error_mstpp_1_student_kaum_id').html(error);
                        }

                        if(index == 'mstpp_1_student_mykid') {
                            $('[name=mstpp_1_student_mykid]').addClass("is-invalid");
                            $('.error_mstpp_1_student_mykid').html(error);
                        }

                        if(index == 'mstpp_1_student_tarikh_lahir') {
                            $('[name=mstpp_1_student_tarikh_lahir]').addClass("is-invalid");
                            $('.error_mstpp_1_student_tarikh_lahir').html(error);
                        }

                        if(index == 'mstpp_1_student_jantina_id') {
                            $('[name=mstpp_1_student_jantina_id]').addClass("is-invalid");
                            $('.error_mstpp_1_student_jantina_id').html(error);
                        }

                        if(index == 'mstpp_1_student_kesihatan') {
                            $('[name=mstpp_1_student_kesihatan]').addClass("is-invalid");
                            $('.error_mstpp_1_student_kesihatan').html(error);
                        }

                        if(index == 'mstpp_1_student_alamat') {
                            $('[name=mstpp_1_student_alamat]').addClass("is-invalid");
                            $('.error_mstpp_1_student_alamat').html(error);
                        }

                        if(index == 'mstpp_1_student_jarak_rumah') {
                            $('[name=mstpp_1_student_jarak_rumah]').addClass("is-invalid");
                            $('.error_mstpp_1_student_jarak_rumah').html(error);
                        }

                        if(index == 'mstpp_1_bapa_nama') {
                            $('[name=mstpp_1_bapa_nama]').addClass("is-invalid");
                            $('.error_mstpp_1_bapa_nama').html(error);
                        }

                        if(index == 'mstpp_1_bapa_pekerjaan') {
                            $('[name=mstpp_1_bapa_pekerjaan]').addClass("is-invalid");
                            $('.error_mstpp_1_bapa_pekerjaan').html(error);
                        }

						if(index == 'mstpp_1_bapa_profession_id') {
                            $('[name=mstpp_1_bapa_profession_id]').addClass("is-invalid");
                            $('.error_mstpp_1_bapa_profession_id').html(error);
                        }

						if(index == 'mstpp_1_bapa_pendapatan') {
                            $('[name=mstpp_1_bapa_pendapatan]').addClass("is-invalid");
                            $('.error_mstpp_1_bapa_pendapatan').html(error);
                        }

						if(index == 'mstpp_1_bapa_kerakyatan_id') {
                            $('[name=mstpp_1_bapa_kerakyatan_id]').addClass("is-invalid");
                            $('.error_mstpp_1_bapa_kerakyatan_id').html(error);
                        }

						if(index == 'mstpp_1_bapa_jumlah_pendapatan') {
                            $('[name=mstpp_1_bapa_jumlah_pendapatan]').addClass("is-invalid");
                            $('.error_mstpp_1_bapa_jumlah_pendapatan').html(error);
                        }

						if(index == 'mstpp_1_bapa_ic') {
                            $('[name=mstpp_1_bapa_ic]').addClass("is-invalid");
                            $('.error_mstpp_1_bapa_ic').html(error);
                        }

						if(index == 'mstpp_1_bapa_alamat_office') {
                            $('[name=mstpp_1_bapa_alamat_office]').addClass("is-invalid");
                            $('.error_mstpp_1_bapa_alamat_office').html(error);
                        }

						if(index == 'mstpp_1_bapa_phone_office') {
                            $('[name=mstpp_1_bapa_phone_office]').addClass("is-invalid");
                            $('.error_mstpp_1_bapa_phone_office').html(error);
                        }

						if(index == 'mstpp_1_bapa_phone') {
                            $('[name=mstpp_1_bapa_phone]').addClass("is-invalid");
                            $('.error_mstpp_1_bapa_phone').html(error);
                        }

						if(index == 'mstpp_1_bapa_phone_rumah') {
                            $('[name=mstpp_1_bapa_phone_rumah]').addClass("is-invalid");
                            $('.error_mstpp_1_bapa_phone_rumah').html(error);
                        }

                    });
                    $('#btn_next').html(btn_text);                
                    $('#btn_next').prop('disabled', false);            
                } else {
                    $('#btn_next').html(btn_text);
                    $('#btn_next').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm27.mohon_student_tp_p_1','')}}"+"/"+"{{$tbk_student->id}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop