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
			var senarai_permohonan_ikes_bpp_config = {
				routes: {
					senarai_permohonan_ikes_bpp_url: "/rt/sm21/permohonan-ikes-bpp/{id}"
				}
			};

		/* Maklumat Kes Dalam Krt */
			$('#pipp_hasRT').on('click', function(){           
				if($(this).is(':checked')){
					$('#pipp_hasRT').val(1);
					$('#pipp_negeri_id').attr('disabled', false);
					
				} else {
					$('#pipp_negeri_id').attr('disabled', true);
					$('#pipp_daerah_id').attr('disabled', true);
					$('#pipp_krt_profile_id').attr('disabled', true);
				}
			});

			$("#pipp_negeri_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pipp_daerah_id').find('option').remove();
				$('#pipp_daerah_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_bpp_config.routes.senarai_permohonan_ikes_bpp_url,
						data: {type: 'get_daerah', value: value},
						success: function (data) {
							$('#pipp_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pipp_daerah_id')
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

			$("#pipp_daerah_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pipp_krt_profile_id').find('option').remove();
				$('#pipp_krt_profile_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_bpp_config.routes.senarai_permohonan_ikes_bpp_url,
						data: {type: 'get_krt', value: value},
						success: function (data) {
							$('#pipp_krt_profile_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pipp_krt_profile_id')
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

			$("#pipp2_kategori_kes_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pipp2_sub_kategori_kes_id').find('option').remove();
				$('#pipp2_sub_kategori_kes_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_bpp_config.routes.senarai_permohonan_ikes_bpp_url,
						data: {type: 'get_sub_kategori', value: value},
						success: function (data) {
							$('#pipp2_sub_kategori_kes_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pipp2_sub_kategori_kes_id')
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

			$("#pipp2_kluster_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pipp2_sub_kluster_id').find('option').remove();
				$('#pipp2_sub_kluster_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_bpp_config.routes.senarai_permohonan_ikes_bpp_url,
						data: {type: 'get_sub_kluster', value: value},
						success: function (data) {
							$('#pipp2_sub_kluster_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pipp2_sub_kluster_id')
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
				$('#pipp_hasRT').attr("checked", "checked");
				$('#pipp_hasRT').val(1);
				$('#pipp_negeri_id').attr('disabled', false);
				$('#pipp_daerah_id').attr('disabled', false);
				$('#pipp_krt_profile_id').attr('disabled', false);
			}
			
			$('#pipp_negeri_id').val("{{$ikes->krt_state_id}}");
			$('#pipp_daerah_id').val("{{$ikes->krt_daerah_id}}");
			$('#pipp_krt_profile_id').val("{{$ikes->krt_profile_id}}");
			
		/* Maklumat Pemohon */
			$('#pipp1_user_fullname').val("{{$ikes->nama_permohon}}");
			$('#pipp1_user_no_ic').val("{{$ikes->ic_pemohon}}");
			$('#pipp1_user_no_phone').val("{{$ikes->phone_pemohon}}");
			$('#pipp1_dihantar_alamat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
			$('#pipp1_dihantar_alamat').val("{{$ikes->dihantar_alamat}}");

		/* Maklumat Kes Kejadian */
			$("#pipp2_negeri_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pipp2_daerah_id').find('option').remove();
				$('#pipp2_daerah_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_bpp_config.routes.senarai_permohonan_ikes_bpp_url,
						data: {type: 'get_daerah', value: value},
						success: function (data) {
							$('#pipp2_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pipp2_daerah_id')
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

			$("#pipp2_daerah_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pipp2_bandar_id').find('option').remove();
				$('#pipp2_bandar_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_bpp_config.routes.senarai_permohonan_ikes_bpp_url,
						data: {type: 'get_bandar', value: value},
						success: function (data) {
							$('#pipp2_bandar_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pipp2_bandar_id')
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

			$("#pipp2_negeri_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pipp2_parlimen_id').find('option').remove();
				$('#pipp2_parlimen_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_bpp_config.routes.senarai_permohonan_ikes_bpp_url,
						data: {type: 'get_parlimen', value: value},
						success: function (data) {
							$('#pipp2_parlimen_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pipp2_parlimen_id')
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

			$("#pipp2_negeri_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pipp2_dun_id').find('option').remove();
				$('#pipp2_dun_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_bpp_config.routes.senarai_permohonan_ikes_bpp_url,
						data: {type: 'get_dun', value: value},
						success: function (data) {
							$('#pipp2_dun_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pipp2_dun_id')
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

			$("#pipp2_negeri_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pipp2_pbt_id').find('option').remove();
				$('#pipp2_pbt_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_ikes_bpp_config.routes.senarai_permohonan_ikes_bpp_url,
						data: {type: 'get_pbt', value: value},
						success: function (data) {
							$('#pipp2_pbt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pipp2_pbt_id')
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
        
			$('#pipp3_ikes_id').val("{{$ikes->id}}");
			$('#pipp2_negeri_id').val("{{$ikes->state_id}}");
			if("{{$ikes->daerah_id}}" !== ''){
				$('#pipp2_daerah_id').attr('disabled', false);
			}else{
				$('#pipp2_daerah_id').attr('disabled', true);
			}
			$('#pipp2_daerah_id').val("{{$ikes->daerah_id}}");
			if("{{$ikes->bandar_id}}" !== ''){
				$('#pipp2_bandar_id').attr('disabled', false);
			}else{
				$('#pipp2_bandar_id').attr('disabled', true);
			}
			$('#pipp2_bandar_id').val("{{$ikes->bandar_id}}");
			$('#pipp2_ikes_kawasan').val("{{$ikes->ikes_kawasan}}");
			$('#pipp2_ikes_lokasi').val("{{$ikes->ikes_lokasi}}");
			$('#pipp2_ikes_poskod').val("{{$ikes->ikes_poskod}}");
			if("{{$ikes->parlimen_id}}" !== ''){
				$('#pipp2_parlimen_id').attr('disabled', false);
			}else{
				$('#pipp2_parlimen_id').attr('disabled', true);
			}
			$('#pipp2_parlimen_id').val("{{$ikes->parlimen_id}}");
			if("{{$ikes->dun_id}}" !== ''){
				$('#pipp2_dun_id').attr('disabled', false);
			}else{
				$('#pipp2_dun_id').attr('disabled', true);
			}
			$('#pipp2_dun_id').val("{{$ikes->dun_id}}");
			if("{{$ikes->pbt_id}}" !== ''){
				$('#pipp2_pbt_id').attr('disabled', false);
			}else{
				$('#pipp2_pbt_id').attr('disabled', true);
			}
			$('#pipp2_pbt_id').val("{{$ikes->pbt_id}}");
			$('#pipp2_ikes_bpolis').val("{{$ikes->ikes_bpolis}}");
			$('#pipp2_ikes_tarikh_berlaku').val("{{$ikes->ikes_tarikh_berlaku}}");
			$('#pipp2_peringkat_kes_id').val("{{$ikes->peringkat_id}}");
			$('#pipp2_kategori_kes_id').val("{{$ikes->kategori_id}}");
			if("{{$ikes->sub_kategori_id}}" !== ''){
				var value = "{{$ikes->kategori_id}}";
				$('#pipp2_sub_kategori_kes_id').attr('disabled', false);
				$.ajax({
					type: "GET",
					url: senarai_permohonan_ikes_bpp_config.routes.senarai_permohonan_ikes_bpp_url,
					data: {type: 'get_sub_kategori', value: value},
					success: function (data) {
						
						$('#pipp2_sub_kategori_kes_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#pipp2_sub_kategori_kes_id')
							.append($('<option>')
							.text(obj.sub_kategori_description)
							.attr('value', obj.id));
							$('#pipp2_sub_kategori_kes_id').val("{{$ikes->sub_kategori_id}}");
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}else{
				$('#pipp2_sub_kategori_kes_id').attr('disabled', true);
			}
			$('#pipp2_kluster_id').val("{{$ikes->kluster_id}}");
			if("{{$ikes->sub_kluster_id}}" !== ''){
				var value = "{{$ikes->kluster_id}}";
				$('#pipp2_sub_kluster_id').attr('disabled', false);
				$.ajax({
					type: "GET",
					url: senarai_permohonan_ikes_bpp_config.routes.senarai_permohonan_ikes_bpp_url,
					data: {type: 'get_sub_kluster', value: value},
					success: function (data) {
						
						$('#pipp2_sub_kluster_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#pipp2_sub_kluster_id')
							.append($('<option>')
							.text(obj.subkluster_description)
							.attr('value', obj.id));
							$('#pipp2_sub_kluster_id').val("{{$ikes->sub_kluster_id}}");
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}else{
				$('#pipp2_sub_kluster_id').attr('disabled', true);
			}
			$('#pipp2_ikes_keterangan_kes').html("{{$ikes->ikes_keterangan_kes}}");
			$('#pipp2_ikes_tindakan_awal').html("{{$ikes->ikes_tindakan_awal}}");
			$('#pipp2_ikes_keterangan_kes').summernote({
				height: 200
			});

			$('#pipp2_ikes_tindakan_awal').summernote({
				height: 200
			});
			$('#pipp2_ikes_sumber').val("{{$ikes->ikes_sumber}}");

		/* Maklumat Note Kemaskini */
			$('#pipp_status').val("{{$ikes->status}}");

			if($('#pipp_status').val() == '11'){
				$("#pipp_perlu_kemaskini").show();
				$('#pipp_status_description').html("{{$ikes->status_description}}");
				$('#pipp_disemak_note').html("{{$ikes->disemak_note}}");
			}

			if($('#pipp_status').val() == '12'){
				$("#pipp_perlu_kemaskini").show();
				$('#pipp_status_description').html("{{$ikes->status_description}}");
				$('#pipp_disahkan_note').html("{{$ikes->disahkan_note}}");
			}

			if($('#pipp_status').val() == '15'){
				$("#pipp_perlu_kemaskini").show();
				$('#pipp_status_description').html("{{$ikes->status_description}}");
				$('#pipp_disahkan_note').html("{{$ikes->disahkan_note}}");
			}

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm21.senarai_permohonan_ikes_bpp') }}";
			});

	});

	/* click btn next */
		//my custom script
		var permohonan_ikes_bpp_1_config = {
			routes: {
				permohonan_ikes_bpp_1_url: "{{ route('rt-sm21.post_permohonan_ikes_bpp_1') }}",
			}
		};

		$(document).on('submit', '#form_pipp3', function(event){    
			event.preventDefault();
			$('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_next').prop('disabled', true);
			var data   = $("#form_pipp, #form_pipp1, #form_pipp2, #form_pipp3").serialize();
			var action = $('#post_permohonan_ikes_bpp_1').val();
			var btn_text;
			if (action == 'edit') {
				url = permohonan_ikes_bpp_1_config.routes.permohonan_ikes_bpp_1_url;
				type = "POST";
				btn_text = 'Seterusnya &nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=pipp_negeri_id]').removeClass("is-invalid");
				$('[name=pipp_daerah_id]').removeClass("is-invalid");
				$('[name=pipp_krt_profile_id]').removeClass("is-invalid");
				$('[name=pipp1_dihantar_alamat]').removeClass("is-invalid");
				$('[name=pipp2_negeri_id]').removeClass("is-invalid");
				$('[name=pipp2_bandar_id]').removeClass("is-invalid");
				$('[name=pipp2_ikes_lokasi]').removeClass("is-invalid");
				$('[name=pipp2_parlimen_id]').removeClass("is-invalid");
				$('[name=pipp2_pbt_id]').removeClass("is-invalid");
				$('[name=pipp2_ikes_tarikh_berlaku]').removeClass("is-invalid");
				$('[name=pipp2_daerah_id]').removeClass("is-invalid");
				$('[name=pipp2_ikes_kawasan]').removeClass("is-invalid");
				$('[name=pipp2_ikes_poskod]').removeClass("is-invalid");
				$('[name=pipp2_dun_id]').removeClass("is-invalid");
				$('[name=pipp2_ikes_bpolis]').removeClass("is-invalid");
				$('[name=pipp2_peringkat_kes_id]').removeClass("is-invalid");
				$('[name=pipp2_kategori_kes_id]').removeClass("is-invalid");
				$('[name=pipp2_sub_kategori_kes_id]').removeClass("is-invalid");
				$('[name=pipp2_kluster_id]').removeClass("is-invalid");
				$('[name=pipp2_sub_kluster_id]').removeClass("is-invalid");
				$('[name=pipp2_ikes_keterangan_kes]').removeClass("is-invalid");
				$('[name=pipp2_ikes_tindakan_awal]').removeClass("is-invalid");
				$('[name=pipp2_ikes_sumber]').removeClass("is-invalid");

				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'pipp_negeri_id') {
							$('[name=pipp_negeri_id]').addClass("is-invalid");
							$('.error_pipp_negeri_id').html(error);
						}

						if(index == 'pipp_daerah_id') {
							$('[name=pipp_daerah_id]').addClass("is-invalid");
							$('.error_pipp_daerah_id').html(error);
						}

						if(index == 'pipp_krt_profile_id') {
							$('[name=pipp_krt_profile_id]').addClass("is-invalid");
							$('.error_pipp_krt_profile_id').html(error);
						}

						if(index == 'pipp1_dihantar_alamat') {
							$('[name=pipp1_dihantar_alamat]').addClass("is-invalid");
							$('.error_pipp1_dihantar_alamat').html(error);
						}

						if(index == 'pipp2_negeri_id') {
							$('[name=pipp2_negeri_id]').addClass("is-invalid");
							$('.error_pipp2_negeri_id').html(error);
						}

						if(index == 'pipp2_bandar_id') {
							$('[name=pipp2_bandar_id]').addClass("is-invalid");
							$('.error_pipp2_bandar_id').html(error);
						}

						if(index == 'pipp2_ikes_lokasi') {
							$('[name=pipp2_ikes_lokasi]').addClass("is-invalid");
							$('.error_pipp2_ikes_lokasi').html(error);
						}

						if(index == 'pipp2_parlimen_id') {
							$('[name=pipp2_parlimen_id]').addClass("is-invalid");
							$('.error_pipp2_parlimen_id').html(error);
						}

						if(index == 'pipp2_pbt_id') {
							$('[name=pipp2_pbt_id]').addClass("is-invalid");
							$('.error_pipp2_pbt_id').html(error);
						}

						if(index == 'pipp2_ikes_tarikh_berlaku') {
							$('[name=pipp2_ikes_tarikh_berlaku]').addClass("is-invalid");
							$('.error_pipp2_ikes_tarikh_berlaku').html(error);
						}

						if(index == 'pipp2_daerah_id') {
							$('[name=pipp2_daerah_id]').addClass("is-invalid");
							$('.error_pipp2_daerah_id').html(error);
						}

						if(index == 'pipp2_ikes_kawasan') {
							$('[name=pipp2_ikes_kawasan]').addClass("is-invalid");
							$('.error_pipp2_ikes_kawasan').html(error);
						}

						if(index == 'pipp2_ikes_poskod') {
							$('[name=pipp2_ikes_poskod]').addClass("is-invalid");
							$('.error_pipp2_ikes_poskod').html(error);
						}

						if(index == 'pipp2_dun_id') {
							$('[name=pipp2_dun_id]').addClass("is-invalid");
							$('.error_pipp2_dun_id').html(error);
						}

						if(index == 'pipp2_ikes_bpolis') {
							$('[name=pipp2_ikes_bpolis]').addClass("is-invalid");
							$('.error_pipp2_ikes_bpolis').html(error);
						}

						if(index == 'pipp2_peringkat_kes_id') {
							$('[name=pipp2_peringkat_kes_id]').addClass("is-invalid");
							$('.error_pipp2_peringkat_kes_id').html(error);
						}

						if(index == 'pipp2_kategori_kes_id') {
							$('[name=pipp2_kategori_kes_id]').addClass("is-invalid");
							$('.error_pipp2_kategori_kes_id').html(error);
						}

						if(index == 'pipp2_sub_kategori_kes_id') {
							$('[name=pipp2_sub_kategori_kes_id]').addClass("is-invalid");
							$('.error_pipp2_sub_kategori_kes_id').html(error);
						}

						if(index == 'pipp2_kluster_id') {
							$('[name=pipp2_kluster_id]').addClass("is-invalid");
							$('.error_pipp2_kluster_id').html(error);
						}

						if(index == 'pipp2_sub_kluster_id') {
							$('[name=pipp2_sub_kluster_id]').addClass("is-invalid");
							$('.error_pipp2_sub_kluster_id').html(error);
						}

						if(index == 'pipp2_ikes_keterangan_kes') {
							$('[name=pipp2_ikes_keterangan_kes]').addClass("is-invalid");
							$('.error_pipp2_ikes_keterangan_kes').html(error);
						}

						if(index == 'pipp2_ikes_tindakan_awal') {
							$('[name=pipp2_ikes_tindakan_awal]').addClass("is-invalid");
							$('.error_pipp2_ikes_tindakan_awal').html(error);
						}

						if(index == 'pipp2_ikes_sumber') {
							$('[name=pipp2_ikes_sumber]').addClass("is-invalid");
							$('.error_pipp2_ikes_sumber').html(error);
						}
					});
					$('#btn_next').html(btn_text);                
					$('#btn_next').prop('disabled', false);            
				} else {
					$('#btn_next').html(btn_text);
					$('#btn_next').prop('disabled', false); 
					window.location.href = "{{route('rt-sm21.permohonan_ikes_bpp_1','')}}"+"/"+"{{$ikes->id}}";
				}
			});
		});

	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop