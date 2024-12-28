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
			var senarai_permohonan_imuhibbah_ppn_config = {
				routes: {
					senarai_permohonan_imuhibbah_ppn_url: "/rt/sm22/permohonan-muhibbah-ppn/{id}"
				}
			};

		/* Maklumat Kes Dalam Krt */
			$('#pmpn_hasRT').on('click', function(){           
				if($(this).is(':checked')){
					$('#pmpn_hasRT').val(1);
					$('#pmpn_state_id').attr('disabled', false);
					
				} else {
					$('#pmpn_state_id').attr('disabled', true);
					$('#pmpn_daerah_id').attr('disabled', true);
					$('#pmpn_krt_profile_id').attr('disabled', true);
				}
			});

			$("#pmpn_state_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pmpn_daerah_id').find('option').remove();
				$('#pmpn_daerah_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_imuhibbah_ppn_config.routes.senarai_permohonan_imuhibbah_ppn_url,
						data: {type: 'get_daerah', value: value},
						success: function (data) {
							$('#pmpn_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pmpn_daerah_id')
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

			$("#pmpn_daerah_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pmpn_krt_profile_id').find('option').remove();
				$('#pmpn_krt_profile_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_imuhibbah_ppn_config.routes.senarai_permohonan_imuhibbah_ppn_url,
						data: {type: 'get_krt', value: value},
						success: function (data) {
							$('#pmpn_krt_profile_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pmpn_krt_profile_id')
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
				$('#pmpn_hasRT').attr("checked", "checked");
				$('#pmpn_hasRT').val(1);
				$('#pmpn_state_id').attr('disabled', false);
				$('#pmpn_daerah_id').attr('disabled', false);
				$('#pmpn_krt_profile_id').attr('disabled', false);
			}

			$('#pmpn_state_id').val("{{$imuhibbah->krt_state_id}}");
			$('#pmpn_daerah_id').val("{{$imuhibbah->krt_daerah_id}}");
			$('#pmpn_krt_profile_id').val("{{$imuhibbah->krt_profile_id}}");

		/* Maklumat Pemohon */
			$('#pmpn1_nama_permohon').val("{{$imuhibbah->nama_permohon}}");
			$('#pmpn1_ic_pemohon').val("{{$imuhibbah->ic_pemohon}}");
			$('#pmpn1_phone_pemohon').val("{{$imuhibbah->phone_pemohon}}");

		/* Maklumat Kes Kejadian */
			$('#pmpn2_imuhibbah_tajuk').val("{{$imuhibbah->imuhibbah_tajuk}}");
			$('#pmpn2_state_id').val("{{$imuhibbah->state_id}}");
			if("{{$imuhibbah->bandar_id}}" !== ''){
				$('#pmpn2_bandar_id').attr('disabled', false);
			}else{
				$('#pmpn2_bandar_id').attr('disabled', true);
			}
			$('#pmpn2_bandar_id').val("{{$imuhibbah->bandar_id}}");
			$('#pmpn2_imuhibbah_lokasi').val("{{$imuhibbah->imuhibbah_lokasi}}");
			if("{{$imuhibbah->parlimen_id}}" !== ''){
				$('#pmpn2_parlimen_id').attr('disabled', false);
			}else{
				$('#pmpn2_parlimen_id').attr('disabled', true);
			}
			$('#pmpn2_parlimen_id').val("{{$imuhibbah->parlimen_id}}");
			if("{{$imuhibbah->pbt_id}}" !== ''){
				$('#pmpn2_pbt_id').attr('disabled', false);
			}else{
				$('#pmpn2_pbt_id').attr('disabled', true);
			}
			$('#pmpn2_pbt_id').val("{{$imuhibbah->pbt_id}}");

			if("{{$imuhibbah->daerah_id}}" !== ''){
				$('#pmpn2_daerah_id').attr('disabled', false);
			}else{
				$('#pmpn2_daerah_id').attr('disabled', true);
			}
			$('#pmpn2_daerah_id').val("{{$imuhibbah->daerah_id}}");

			$('#pmpn2_imuhibbah_kawasan').val("{{$imuhibbah->imuhibbah_kawasan}}");
			$('#pmpn2_imuhibbah_poskod').val("{{$imuhibbah->imuhibbah_poskod}}");

			if("{{$imuhibbah->dun_id}}" !== ''){
				$('#pmpn2_dun_id').attr('disabled', false);
			}else{
				$('#pmpn2_dun_id').attr('disabled', true);
			}
			$('#pmpn2_dun_id').val("{{$imuhibbah->dun_id}}");

			$('#pmpn2_imuhibbah_tarikh_laporan').val("{{$imuhibbah->imuhibbah_tarikh_laporan}}");
			$('#pmpn2_imuhibbah_tarikh_j_berlaku').val("{{$imuhibbah->imuhibbah_tarikh_j_berlaku}}");
			$('#pmpn2_imuhibbah_laporan').html("{{$imuhibbah->imuhibbah_laporan}}");
			$('#pmpn2_imuhibbah_sumber_maklumat').html("{{$imuhibbah->imuhibbah_sumber_maklumat}}");
			$('#pmpn2_imuhibbah_pelapor_nama').val("{{$imuhibbah->imuhibbah_pelapor_nama}}");
			$('#pmpn2_imuhibbah_pelapor_no').val("{{$imuhibbah->imuhibbah_pelapor_no}}");
			$('#pmpn2_imuhibbah_pelapor_jawatan').val("{{$imuhibbah->imuhibbah_pelapor_jawatan}}");
			$('#pmpn2_imuhibbah_pelapor_alamat').val("{{$imuhibbah->imuhibbah_pelapor_alamat}}");

			$('#pmpn2_imuhibbah_pelapor_alamat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

			$('#pmpn2_imuhibbah_pelapor_alamat').on("paste",function(e) {
                e.preventDefault();
            });

			$("#pmpn2_state_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pmpn2_daerah_id').find('option').remove();
				$('#pmpn2_daerah_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_imuhibbah_ppn_config.routes.senarai_permohonan_imuhibbah_ppn_url,
						data: {type: 'get_daerah', value: value},
						success: function (data) {
							$('#pmpn2_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pmpn2_daerah_id')
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

			$("#pmpn2_daerah_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pmpn2_bandar_id').find('option').remove();
				$('#pmpn2_bandar_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_imuhibbah_ppn_config.routes.senarai_permohonan_imuhibbah_ppn_url,
						data: {type: 'get_bandar', value: value},
						success: function (data) {
							$('#pmpn2_bandar_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pmpn2_bandar_id')
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

			$("#pmpn2_state_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pmpn2_parlimen_id').find('option').remove();
				$('#pmpn2_parlimen_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_imuhibbah_ppn_config.routes.senarai_permohonan_imuhibbah_ppn_url,
						data: {type: 'get_parlimen', value: value},
						success: function (data) {
							$('#pmpn2_parlimen_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pmpn2_parlimen_id')
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

			$("#pmpn2_state_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pmpn2_dun_id').find('option').remove();
				$('#pmpn2_dun_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_imuhibbah_ppn_config.routes.senarai_permohonan_imuhibbah_ppn_url,
						data: {type: 'get_dun', value: value},
						success: function (data) {
							$('#pmpn2_dun_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pmpn2_dun_id')
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

			$("#pmpn2_state_id").on( 'change', function () {
				var value = $(this).find('option:selected').val();
				var selectedIndex = $(this).find('option:selected').index();
				$('#pmpn2_pbt_id').find('option').remove();
				$('#pmpn2_pbt_id').prop("disabled", false);
				if (selectedIndex !== '0') {
					$.ajax({
						type: "GET",
						url: senarai_permohonan_imuhibbah_ppn_config.routes.senarai_permohonan_imuhibbah_ppn_url,
						data: {type: 'get_pbt', value: value},
						success: function (data) {
							$('#pmpn2_pbt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#pmpn2_pbt_id')
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

			$('#pmpn2_imuhibbah_laporan').summernote({
				height: 200
			});

			$('#pmpn2_imuhibbah_sumber_maklumat').summernote({
				height: 200
			});

			$('#pmpn2_imuhibbah_pelapor_alamat').on("paste",function(e) {
                e.preventDefault();
            });

            $('#pmpn2_imuhibbah_pelapor_alamat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

			$('#pmpn3_imuhibbah_id').val("{{$imuhibbah->id}}");

		/* Maklumat Note Kemaskini */
			$('#pmpn_status').val("{{$imuhibbah->status}}");

			if($('#pmpn_status').val() == '11'){
				$("#pmpn_perlu_kemaskini").show();
				$('#pmpn_status_description').html("{{$imuhibbah->status_description}}");
				$('#pmpn_disemak_note').html("{{$imuhibbah->disemak_note}}");
			}

			if($('#pmpn_status').val() == '12'){
				$("#pmpn_perlu_kemaskini").show();
				$('#pmpn_status_description').html("{{$imuhibbah->status_description}}");
				$('#pmpn_disahkan_note').html("{{$imuhibbah->disahkan_note}}");
			}

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm22.senarai_permohonan_muhibbah_ppn') }}";
			});

	});

	/* click btn next */
		//my custom script
		var permohonan_imuhibbah_ppn_1_config = {
			routes: {
				permohonan_imuhibbah_ppn_1_url: "{{ route('rt-sm22.post_permohonan_imuhibbah_ppn_1') }}",
			}
		};

		$(document).on('submit', '#form_pmpn3', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data   = $("#form_pmpn, #form_pmpn2, #form_pmpn3").serialize();
			var action = $('#post_permohonan_imuhibbah_ppn_1').val();
			var btn_text;
			if (action == 'edit') {
				url = permohonan_imuhibbah_ppn_1_config.routes.permohonan_imuhibbah_ppn_1_url;
				type = "POST";
				btn_text = 'Hantar Permohonan i-Ramal&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=pmpn_state_id]').removeClass("is-invalid");
				$('[name=pmpn_daerah_id]').removeClass("is-invalid");
				$('[name=pmpn_krt_profile_id]').removeClass("is-invalid");
				$('[name=pmpn2_imuhibbah_tajuk]').removeClass("is-invalid");
				$('[name=pmpn2_state_id]').removeClass("is-invalid");
				$('[name=pmpn2_bandar_id]').removeClass("is-invalid");
				$('[name=pmpn2_imuhibbah_lokasi]').removeClass("is-invalid");
				$('[name=pmpn2_parlimen_id]').removeClass("is-invalid");
				$('[name=pmpn2_pbt_id]').removeClass("is-invalid");
				$('[name=pmpn2_daerah_id]').removeClass("is-invalid");
				$('[name=pmpn2_imuhibbah_kawasan]').removeClass("is-invalid");
				$('[name=pmpn2_imuhibbah_poskod]').removeClass("is-invalid");
				$('[name=pmpn2_dun_id]').removeClass("is-invalid");
				$('[name=pmpn2_imuhibbah_tarikh_laporan]').removeClass("is-invalid");
				$('[name=pmpn2_imuhibbah_tarikh_j_berlaku]').removeClass("is-invalid");
				$('[name=pmpn2_imuhibbah_laporan]').removeClass("is-invalid");
				$('[name=pmpn2_imuhibbah_sumber_maklumat]').removeClass("is-invalid");
				$('[name=pmpn2_imuhibbah_pelapor_nama]').removeClass("is-invalid");
				$('[name=pmpn2_imuhibbah_pelapor_no]').removeClass("is-invalid");
				$('[name=pmpn2_imuhibbah_pelapor_jawatan]').removeClass("is-invalid");
				$('[name=pmpn2_imuhibbah_pelapor_alamat]').removeClass("is-invalid");

				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'pmpn_state_id') {
							$('[name=pmpn_state_id]').addClass("is-invalid");
							$('.error_pmpn_state_id').html(error);
						}

						if(index == 'pmpn_daerah_id') {
							$('[name=pmpn_daerah_id]').addClass("is-invalid");
							$('.error_pmpn_daerah_id').html(error);
						}

						if(index == 'pmpn_krt_profile_id') {
							$('[name=pmpn_krt_profile_id]').addClass("is-invalid");
							$('.error_pmpn_krt_profile_id').html(error);
						}

						if(index == 'pmpn2_imuhibbah_tajuk') {
							$('[name=pmpn2_imuhibbah_tajuk]').addClass("is-invalid");
							$('.error_pmpn2_imuhibbah_tajuk').html(error);
						}

						if(index == 'pmpn2_state_id') {
							$('[name=pmpn2_state_id]').addClass("is-invalid");
							$('.error_pmpn2_state_id').html(error);
						}

						if(index == 'pmpn2_bandar_id') {
							$('[name=pmpn2_bandar_id]').addClass("is-invalid");
							$('.error_pmpn2_bandar_id').html(error);
						}

						if(index == 'pmpn2_imuhibbah_lokasi') {
							$('[name=pmpn2_imuhibbah_lokasi]').addClass("is-invalid");
							$('.error_pmpn2_imuhibbah_lokasi').html(error);
						}

						if(index == 'pmpn2_parlimen_id') {
							$('[name=pmpn2_parlimen_id]').addClass("is-invalid");
							$('.error_pmpn2_parlimen_id').html(error);
						}

						if(index == 'pmpn2_pbt_id') {
							$('[name=pmpn2_pbt_id]').addClass("is-invalid");
							$('.error_pmpn2_pbt_id').html(error);
						}

						if(index == 'pmpn2_daerah_id') {
							$('[name=pmpn2_daerah_id]').addClass("is-invalid");
							$('.error_pmpn2_daerah_id').html(error);
						}

						if(index == 'pmpn2_imuhibbah_kawasan') {
							$('[name=pmpn2_imuhibbah_kawasan]').addClass("is-invalid");
							$('.error_pmpn2_imuhibbah_kawasan').html(error);
						}

						if(index == 'pmpn2_imuhibbah_poskod') {
							$('[name=pmpn2_imuhibbah_poskod]').addClass("is-invalid");
							$('.error_pmpn2_imuhibbah_poskod').html(error);
						}

						if(index == 'pi2_ikes_poskod') {
							$('[name=pi2_ikes_poskod]').addClass("is-invalid");
							$('.error_pi2_ikes_poskod').html(error);
						}

						if(index == 'pmpn2_dun_id') {
							$('[name=pmpn2_dun_id]').addClass("is-invalid");
							$('.error_pmpn2_dun_id').html(error);
						}

						if(index == 'pmpn2_imuhibbah_tarikh_laporan') {
							$('[name=pmpn2_imuhibbah_tarikh_laporan]').addClass("is-invalid");
							$('.error_pmpn2_imuhibbah_tarikh_laporan').html(error);
						}

						if(index == 'pmpn2_imuhibbah_tarikh_j_berlaku') {
							$('[name=pmpn2_imuhibbah_tarikh_j_berlaku]').addClass("is-invalid");
							$('.error_pmpn2_imuhibbah_tarikh_j_berlaku').html(error);
						}

						if(index == 'pmpn2_imuhibbah_laporan') {
							$('[name=pmpn2_imuhibbah_laporan]').addClass("is-invalid");
							$('.error_pmpn2_imuhibbah_laporan').html(error);
						}

						if(index == 'pmpn2_imuhibbah_sumber_maklumat') {
							$('[name=pmpn2_imuhibbah_sumber_maklumat]').addClass("is-invalid");
							$('.error_pmpn2_imuhibbah_sumber_maklumat').html(error);
						}

						if(index == 'pmpn2_imuhibbah_pelapor_nama') {
							$('[name=pmpn2_imuhibbah_pelapor_nama]').addClass("is-invalid");
							$('.error_pmpn2_imuhibbah_pelapor_nama').html(error);
						}

						if(index == 'pmpn2_imuhibbah_pelapor_no') {
							$('[name=pmpn2_imuhibbah_pelapor_no]').addClass("is-invalid");
							$('.error_pmpn2_imuhibbah_pelapor_no').html(error);
						}

						if(index == 'pmpn2_imuhibbah_pelapor_jawatan') {
							$('[name=pmpn2_imuhibbah_pelapor_jawatan]').addClass("is-invalid");
							$('.error_pmpn2_imuhibbah_pelapor_jawatan').html(error);
						}

						if(index == 'pmpn2_imuhibbah_pelapor_alamat') {
							$('[name=pmpn2_imuhibbah_pelapor_alamat]').addClass("is-invalid");
							$('.error_pmpn2_imuhibbah_pelapor_alamat').html(error);
						}
					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm22.senarai_permohonan_muhibbah_ppn')}}";
				}
			});
		});

	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop