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
			var senarai_permohonan_ikes_config = {
				routes: {
					senarai_permohonan_ikes_url: "/rt/sm21/permohonan-ikes/{id}"
				}
			};

		/* Maklumat Kes Dalam Krt */
			$('#pi_hasRT').on('click', function(){           
				if($(this).is(':checked')){
					$('#pi_hasRT').val(1);
					$('#pi_negeri_id').attr('disabled', false);
					
				} else {
					$('#pi_negeri_id').attr('disabled', true);
					$('#pi_daerah_id').attr('disabled', true);
					$('#pi_krt_profile_id').attr('disabled', true);
				}
			});

			$("#pi_negeri_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pi_daerah_id').find('option').remove();
				$('#pi_daerah_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_config.routes.senarai_permohonan_ikes_url,
						data: {type: 'get_daerah', value: value},
						success: function (data) {
							$('#pi_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pi_daerah_id')
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

			$("#pi_daerah_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pi_krt_profile_id').find('option').remove();
				$('#pi_krt_profile_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_config.routes.senarai_permohonan_ikes_url,
						data: {type: 'get_krt', value: value},
						success: function (data) {
							$('#pi_krt_profile_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pi_krt_profile_id')
								.append($('<option>')
								.text(obj.krt_nama)
								.attr('value', obj.id));
							});
						},
						error: function (data) {
							console.log('Error:', data);
						}
					}); 
				}
			});

			if("{{$ikes->hasRT}}" == 1){
				$('#pi_hasRT').attr("checked", "checked");
				$('#pi_hasRT').val(1);
				$('#pi_negeri_id').attr('disabled', false);
				$('#pi_daerah_id').attr('disabled', false);
				$('#pi_krt_profile_id').attr('disabled', false);
			}
			
			$('#pi_negeri_id').val("{{$ikes->krt_state_id}}");
			$('#pi_daerah_id').val("{{$ikes->krt_daerah_id}}");
			$('#pi_krt_profile_id').val("{{$ikes->krt_profile_id}}");
			
		/* Maklumat Pemohon */
			$('#pi1_user_fullname').val("{{$ikes->nama_permohon}}");
			$('#pi1_user_no_ic').val("{{$ikes->ic_pemohon}}");
			$('#pi1_user_no_phone').val("{{$ikes->phone_pemohon}}");
			$('#pi1_dihantar_alamat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
			$('#pi1_dihantar_alamat').val("{{$ikes->dihantar_alamat}}");

		/* Maklumat Kes Kejadian */
			$("#pi2_negeri_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pi2_daerah_id').find('option').remove();
				$('#pi2_daerah_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_config.routes.senarai_permohonan_ikes_url,
						data: {type: 'get_daerah', value: value},
						success: function (data) {
							$('#pi2_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pi2_daerah_id')
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

			$("#pi2_daerah_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pi2_bandar_id').find('option').remove();
				$('#pi2_bandar_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_config.routes.senarai_permohonan_ikes_url,
						data: {type: 'get_bandar', value: value},
						success: function (data) {
							$('#pi2_bandar_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pi2_bandar_id')
								.append($('<option>')
								.text(obj.bandar_description)
								.attr('value', obj.id));
							});
						},
						error: function (data) {
							console.log('Error:', data);
						}
					}); 
				}
			});

			$("#pi2_negeri_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pi2_parlimen_id').find('option').remove();
				$('#pi2_parlimen_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_config.routes.senarai_permohonan_ikes_url,
						data: {type: 'get_parlimen', value: value},
						success: function (data) {
							$('#pi2_parlimen_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pi2_parlimen_id')
								.append($('<option>')
								.text(obj.parlimen_description)
								.attr('value', obj.parlimen_id));
							});
						},
						error: function (data) {
							console.log('Error:', data);
						}
					}); 
				}
			});

			$("#pi2_negeri_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pi2_dun_id').find('option').remove();
				$('#pi2_dun_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_config.routes.senarai_permohonan_ikes_url,
						data: {type: 'get_dun', value: value},
						success: function (data) {
							$('#pi2_dun_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pi2_dun_id')
								.append($('<option>')
								.text(obj.dun_description)
								.attr('value', obj.dun_id));
							});
						},
						error: function (data) {
							console.log('Error:', data);
						}
					}); 
				}
			});

			$("#pi2_negeri_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pi2_pbt_id').find('option').remove();
				$('#pi2_pbt_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_config.routes.senarai_permohonan_ikes_url,
						data: {type: 'get_pbt', value: value},
						success: function (data) {
							$('#pi2_pbt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pi2_pbt_id')
								.append($('<option>')
								.text(obj.pbt_description)
								.attr('value', obj.pbt_id));
							});
						},
						error: function (data) {
							console.log('Error:', data);
						}
					}); 
				}
			});

			$("#pi2_kategori_kes_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pi2_sub_kategori_kes_id').find('option').remove();
				$('#pi2_sub_kategori_kes_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_config.routes.senarai_permohonan_ikes_url,
						data: {type: 'get_sub_kategori', value: value},
						success: function (data) {
							$('#pi2_sub_kategori_kes_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pi2_sub_kategori_kes_id')
								.append($('<option>')
								.text(obj.sub_kategori_description)
								.attr('value', obj.id));
							});
						},
						error: function (data) {
							console.log('Error:', data);
						}
					}); 
				}
			});

			$("#pi2_kluster_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pi2_sub_kluster_id').find('option').remove();
				$('#pi2_sub_kluster_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_config.routes.senarai_permohonan_ikes_url,
						data: {type: 'get_sub_kluster', value: value},
						success: function (data) {
							$('#pi2_sub_kluster_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pi2_sub_kluster_id')
								.append($('<option>')
								.text(obj.subkluster_description)
								.attr('value', obj.id));
							});
						},
						error: function (data) {
							console.log('Error:', data);
						}
					}); 
				}
			});
        
			$('#pi3_ikes_id').val("{{$ikes->id}}");
			$('#pi2_negeri_id').val("{{$ikes->state_id}}");
			if("{{$ikes->daerah_id}}" !== ''){
				$('#pi2_daerah_id').attr('disabled', false);
			}else{
				$('#pi2_daerah_id').attr('disabled', true);
			}
			$('#pi2_daerah_id').val("{{$ikes->daerah_id}}");
			if("{{$ikes->bandar_id}}" !== ''){
				$('#pi2_bandar_id').attr('disabled', false);
			}else{
				$('#pi2_bandar_id').attr('disabled', true);
			}
			$('#pi2_bandar_id').val("{{$ikes->bandar_id}}");
			$('#pi2_ikes_kawasan').val("{{$ikes->ikes_kawasan}}");
			$('#pi2_ikes_lokasi').val("{{$ikes->ikes_lokasi}}");
			$('#pi2_ikes_poskod').val("{{$ikes->ikes_poskod}}");
			if("{{$ikes->parlimen_id}}" !== ''){
				$('#pi2_parlimen_id').attr('disabled', false);
			}else{
				$('#pi2_parlimen_id').attr('disabled', true);
			}
			$('#pi2_parlimen_id').val("{{$ikes->parlimen_id}}");
			if("{{$ikes->dun_id}}" !== ''){
				$('#pi2_dun_id').attr('disabled', false);
			}else{
				$('#pi2_dun_id').attr('disabled', true);
			}
			$('#pi2_dun_id').val("{{$ikes->dun_id}}");
			if("{{$ikes->pbt_id}}" !== ''){
				$('#pi2_pbt_id').attr('disabled', false);
			}else{
				$('#pi2_pbt_id').attr('disabled', true);
			}
			$('#pi2_pbt_id').val("{{$ikes->pbt_id}}");
			$('#pi2_ikes_bpolis').val("{{$ikes->ikes_bpolis}}");
			$('#pi2_ikes_tarikh_berlaku').val("{{$ikes->ikes_tarikh_berlaku}}");
			$('#pi2_peringkat_kes_id').val("{{$ikes->peringkat_id}}");
			$('#pi2_kategori_kes_id').val("{{$ikes->kategori_id}}");
			if("{{$ikes->sub_kategori_id}}" !== ''){
				var value = "{{$ikes->kategori_id}}";
				$('#pi2_sub_kategori_kes_id').attr('disabled', false);
				$.ajax({
					type: "GET",
					url: senarai_permohonan_ikes_config.routes.senarai_permohonan_ikes_url,
					data: {type: 'get_sub_kategori', value: value},
					success: function (data) {
						
						$('#pi2_sub_kategori_kes_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#pi2_sub_kategori_kes_id')
							.append($('<option>')
							.text(obj.sub_kategori_description)
							.attr('value', obj.id));
							$('#pi2_sub_kategori_kes_id').val("{{$ikes->sub_kategori_id}}");
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}else{
				$('#pi2_sub_kategori_kes_id').attr('disabled', true);
			}
			$('#pi2_kluster_id').val("{{$ikes->kluster_id}}");
			if("{{$ikes->sub_kluster_id}}" !== ''){
				var value = "{{$ikes->kluster_id}}";
				$('#pi2_sub_kluster_id').attr('disabled', false);
				$.ajax({
					type: "GET",
					url: senarai_permohonan_ikes_config.routes.senarai_permohonan_ikes_url,
					data: {type: 'get_sub_kluster', value: value},
					success: function (data) {
						
						$('#pi2_sub_kluster_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#pi2_sub_kluster_id')
							.append($('<option>')
							.text(obj.subkluster_description)
							.attr('value', obj.id));
							$('#pi2_sub_kluster_id').val("{{$ikes->sub_kluster_id}}");
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}else{
				$('#pi2_sub_kluster_id').attr('disabled', true);
			}
			
			// $('#pi2_sub_kluster_id').val("{{$ikes->sub_kluster_id}}");
			$('#pi2_ikes_keterangan_kes').html("{{$ikes->ikes_keterangan_kes}}");
			$('#pi2_ikes_tindakan_awal').html("{{$ikes->ikes_tindakan_awal}}");
			$('#pi2_ikes_keterangan_kes').summernote({
				height: 200
			});

			$('#pi2_ikes_tindakan_awal').summernote({
				height: 200
			});
			$('#pi2_ikes_sumber').val("{{$ikes->ikes_sumber}}");

		/* Maklumat Note Kemaskini */
			$('#pi_status').val("{{$ikes->status}}");
				
			if($('#pi_status').val() == '5'){
				$("#pi_perlu_kemaskini").show();
				$('#pi_status_description').html("{{$ikes->status_description}}");
				$('#pi_diakui_note').html("{{$ikes->diakui_note}}");
			}

			if($('#pi_status').val() == '7'){
				$("#pi_perlu_kemaskini").show();
				$('#pi_status_description').html("{{$ikes->status_description}}");
				$('#pi_disemak_note').html("{{$ikes->disemak_note}}");
			}

			if($('#pi_status').val() == '8'){
				$("#pi_perlu_kemaskini").show();
				$('#pi_status_description').html("{{$ikes->status_description}}");
				$('#pi_disahkan_note').html("{{$ikes->disahkan_note}}");
			}

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm21.senarai_permohonan_ikes') }}";
			});

	});

	/* click btn next */
		//my custom script
		var permohonan_ikes_1_config = {
			routes: {
				permohonan_ikes_1_url: "{{ route('rt-sm21.post_permohonan_ikes_1') }}",
			}
		};

		$(document).on('submit', '#form_pi3', function(event){    
			event.preventDefault();
			$('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_next').prop('disabled', true);
			var data   = $("#form_pi, #form_pi1, #form_pi2, #form_pi3").serialize();
			var action = $('#post_permohonan_ikes_1').val();
			var btn_text;
			if (action == 'edit') {
				url = permohonan_ikes_1_config.routes.permohonan_ikes_1_url;
				type = "POST";
				btn_text = 'Seterusnya &nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=pi_negeri_id]').removeClass("is-invalid");
				$('[name=pi_daerah_id]').removeClass("is-invalid");
				$('[name=pi_krt_profile_id]').removeClass("is-invalid");
				$('[name=pi1_dihantar_alamat]').removeClass("is-invalid");
				$('[name=pi2_negeri_id]').removeClass("is-invalid");
				$('[name=pi2_bandar_id]').removeClass("is-invalid");
				$('[name=pi2_ikes_lokasi]').removeClass("is-invalid");
				$('[name=pi2_parlimen_id]').removeClass("is-invalid");
				$('[name=pi2_pbt_id]').removeClass("is-invalid");
				$('[name=pi2_ikes_tarikh_berlaku]').removeClass("is-invalid");
				$('[name=pi2_daerah_id]').removeClass("is-invalid");
				$('[name=pi2_ikes_kawasan]').removeClass("is-invalid");
				$('[name=pi2_ikes_poskod]').removeClass("is-invalid");
				$('[name=pi2_dun_id]').removeClass("is-invalid");
				$('[name=pi2_ikes_bpolis]').removeClass("is-invalid");
				$('[name=pi2_peringkat_kes_id]').removeClass("is-invalid");
				$('[name=pi2_kategori_kes_id]').removeClass("is-invalid");
				$('[name=pi2_sub_kategori_kes_id]').removeClass("is-invalid");
				$('[name=pi2_kluster_id]').removeClass("is-invalid");
				$('[name=pi2_sub_kluster_id]').removeClass("is-invalid");
				$('[name=pi2_ikes_keterangan_kes]').removeClass("is-invalid");
				$('[name=pi2_ikes_tindakan_awal]').removeClass("is-invalid");
				$('[name=pi2_ikes_sumber]').removeClass("is-invalid");

				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'pi_negeri_id') {
							$('[name=pi_negeri_id]').addClass("is-invalid");
							$('.error_pi_negeri_id').html(error);
						}

						if(index == 'pi_daerah_id') {
							$('[name=pi_daerah_id]').addClass("is-invalid");
							$('.error_pi_daerah_id').html(error);
						}

						if(index == 'pi_krt_profile_id') {
							$('[name=pi_krt_profile_id]').addClass("is-invalid");
							$('.error_pi_krt_profile_id').html(error);
						}

						if(index == 'pi1_dihantar_alamat') {
							$('[name=pi1_dihantar_alamat]').addClass("is-invalid");
							$('.error_pi1_dihantar_alamat').html(error);
						}

						if(index == 'pi2_negeri_id') {
							$('[name=pi2_negeri_id]').addClass("is-invalid");
							$('.error_pi2_negeri_id').html(error);
						}

						if(index == 'pi2_bandar_id') {
							$('[name=pi2_bandar_id]').addClass("is-invalid");
							$('.error_pi2_bandar_id').html(error);
						}

						if(index == 'pi2_ikes_lokasi') {
							$('[name=pi2_ikes_lokasi]').addClass("is-invalid");
							$('.error_pi2_ikes_lokasi').html(error);
						}

						if(index == 'pi2_parlimen_id') {
							$('[name=pi2_parlimen_id]').addClass("is-invalid");
							$('.error_pi2_parlimen_id').html(error);
						}

						if(index == 'pi2_pbt_id') {
							$('[name=pi2_pbt_id]').addClass("is-invalid");
							$('.error_pi2_pbt_id').html(error);
						}

						if(index == 'pi2_ikes_tarikh_berlaku') {
							$('[name=pi2_ikes_tarikh_berlaku]').addClass("is-invalid");
							$('.error_pi2_ikes_tarikh_berlaku').html(error);
						}

						if(index == 'pi2_daerah_id') {
							$('[name=pi2_daerah_id]').addClass("is-invalid");
							$('.error_pi2_daerah_id').html(error);
						}

						if(index == 'pi2_ikes_kawasan') {
							$('[name=pi2_ikes_kawasan]').addClass("is-invalid");
							$('.error_pi2_ikes_kawasan').html(error);
						}

						if(index == 'pi2_ikes_poskod') {
							$('[name=pi2_ikes_poskod]').addClass("is-invalid");
							$('.error_pi2_ikes_poskod').html(error);
						}

						if(index == 'pi2_dun_id') {
							$('[name=pi2_dun_id]').addClass("is-invalid");
							$('.error_pi2_dun_id').html(error);
						}

						if(index == 'pi2_ikes_bpolis') {
							$('[name=pi2_ikes_bpolis]').addClass("is-invalid");
							$('.error_pi2_ikes_bpolis').html(error);
						}

						if(index == 'pi2_peringkat_kes_id') {
							$('[name=pi2_peringkat_kes_id]').addClass("is-invalid");
							$('.error_pi2_peringkat_kes_id').html(error);
						}

						if(index == 'pi2_kategori_kes_id') {
							$('[name=pi2_kategori_kes_id]').addClass("is-invalid");
							$('.error_pi2_kategori_kes_id').html(error);
						}

						if(index == 'pi2_sub_kategori_kes_id') {
							$('[name=pi2_sub_kategori_kes_id]').addClass("is-invalid");
							$('.error_pi2_sub_kategori_kes_id').html(error);
						}

						if(index == 'pi2_kluster_id') {
							$('[name=pi2_kluster_id]').addClass("is-invalid");
							$('.error_pi2_kluster_id').html(error);
						}

						if(index == 'pi2_sub_kluster_id') {
							$('[name=pi2_sub_kluster_id]').addClass("is-invalid");
							$('.error_pi2_sub_kluster_id').html(error);
						}

						if(index == 'pi2_ikes_keterangan_kes') {
							$('[name=pi2_ikes_keterangan_kes]').addClass("is-invalid");
							$('.error_pi2_ikes_keterangan_kes').html(error);
						}

						if(index == 'pi2_ikes_tindakan_awal') {
							$('[name=pi2_ikes_tindakan_awal]').addClass("is-invalid");
							$('.error_pi2_ikes_tindakan_awal').html(error);
						}

						if(index == 'pi2_ikes_sumber') {
							$('[name=pi2_ikes_sumber]').addClass("is-invalid");
							$('.error_pi2_ikes_sumber').html(error);
						}
					});
					$('#btn_next').html(btn_text);                
					$('#btn_next').prop('disabled', false);            
				} else {
					$('#btn_next').html(btn_text);
					$('#btn_next').prop('disabled', false); 
					window.location.href = "{{route('rt-sm21.permohonan_ikes_1','')}}"+"/"+"{{$ikes->id}}";
				}
			});
		});

	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop