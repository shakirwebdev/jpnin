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
			var senarai_permohonan_ikes_ppn_config = {
				routes: {
					senarai_permohonan_ikes_ppn_url: "/rt/sm21/permohonan-ikes-ppn/{id}"
				}
			};

		/* Maklumat Kes Dalam Krt */
			$('#pipn_hasRT').on('click', function(){           
				if($(this).is(':checked')){
					$('#pipn_hasRT').val(1);
					$('#pipn_negeri_id').attr('disabled', false);
					
				} else {
					$('#pipn_negeri_id').attr('disabled', true);
					$('#pipn_daerah_id').attr('disabled', true);
					$('#pipn_krt_profile_id').attr('disabled', true);
				}
			});

			$("#pipn_negeri_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pipn_daerah_id').find('option').remove();
				$('#pipn_daerah_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_ppn_config.routes.senarai_permohonan_ikes_ppn_url,
						data: {type: 'get_daerah', value: value},
						success: function (data) {
							$('#pipn_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pipn_daerah_id')
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

			$("#pipn_daerah_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pipn_krt_profile_id').find('option').remove();
				$('#pipn_krt_profile_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_ppn_config.routes.senarai_permohonan_ikes_ppn_url,
						data: {type: 'get_krt', value: value},
						success: function (data) {
							$('#pipn_krt_profile_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pipn_krt_profile_id')
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

			$("#pipn2_kategori_kes_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pipn2_sub_kategori_kes_id').find('option').remove();
				$('#pipn2_sub_kategori_kes_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_ppn_config.routes.senarai_permohonan_ikes_ppn_url,
						data: {type: 'get_sub_kategori', value: value},
						success: function (data) {
							$('#pipn2_sub_kategori_kes_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pipn2_sub_kategori_kes_id')
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

			$("#pipn2_kluster_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pipn2_sub_kluster_id').find('option').remove();
				$('#pipn2_sub_kluster_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_ppn_config.routes.senarai_permohonan_ikes_ppn_url,
						data: {type: 'get_sub_kluster', value: value},
						success: function (data) {
							$('#pipn2_sub_kluster_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pipn2_sub_kluster_id')
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

			if("{{$ikes->hasRT}}" == 1){
				$('#pipn_hasRT').attr("checked", "checked");
				$('#pipn_hasRT').val(1);
				$('#pipn_negeri_id').attr('disabled', false);
				$('#pipn_daerah_id').attr('disabled', false);
				$('#pipn_krt_profile_id').attr('disabled', false);
			}
			
			$('#pipn_negeri_id').val("{{$ikes->krt_state_id}}");
			$('#pipn_daerah_id').val("{{$ikes->krt_daerah_id}}");
			$('#pipn_krt_profile_id').val("{{$ikes->krt_profile_id}}");
			
		/* Maklumat Pemohon */
			$('#pipn1_user_fullname').val("{{$ikes->nama_permohon}}");
			$('#pipn1_user_no_ic').val("{{$ikes->ic_pemohon}}");
			$('#pipn1_user_no_phone').val("{{$ikes->phone_pemohon}}");
			$('#pipn1_dihantar_alamat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
			$('#pipn1_dihantar_alamat').val("{{$ikes->dihantar_alamat}}");

		/* Maklumat Kes Kejadian */
			$("#pipn2_negeri_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pipn2_daerah_id').find('option').remove();
				$('#pipn2_daerah_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_ppn_config.routes.senarai_permohonan_ikes_ppn_url,
						data: {type: 'get_daerah', value: value},
						success: function (data) {
							$('#pipn2_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pipn2_daerah_id')
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

			$("#pipn2_daerah_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pipn2_bandar_id').find('option').remove();
				$('#pipn2_bandar_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_ppn_config.routes.senarai_permohonan_ikes_ppn_url,
						data: {type: 'get_bandar', value: value},
						success: function (data) {
							$('#pipn2_bandar_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pipn2_bandar_id')
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

			$("#pipn2_negeri_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pipn2_parlimen_id').find('option').remove();
				$('#pipn2_parlimen_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_ppn_config.routes.senarai_permohonan_ikes_ppn_url,
						data: {type: 'get_parlimen', value: value},
						success: function (data) {
							$('#pipn2_parlimen_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pipn2_parlimen_id')
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

			$("#pipn2_negeri_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pipn2_dun_id').find('option').remove();
				$('#pipn2_dun_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_ppn_config.routes.senarai_permohonan_ikes_ppn_url,
						data: {type: 'get_dun', value: value},
						success: function (data) {
							$('#pipn2_dun_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pipn2_dun_id')
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

			$("#pipn2_negeri_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pipn2_pbt_id').find('option').remove();
				$('#pipn2_pbt_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_ppn_config.routes.senarai_permohonan_ikes_ppn_url,
						data: {type: 'get_pbt', value: value},
						success: function (data) {
							$('#pipn2_pbt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pipn2_pbt_id')
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
        
			$('#pipn3_ikes_id').val("{{$ikes->id}}");
			$('#pipn2_negeri_id').val("{{$ikes->state_id}}");
			if("{{$ikes->daerah_id}}" !== ''){
				$('#pipn2_daerah_id').attr('disabled', false);
			}else{
				$('#pipn2_daerah_id').attr('disabled', true);
			}
			$('#pipn2_daerah_id').val("{{$ikes->daerah_id}}");
			if("{{$ikes->bandar_id}}" !== ''){
				$('#pipn2_bandar_id').attr('disabled', false);
			}else{
				$('#pipn2_bandar_id').attr('disabled', true);
			}
			$('#pipn2_bandar_id').val("{{$ikes->bandar_id}}");
			$('#pipn2_ikes_kawasan').val("{{$ikes->ikes_kawasan}}");
			$('#pipn2_ikes_lokasi').val("{{$ikes->ikes_lokasi}}");
			$('#pipn2_ikes_poskod').val("{{$ikes->ikes_poskod}}");
			if("{{$ikes->parlimen_id}}" !== ''){
				$('#pipn2_parlimen_id').attr('disabled', false);
			}else{
				$('#pipn2_parlimen_id').attr('disabled', true);
			}
			$('#pipn2_parlimen_id').val("{{$ikes->parlimen_id}}");
			if("{{$ikes->dun_id}}" !== ''){
				$('#pipn2_dun_id').attr('disabled', false);
			}else{
				$('#pipn2_dun_id').attr('disabled', true);
			}
			$('#pipn2_dun_id').val("{{$ikes->dun_id}}");
			if("{{$ikes->pbt_id}}" !== ''){
				$('#pipn2_pbt_id').attr('disabled', false);
			}else{
				$('#pipn2_pbt_id').attr('disabled', true);
			}
			$('#pipn2_pbt_id').val("{{$ikes->pbt_id}}");
			$('#pipn2_ikes_bpolis').val("{{$ikes->ikes_bpolis}}");
			$('#pipn2_ikes_tarikh_berlaku').val("{{$ikes->ikes_tarikh_berlaku}}");
			$('#pipn2_peringkat_kes_id').val("{{$ikes->peringkat_id}}");
			$('#pipn2_kategori_kes_id').val("{{$ikes->kategori_id}}");
			if("{{$ikes->sub_kategori_id}}" !== ''){
				var value = "{{$ikes->kategori_id}}";
				$('#pipn2_sub_kategori_kes_id').attr('disabled', false);
				$.ajax({
					type: "GET",
					url: senarai_permohonan_ikes_ppn_config.routes.senarai_permohonan_ikes_ppn_url,
					data: {type: 'get_sub_kategori', value: value},
					success: function (data) {
						
						$('#pipn2_sub_kategori_kes_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#pipn2_sub_kategori_kes_id')
							.append($('<option>')
							.text(obj.sub_kategori_description)
							.attr('value', obj.id));
							$('#pipn2_sub_kategori_kes_id').val("{{$ikes->sub_kategori_id}}");
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}else{
				$('#pipn2_sub_kategori_kes_id').attr('disabled', true);
			}
			$('#pipn2_kluster_id').val("{{$ikes->kluster_id}}");
			if("{{$ikes->sub_kluster_id}}" !== ''){
				var value = "{{$ikes->kluster_id}}";
				$('#pipn2_sub_kluster_id').attr('disabled', false);
				$.ajax({
					type: "GET",
					url: senarai_permohonan_ikes_ppn_config.routes.senarai_permohonan_ikes_ppn_url,
					data: {type: 'get_sub_kluster', value: value},
					success: function (data) {
						
						$('#pipn2_sub_kluster_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#pipn2_sub_kluster_id')
							.append($('<option>')
							.text(obj.subkluster_description)
							.attr('value', obj.id));
							$('#pipn2_sub_kluster_id').val("{{$ikes->sub_kluster_id}}");
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}else{
				$('#pipn2_sub_kluster_id').attr('disabled', true);
			}
			$('#pipn2_ikes_keterangan_kes').html("{{$ikes->ikes_keterangan_kes}}");
			$('#pipn2_ikes_tindakan_awal').html("{{$ikes->ikes_tindakan_awal}}");
			$('#pipn2_ikes_keterangan_kes').summernote({
				height: 200
			});

			$('#pipn2_ikes_tindakan_awal').summernote({
				height: 200
			});
			$('#pipn2_ikes_sumber').val("{{$ikes->ikes_sumber}}");

		/* Maklumat Note Kemaskini */
			$('#pipn_status').val("{{$ikes->status}}");

			if($('#pipn_status').val() == '11'){
				$("#pipn_perlu_kemaskini").show();
				$('#pipn_status_description').html("{{$ikes->status_description}}");
				$('#pipn_disemak_note').html("{{$ikes->disemak_note}}");
			}

			if($('#pipn_status').val() == '12'){
				$("#pipn_perlu_kemaskini").show();
				$('#pipn_status_description').html("{{$ikes->status_description}}");
				$('#pipn_disahkan_note').html("{{$ikes->disahkan_note}}");
			}

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm21.senarai_permohonan_ikes_ppn') }}";
			});

	});

	/* click btn next */
		//my custom script
		var permohonan_ikes_ppn_1_config = {
			routes: {
				permohonan_ikes_ppn_1_url: "{{ route('rt-sm21.post_permohonan_ikes_ppn_1') }}",
			}
		};

		$(document).on('submit', '#form_pipn3', function(event){    
			event.preventDefault();
			$('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_next').prop('disabled', true);
			var data   = $("#form_pipn, #form_pipn1, #form_pipn2, #form_pipn3").serialize();
			var action = $('#post_permohonan_ikes_ppn_1').val();
			var btn_text;
			if (action == 'edit') {
				url = permohonan_ikes_ppn_1_config.routes.permohonan_ikes_ppn_1_url;
				type = "POST";
				btn_text = 'Seterusnya &nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=pipn_negeri_id]').removeClass("is-invalid");
				$('[name=pipn_daerah_id]').removeClass("is-invalid");
				$('[name=pipn_krt_profile_id]').removeClass("is-invalid");
				$('[name=pipn1_dihantar_alamat]').removeClass("is-invalid");
				$('[name=pipn2_negeri_id]').removeClass("is-invalid");
				$('[name=pipn2_bandar_id]').removeClass("is-invalid");
				$('[name=pipn2_ikes_lokasi]').removeClass("is-invalid");
				$('[name=pipn2_parlimen_id]').removeClass("is-invalid");
				$('[name=pipn2_pbt_id]').removeClass("is-invalid");
				$('[name=pipn2_ikes_tarikh_berlaku]').removeClass("is-invalid");
				$('[name=pipn2_daerah_id]').removeClass("is-invalid");
				$('[name=pipn2_ikes_kawasan]').removeClass("is-invalid");
				$('[name=pipn2_ikes_poskod]').removeClass("is-invalid");
				$('[name=pipn2_dun_id]').removeClass("is-invalid");
				$('[name=pipn2_ikes_bpolis]').removeClass("is-invalid");
				$('[name=pipn2_peringkat_kes_id]').removeClass("is-invalid");
				$('[name=pipn2_kategori_kes_id]').removeClass("is-invalid");
				$('[name=pipn2_sub_kategori_kes_id]').removeClass("is-invalid");
				$('[name=pipn2_kluster_id]').removeClass("is-invalid");
				$('[name=pipn2_sub_kluster_id]').removeClass("is-invalid");
				$('[name=pipn2_ikes_keterangan_kes]').removeClass("is-invalid");
				$('[name=pipn2_ikes_tindakan_awal]').removeClass("is-invalid");
				$('[name=pipn2_ikes_sumber]').removeClass("is-invalid");

				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'pipn_negeri_id') {
							$('[name=pipn_negeri_id]').addClass("is-invalid");
							$('.error_pipn_negeri_id').html(error);
						}

						if(index == 'pipn_daerah_id') {
							$('[name=pipn_daerah_id]').addClass("is-invalid");
							$('.error_pipn_daerah_id').html(error);
						}

						if(index == 'pipn_krt_profile_id') {
							$('[name=pipn_krt_profile_id]').addClass("is-invalid");
							$('.error_pipn_krt_profile_id').html(error);
						}

						if(index == 'pipn1_dihantar_alamat') {
							$('[name=pipn1_dihantar_alamat]').addClass("is-invalid");
							$('.error_pipn1_dihantar_alamat').html(error);
						}

						if(index == 'pipn2_negeri_id') {
							$('[name=pipn2_negeri_id]').addClass("is-invalid");
							$('.error_pipn2_negeri_id').html(error);
						}

						if(index == 'pipn2_bandar_id') {
							$('[name=pipn2_bandar_id]').addClass("is-invalid");
							$('.error_pipn2_bandar_id').html(error);
						}

						if(index == 'pipn2_ikes_lokasi') {
							$('[name=pipn2_ikes_lokasi]').addClass("is-invalid");
							$('.error_pipn2_ikes_lokasi').html(error);
						}

						if(index == 'pipn2_parlimen_id') {
							$('[name=pipn2_parlimen_id]').addClass("is-invalid");
							$('.error_pipn2_parlimen_id').html(error);
						}

						if(index == 'pipn2_pbt_id') {
							$('[name=pipn2_pbt_id]').addClass("is-invalid");
							$('.error_pipn2_pbt_id').html(error);
						}

						if(index == 'pipn2_ikes_tarikh_berlaku') {
							$('[name=pipn2_ikes_tarikh_berlaku]').addClass("is-invalid");
							$('.error_pipn2_ikes_tarikh_berlaku').html(error);
						}

						if(index == 'pipn2_daerah_id') {
							$('[name=pipn2_daerah_id]').addClass("is-invalid");
							$('.error_pipn2_daerah_id').html(error);
						}

						if(index == 'pipn2_ikes_kawasan') {
							$('[name=pipn2_ikes_kawasan]').addClass("is-invalid");
							$('.error_pipn2_ikes_kawasan').html(error);
						}

						if(index == 'pipn2_ikes_poskod') {
							$('[name=pipn2_ikes_poskod]').addClass("is-invalid");
							$('.error_pipn2_ikes_poskod').html(error);
						}

						if(index == 'pipn2_dun_id') {
							$('[name=pipn2_dun_id]').addClass("is-invalid");
							$('.error_pipn2_dun_id').html(error);
						}

						if(index == 'pipn2_ikes_bpolis') {
							$('[name=pipn2_ikes_bpolis]').addClass("is-invalid");
							$('.error_pipn2_ikes_bpolis').html(error);
						}

						if(index == 'pipn2_peringkat_kes_id') {
							$('[name=pipn2_peringkat_kes_id]').addClass("is-invalid");
							$('.error_pipn2_peringkat_kes_id').html(error);
						}

						if(index == 'pipn2_kategori_kes_id') {
							$('[name=pipn2_kategori_kes_id]').addClass("is-invalid");
							$('.error_pipn2_kategori_kes_id').html(error);
						}

						if(index == 'pipn2_sub_kategori_kes_id') {
							$('[name=pipn2_sub_kategori_kes_id]').addClass("is-invalid");
							$('.error_pipn2_sub_kategori_kes_id').html(error);
						}

						if(index == 'pipn2_kluster_id') {
							$('[name=pipn2_kluster_id]').addClass("is-invalid");
							$('.error_pipn2_kluster_id').html(error);
						}

						if(index == 'pipn2_sub_kluster_id') {
							$('[name=pipn2_sub_kluster_id]').addClass("is-invalid");
							$('.error_pipn2_sub_kluster_id').html(error);
						}

						if(index == 'pipn2_ikes_keterangan_kes') {
							$('[name=pipn2_ikes_keterangan_kes]').addClass("is-invalid");
							$('.error_pipn2_ikes_keterangan_kes').html(error);
						}

						if(index == 'pipn2_ikes_tindakan_awal') {
							$('[name=pipn2_ikes_tindakan_awal]').addClass("is-invalid");
							$('.error_pipn2_ikes_tindakan_awal').html(error);
						}

						if(index == 'pipn2_ikes_sumber') {
							$('[name=pipn2_ikes_sumber]').addClass("is-invalid");
							$('.error_pipn2_ikes_sumber').html(error);
						}
					});
					$('#btn_next').html(btn_text);                
					$('#btn_next').prop('disabled', false);            
				} else {
					$('#btn_next').html(btn_text);
					$('#btn_next').prop('disabled', false); 
					window.location.href = "{{route('rt-sm21.permohonan_ikes_ppn_1','')}}"+"/"+"{{$ikes->id}}";
				}
			});
		});

	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop