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
			var senarai_permohonan_imuhibbah_config = {
				routes: {
					senarai_permohonan_imuhibbah_url: "/rt/sm22/permohonan-muhibbah-ppd/{id}"
				}
			};

		/* Maklumat Kes Dalam Krt */
			$('#pmpd_hasRT').on('click', function(){           
				if($(this).is(':checked')){
					$('#pmpd_hasRT').val(1);
					$('#pmpd_state_id').attr('disabled', false);
					
				} else {
					$('#pmpd_state_id').attr('disabled', true);
					$('#pmpd_daerah_id').attr('disabled', true);
					$('#pmpd_krt_profile_id').attr('disabled', true);
				}
			});

			$("#pmpd_state_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pmpd_daerah_id').find('option').remove();
				$('#pmpd_daerah_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_imuhibbah_config.routes.senarai_permohonan_imuhibbah_url,
						data: {type: 'get_daerah', value: value},
						success: function (data) {
							$('#pmpd_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pmpd_daerah_id')
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

			$("#pmpd_daerah_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pmpd_krt_profile_id').find('option').remove();
				$('#pmpd_krt_profile_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_imuhibbah_config.routes.senarai_permohonan_imuhibbah_url,
						data: {type: 'get_krt', value: value},
						success: function (data) {
							$('#pmpd_krt_profile_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pmpd_krt_profile_id')
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

			if("{{$imuhibbah->hasRT}}" == 1){
				$('#pmpd_hasRT').attr("checked", "checked");
				$('#pmpd_hasRT').val(1);
				$('#pmpd_state_id').attr('disabled', false);
				$('#pmpd_daerah_id').attr('disabled', false);
				$('#pmpd_krt_profile_id').attr('disabled', false);
			}

			$('#pmpd_state_id').val("{{$imuhibbah->krt_state_id}}");
			$('#pmpd_daerah_id').val("{{$imuhibbah->krt_daerah_id}}");
			$('#pmpd_krt_profile_id').val("{{$imuhibbah->krt_profile_id}}");

		/* Maklumat Pemohon */
			$('#pmpd1_nama_permohon').val("{{$imuhibbah->nama_permohon}}");
			$('#pmpd1_ic_pemohon').val("{{$imuhibbah->ic_pemohon}}");
			$('#pmpd1_phone_pemohon').val("{{$imuhibbah->phone_pemohon}}");

		/* Maklumat Kes Kejadian */
			$('#pmpd2_imuhibbah_tajuk').val("{{$imuhibbah->imuhibbah_tajuk}}");
			$('#pmpd2_state_id').val("{{$imuhibbah->state_id}}");
			if("{{$imuhibbah->bandar_id}}" !== ''){
				$('#pmpd2_bandar_id').attr('disabled', false);
			}else{
				$('#pmpd2_bandar_id').attr('disabled', true);
			}
			$('#pmpd2_bandar_id').val("{{$imuhibbah->bandar_id}}");
			$('#pmpd2_imuhibbah_lokasi').val("{{$imuhibbah->imuhibbah_lokasi}}");
			if("{{$imuhibbah->parlimen_id}}" !== ''){
				$('#pmpd2_parlimen_id').attr('disabled', false);
			}else{
				$('#pmpd2_parlimen_id').attr('disabled', true);
			}
			$('#pmpd2_parlimen_id').val("{{$imuhibbah->parlimen_id}}");
			if("{{$imuhibbah->pbt_id}}" !== ''){
				$('#pmpd2_pbt_id').attr('disabled', false);
			}else{
				$('#pmpd2_pbt_id').attr('disabled', true);
			}
			$('#pmpd2_pbt_id').val("{{$imuhibbah->pbt_id}}");

			if("{{$imuhibbah->daerah_id}}" !== ''){
				$('#pmpd2_daerah_id').attr('disabled', false);
			}else{
				$('#pmpd2_daerah_id').attr('disabled', true);
			}
			$('#pmpd2_daerah_id').val("{{$imuhibbah->daerah_id}}");

			$('#pmpd2_imuhibbah_kawasan').val("{{$imuhibbah->imuhibbah_kawasan}}");
			$('#pmpd2_imuhibbah_poskod').val("{{$imuhibbah->imuhibbah_poskod}}");

			if("{{$imuhibbah->dun_id}}" !== ''){
				$('#pmpd2_dun_id').attr('disabled', false);
			}else{
				$('#pmpd2_dun_id').attr('disabled', true);
			}
			$('#pmpd2_dun_id').val("{{$imuhibbah->dun_id}}");

			$('#pmpd2_imuhibbah_tarikh_laporan').val("{{$imuhibbah->imuhibbah_tarikh_laporan}}");
			$('#pmpd2_imuhibbah_tarikh_j_berlaku').val("{{$imuhibbah->imuhibbah_tarikh_j_berlaku}}");
			$('#pmpd2_imuhibbah_laporan').html("{{$imuhibbah->imuhibbah_laporan}}");
			$('#pmpd2_imuhibbah_sumber_maklumat').html("{{$imuhibbah->imuhibbah_sumber_maklumat}}");
			$('#pmpd2_imuhibbah_pelapor_nama').val("{{$imuhibbah->imuhibbah_pelapor_nama}}");
			$('#pmpd2_imuhibbah_pelapor_no').val("{{$imuhibbah->imuhibbah_pelapor_no}}");
			$('#pmpd2_imuhibbah_pelapor_jawatan').val("{{$imuhibbah->imuhibbah_pelapor_jawatan}}");
			$('#pmpd2_imuhibbah_pelapor_alamat').val("{{$imuhibbah->imuhibbah_pelapor_alamat}}");

			$('#pmpd2_imuhibbah_pelapor_alamat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

			$('#pmpd2_imuhibbah_pelapor_alamat').on("paste",function(e) {
                e.preventDefault();
            });

			$("#pmpd2_state_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pmpd2_daerah_id').find('option').remove();
				$('#pmpd2_daerah_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_imuhibbah_config.routes.senarai_permohonan_imuhibbah_url,
						data: {type: 'get_daerah', value: value},
						success: function (data) {
							$('#pmpd2_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pmpd2_daerah_id')
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

			$("#pmpd2_daerah_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pmpd2_bandar_id').find('option').remove();
				$('#pmpd2_bandar_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_imuhibbah_config.routes.senarai_permohonan_imuhibbah_url,
						data: {type: 'get_bandar', value: value},
						success: function (data) {
							$('#pmpd2_bandar_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pmpd2_bandar_id')
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

			$("#pmpd2_state_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pmpd2_parlimen_id').find('option').remove();
				$('#pmpd2_parlimen_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_imuhibbah_config.routes.senarai_permohonan_imuhibbah_url,
						data: {type: 'get_parlimen', value: value},
						success: function (data) {
							$('#pmpd2_parlimen_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pmpd2_parlimen_id')
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

			$("#pmpd2_state_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pmpd2_dun_id').find('option').remove();
				$('#pmpd2_dun_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_imuhibbah_config.routes.senarai_permohonan_imuhibbah_url,
						data: {type: 'get_dun', value: value},
						success: function (data) {
							$('#pmpd2_dun_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pmpd2_dun_id')
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

			$("#pmpd2_state_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pmpd2_pbt_id').find('option').remove();
				$('#pmpd2_pbt_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_imuhibbah_config.routes.senarai_permohonan_imuhibbah_url,
						data: {type: 'get_pbt', value: value},
						success: function (data) {
							$('#pmpd2_pbt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pmpd2_pbt_id')
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

			$('#pmpd2_imuhibbah_laporan').summernote({
				height: 200
			});

			$('#pmpd2_imuhibbah_sumber_maklumat').summernote({
				height: 200
			});

			$('#pmpd3_imuhibbah_id').val("{{$imuhibbah->id}}");

		/* Maklumat Note Kemaskini */
			$('#pmpd_status').val("{{$imuhibbah->status}}");

			if($('#pmpd_status').val() == '5'){
				$("#pmpd_perlu_kemaskini").show();
				$('#pmpd_status_description').html("{{$imuhibbah->status_description}}");
				$('#pmpd_diakui_note').html("{{$imuhibbah->diakui_note}}");
			}

			if($('#pmpd_status').val() == '7'){
				$("#pmpd_perlu_kemaskini").show();
				$('#pmpd_status_description').html("{{$imuhibbah->status_description}}");
				$('#pmpd_disemak_note').html("{{$imuhibbah->disemak_note}}");
			}

			if($('#pmpd_status').val() == '8'){
				$("#pmpd_perlu_kemaskini").show();
				$('#pmpd_status_description').html("{{$imuhibbah->status_description}}");
				$('#pmpd_disahkan_note').html("{{$imuhibbah->disahkan_note}}");
			}

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm22.senarai_permohonan_muhibbah_ppd') }}";
			});

	});

	/* click btn next */
		//my custom script
		var permohonan_imuhibbah_1_config = {
			routes: {
				permohonan_imuhibbah_1_url: "{{ route('rt-sm22.post_permohonan_imuhibbah_1') }}",
			}
		};

		$(document).on('submit', '#form_pmpd3', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data   = $("#form_pmpd, #form_pmpd2, #form_pmpd3").serialize();
			var action = $('#post_permohonan_imuhibbah_1').val();
			var btn_text;
			if (action == 'edit') {
				url = permohonan_imuhibbah_1_config.routes.permohonan_imuhibbah_1_url;
				type = "POST";
				btn_text = 'Hantar Permohonan i-Ramal&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=pmpd_state_id]').removeClass("is-invalid");
				$('[name=pmpd_daerah_id]').removeClass("is-invalid");
				$('[name=pmpd_krt_profile_id]').removeClass("is-invalid");
				$('[name=pmpd2_imuhibbah_tajuk]').removeClass("is-invalid");
				$('[name=pmpd2_state_id]').removeClass("is-invalid");
				$('[name=pmpd2_bandar_id]').removeClass("is-invalid");
				$('[name=pmpd2_imuhibbah_lokasi]').removeClass("is-invalid");
				$('[name=pmpd2_parlimen_id]').removeClass("is-invalid");
				$('[name=pmpd2_pbt_id]').removeClass("is-invalid");
				$('[name=pmpd2_daerah_id]').removeClass("is-invalid");
				$('[name=pmpd2_imuhibbah_kawasan]').removeClass("is-invalid");
				$('[name=pmpd2_imuhibbah_poskod]').removeClass("is-invalid");
				$('[name=pmpd2_dun_id]').removeClass("is-invalid");
				$('[name=pmpd2_imuhibbah_tarikh_laporan]').removeClass("is-invalid");
				$('[name=pmpd2_imuhibbah_tarikh_j_berlaku]').removeClass("is-invalid");
				$('[name=pmpd2_imuhibbah_laporan]').removeClass("is-invalid");
				$('[name=pmpd2_imuhibbah_sumber_maklumat]').removeClass("is-invalid");
				$('[name=pmpd2_imuhibbah_pelapor_nama]').removeClass("is-invalid");
				$('[name=pmpd2_imuhibbah_pelapor_no]').removeClass("is-invalid");
				$('[name=pmpd2_imuhibbah_pelapor_jawatan]').removeClass("is-invalid");
				$('[name=pmpd2_imuhibbah_pelapor_alamat]').removeClass("is-invalid");

				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'pmpd_state_id') {
							$('[name=pmpd_state_id]').addClass("is-invalid");
							$('.error_pmpd_state_id').html(error);
						}

						if(index == 'pmpd_daerah_id') {
							$('[name=pmpd_daerah_id]').addClass("is-invalid");
							$('.error_pmpd_daerah_id').html(error);
						}

						if(index == 'pmpd_krt_profile_id') {
							$('[name=pmpd_krt_profile_id]').addClass("is-invalid");
							$('.error_pmpd_krt_profile_id').html(error);
						}

						if(index == 'pmpd2_imuhibbah_tajuk') {
							$('[name=pmpd2_imuhibbah_tajuk]').addClass("is-invalid");
							$('.error_pmpd2_imuhibbah_tajuk').html(error);
						}

						if(index == 'pmpd2_state_id') {
							$('[name=pmpd2_state_id]').addClass("is-invalid");
							$('.error_pmpd2_state_id').html(error);
						}

						if(index == 'pmpd2_bandar_id') {
							$('[name=pmpd2_bandar_id]').addClass("is-invalid");
							$('.error_pmpd2_bandar_id').html(error);
						}

						if(index == 'pmpd2_imuhibbah_lokasi') {
							$('[name=pmpd2_imuhibbah_lokasi]').addClass("is-invalid");
							$('.error_pmpd2_imuhibbah_lokasi').html(error);
						}

						if(index == 'pmpd2_parlimen_id') {
							$('[name=pmpd2_parlimen_id]').addClass("is-invalid");
							$('.error_pmpd2_parlimen_id').html(error);
						}

						if(index == 'pmpd2_pbt_id') {
							$('[name=pmpd2_pbt_id]').addClass("is-invalid");
							$('.error_pmpd2_pbt_id').html(error);
						}

						if(index == 'pmpd2_daerah_id') {
							$('[name=pmpd2_daerah_id]').addClass("is-invalid");
							$('.error_pmpd2_daerah_id').html(error);
						}

						if(index == 'pmpd2_imuhibbah_kawasan') {
							$('[name=pmpd2_imuhibbah_kawasan]').addClass("is-invalid");
							$('.error_pmpd2_imuhibbah_kawasan').html(error);
						}

						if(index == 'pmpd2_imuhibbah_poskod') {
							$('[name=pmpd2_imuhibbah_poskod]').addClass("is-invalid");
							$('.error_pmpd2_imuhibbah_poskod').html(error);
						}

						if(index == 'pi2_ikes_poskod') {
							$('[name=pi2_ikes_poskod]').addClass("is-invalid");
							$('.error_pi2_ikes_poskod').html(error);
						}

						if(index == 'pmpd2_dun_id') {
							$('[name=pmpd2_dun_id]').addClass("is-invalid");
							$('.error_pmpd2_dun_id').html(error);
						}

						if(index == 'pmpd2_imuhibbah_tarikh_laporan') {
							$('[name=pmpd2_imuhibbah_tarikh_laporan]').addClass("is-invalid");
							$('.error_pmpd2_imuhibbah_tarikh_laporan').html(error);
						}

						if(index == 'pmpd2_imuhibbah_tarikh_j_berlaku') {
							$('[name=pmpd2_imuhibbah_tarikh_j_berlaku]').addClass("is-invalid");
							$('.error_pmpd2_imuhibbah_tarikh_j_berlaku').html(error);
						}

						if(index == 'pmpd2_imuhibbah_laporan') {
							$('[name=pmpd2_imuhibbah_laporan]').addClass("is-invalid");
							$('.error_pmpd2_imuhibbah_laporan').html(error);
						}

						if(index == 'pmpd2_imuhibbah_sumber_maklumat') {
							$('[name=pmpd2_imuhibbah_sumber_maklumat]').addClass("is-invalid");
							$('.error_pmpd2_imuhibbah_sumber_maklumat').html(error);
						}

						if(index == 'pmpd2_imuhibbah_pelapor_nama') {
							$('[name=pmpd2_imuhibbah_pelapor_nama]').addClass("is-invalid");
							$('.error_pmpd2_imuhibbah_pelapor_nama').html(error);
						}

						if(index == 'pmpd2_imuhibbah_pelapor_no') {
							$('[name=pmpd2_imuhibbah_pelapor_no]').addClass("is-invalid");
							$('.error_pmpd2_imuhibbah_pelapor_no').html(error);
						}

						if(index == 'pmpd2_imuhibbah_pelapor_jawatan') {
							$('[name=pmpd2_imuhibbah_pelapor_jawatan]').addClass("is-invalid");
							$('.error_pmpd2_imuhibbah_pelapor_jawatan').html(error);
						}

						if(index == 'pmpd2_imuhibbah_pelapor_alamat') {
							$('[name=pmpd2_imuhibbah_pelapor_alamat]').addClass("is-invalid");
							$('.error_pmpd2_imuhibbah_pelapor_alamat').html(error);
						}
					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm22.senarai_permohonan_muhibbah_ppd')}}";
				}
			});
		});

	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop