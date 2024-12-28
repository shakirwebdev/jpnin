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

		//my custom script
            var mohon_penlanjutan_mkp_config = {
				routes: {
					mohon_penlanjutan_mkp_url: "/rt/sm23/permohonan-pelanjutan-mkp",
                }
			};

            url_senarai_kursus_mkp 	= "{{ route('rt-sm23.get_senarai_kursus_mkp_table','') }}"+"/"+"{{$mkp->id}}";
            url_delete_kursus_mkp 	= "{{ route('rt-sm23.delete_kursus_mkp','') }}";

        /* Maklumat Status Kelayakan */
            $('#ppm_no_rujukan_mkp').html("{{$mkp->no_rujukan_mkp}}");
            $('#ppm_status_description').html("{{$mkp->status_kelayakan}}");
            $('#ppm_no_rujukan_mkp_1').html("{{$mkp->no_rujukan_mkp}}");
			$('#ppm_no_rujukan_mkp_2').html("{{$mkp->no_rujukan_mkp}}");
            $('#ppm_status_description_1').html("{{$mkp->status_description}}");

            if("{{$mkp->status_kelayakan}}" == 'Tidak Layak'){
				$('#note_tidak_layak').show();
                $('#note_layak').hide();
			}else{
                $('#note_tidak_layak').hide();
                $('#note_layak').show();
            }
			
			
        /* Lock and unlock form */
			if("{{$mkp->status_kelayakan}}" == 'Layak' || "{{$mkp->status}}" !== '15' ){
				$('#ppm_hasRT').attr('disabled', false);
				$('#ppm_state_id').attr('disabled', false);
				$('#ppm_daerah_id').attr('disabled', false);
                $('#ppm_krt_profile_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_nama').attr('disabled', false);
                $('#ppm1_mkp_pemohon_tarikh_lahir').attr('disabled', false);
                $('#ppm1_mkp_pemohon_daerah_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_dun_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_mukim_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_kaum_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_alamat').attr('disabled', false);
                $('#ppm1_mkp_pemohon_no_phone').attr('disabled', false);
                $('#ppm1_mkp_pemohon_kategori_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_akademik').attr('disabled', false);
                $('#ppm1_mkp_tarikh_dilantik').attr('disabled', false);
                $('#ppm1_mkp_pemohon_ic').attr('disabled', false);
                $('#ppm1_mkp_pemohon_state_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_parlimen_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_pbt_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_jantina_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_email').attr('disabled', false);
                $('#ppm1_mkp_pemohon_alamat_p').attr('disabled', false);
                $('#ppm1_mkp_pemohon_no_phone_p').attr('disabled', false);
                $('#ppm1_mkp_pemohon_tahap_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_khusus').attr('disabled', false);
                $('#ppm2_kursus_nama').attr('disabled', false);
                $('#ppm2_mkp_kategori_kursus_id').attr('disabled', false);
                $('#ppm2_mkp_peringkat_kursus_id').attr('disabled', false);
                $('#ppm2_kursus_penganjur').attr('disabled', false);
                $('#ppm2_file_dokument').attr('disabled', false);
                $('#btn_submit_kursus').show();
                $('#btn_submit').show();
            }else{
				$('#ppm_hasRT').attr('disabled', true);
                $('#ppm_state_id').attr('disabled', true);
				$('#ppm_daerah_id').attr('disabled', true);
                $('#ppm_krt_profile_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_nama').attr('disabled', true);
                $('#ppm1_mkp_pemohon_tarikh_lahir').attr('disabled', true);
                $('#ppm1_mkp_pemohon_daerah_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_dun_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_mukim_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_kaum_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_alamat').attr('disabled', true);
                $('#ppm1_mkp_pemohon_no_phone').attr('disabled', true);
                $('#ppm1_mkp_pemohon_kategori_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_akademik').attr('disabled', true);
                $('#ppm1_mkp_tarikh_dilantik').attr('disabled', true);
                $('#ppm1_mkp_pemohon_ic').attr('disabled', true);
                $('#ppm1_mkp_pemohon_state_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_parlimen_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_pbt_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_jantina_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_email').attr('disabled', true);
                $('#ppm1_mkp_pemohon_alamat_p').attr('disabled', true);
                $('#ppm1_mkp_pemohon_no_phone_p').attr('disabled', true);
                $('#ppm1_mkp_pemohon_tahap_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_khusus').attr('disabled', true);
                $('#ppm2_kursus_nama').attr('disabled', true);
                $('#ppm2_mkp_kategori_kursus_id').attr('disabled', true);
                $('#ppm2_mkp_peringkat_kursus_id').attr('disabled', true);
                $('#ppm2_kursus_penganjur').attr('disabled', true);
                $('#ppm2_file_dokument').attr('disabled', true);
                $('#btn_submit_kursus').hide();
                $('#btn_submit').hide();
			}
			if("{{$mkp->status_pelanjutan}}" == '3' || "{{$mkp->status_pelanjutan}}" == '4' || "{{$mkp->status_pelanjutan}}" == '6' || "{{$mkp->status_pelanjutan}}" == '8' 
				|| "{{$mkp->status_pelanjutan}}" == '10' || "{{$mkp->status_pelanjutan}}" == '12'){
				$('#ppm_status_kelayakan').hide();
				$('#ppm_status_permohonan').show();
				$('#note_kemaskini').hide();
				$('#note_dihantar').show();
                $('#ppm_hasRT').attr('disabled', true);
                $('#ppm_state_id').attr('disabled', true);
				$('#ppm_daerah_id').attr('disabled', true);
                $('#ppm_krt_profile_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_nama').attr('disabled', true);
                $('#ppm1_mkp_pemohon_tarikh_lahir').attr('disabled', true);
                $('#ppm1_mkp_pemohon_daerah_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_dun_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_mukim_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_kaum_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_alamat').attr('disabled', true);
                $('#ppm1_mkp_pemohon_no_phone').attr('disabled', true);
                $('#ppm1_mkp_pemohon_kategori_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_akademik').attr('disabled', true);
                $('#ppm1_mkp_tarikh_dilantik').attr('disabled', true);
                $('#ppm1_mkp_pemohon_ic').attr('disabled', true);
                $('#ppm1_mkp_pemohon_state_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_parlimen_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_pbt_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_jantina_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_email').attr('disabled', true);
                $('#ppm1_mkp_pemohon_alamat_p').attr('disabled', true);
                $('#ppm1_mkp_pemohon_no_phone_p').attr('disabled', true);
                $('#ppm1_mkp_pemohon_tahap_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_khusus').attr('disabled', true);
                $('#ppm2_kursus_nama').attr('disabled', true);
                $('#ppm2_mkp_kategori_kursus_id').attr('disabled', true);
                $('#ppm2_mkp_peringkat_kursus_id').attr('disabled', true);
                $('#ppm2_kursus_penganjur').attr('disabled', true);
                $('#ppm2_file_dokument').attr('disabled', true);
                $('#btn_submit_kursus').hide();
                $('#btn_submit').hide();
			}else if ("{{$mkp->status_pelanjutan}}" == '1' || "{{$mkp->status_pelanjutan}}" == '2' || "{{$mkp->status_pelanjutan}}" == '5' || "{{$mkp->status_pelanjutan}}" == '7' 
				|| "{{$mkp->status_pelanjutan}}" == '9' || "{{$mkp->status_pelanjutan}}" == '11' || "{{$mkp->status_pelanjutan}}" == '13' || "{{$mkp->status_pelanjutan}}" == '14'){
				$('#ppm_status_kelayakan').hide();
				$('#ppm_status_permohonan').show();
				$('#alert_status_permohonan').removeClass('alert-primary');
				$('#alert_status_permohonan').addClass('alert-warning');
				$('#note_kemaskini').show();
                $('#ppm_hasRT').attr('disabled', false);
				$('#ppm_state_id').attr('disabled', false);
				$('#ppm_daerah_id').attr('disabled', false);
                $('#ppm_krt_profile_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_nama').attr('disabled', false);
                $('#ppm1_mkp_pemohon_tarikh_lahir').attr('disabled', false);
                $('#ppm1_mkp_pemohon_daerah_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_dun_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_mukim_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_kaum_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_alamat').attr('disabled', false);
                $('#ppm1_mkp_pemohon_no_phone').attr('disabled', false);
                $('#ppm1_mkp_pemohon_kategori_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_akademik').attr('disabled', false);
                $('#ppm1_mkp_tarikh_dilantik').attr('disabled', false);
                $('#ppm1_mkp_pemohon_ic').attr('disabled', false);
                $('#ppm1_mkp_pemohon_state_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_parlimen_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_pbt_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_jantina_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_email').attr('disabled', false);
                $('#ppm1_mkp_pemohon_alamat_p').attr('disabled', false);
                $('#ppm1_mkp_pemohon_no_phone_p').attr('disabled', false);
                $('#ppm1_mkp_pemohon_tahap_id').attr('disabled', false);
                $('#ppm1_mkp_pemohon_khusus').attr('disabled', false);
                $('#ppm2_kursus_nama').attr('disabled', false);
                $('#ppm2_mkp_kategori_kursus_id').attr('disabled', false);
                $('#ppm2_mkp_peringkat_kursus_id').attr('disabled', false);
                $('#ppm2_kursus_penganjur').attr('disabled', false);
                $('#ppm2_file_dokument').attr('disabled', false);
                $('#btn_submit_kursus').show();
                $('#btn_submit').show();
            }

			if("{{$mkp->status_keaktifan}}" !== '1'){
				$('#ppm_status_kelayakan').hide();
				$('#ppm_status_keaktifan').show();
				$('#ppm_hasRT').attr('disabled', true);
                $('#ppm_state_id').attr('disabled', true);
				$('#ppm_daerah_id').attr('disabled', true);
                $('#ppm_krt_profile_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_nama').attr('disabled', true);
                $('#ppm1_mkp_pemohon_tarikh_lahir').attr('disabled', true);
                $('#ppm1_mkp_pemohon_daerah_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_dun_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_mukim_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_kaum_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_alamat').attr('disabled', true);
                $('#ppm1_mkp_pemohon_no_phone').attr('disabled', true);
                $('#ppm1_mkp_pemohon_kategori_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_akademik').attr('disabled', true);
                $('#ppm1_mkp_tarikh_dilantik').attr('disabled', true);
                $('#ppm1_mkp_pemohon_ic').attr('disabled', true);
                $('#ppm1_mkp_pemohon_state_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_parlimen_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_pbt_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_jantina_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_email').attr('disabled', true);
                $('#ppm1_mkp_pemohon_alamat_p').attr('disabled', true);
                $('#ppm1_mkp_pemohon_no_phone_p').attr('disabled', true);
                $('#ppm1_mkp_pemohon_tahap_id').attr('disabled', true);
                $('#ppm1_mkp_pemohon_khusus').attr('disabled', true);
                $('#ppm2_kursus_nama').attr('disabled', true);
                $('#ppm2_mkp_kategori_kursus_id').attr('disabled', true);
                $('#ppm2_mkp_peringkat_kursus_id').attr('disabled', true);
                $('#ppm2_kursus_penganjur').attr('disabled', true);
                $('#ppm2_file_dokument').attr('disabled', true);
                $('#btn_submit_kursus').hide();
                $('#btn_submit').hide();
            }

		/* Maklumat Note Kemaskini */
			if("{{$mkp->status_pelanjutan}}" == '5'){
				$('#ppm_disokong_note').html("{{$mkp->disokong_note}}");
			}

			if("{{$mkp->status_pelanjutan}}" == '7'){
				$('#ppm_disokong_p_note').html("{{$mkp->disokong_p_note}}");
			}

			if("{{$mkp->status_pelanjutan}}" == '9'){
				$('#ppm_disahkan_note').html("{{$mkp->disahkan_note}}");
			}

			if("{{$mkp->status_pelanjutan}}" == '11'){
				$('#ppm_disemak_note').html("{{$mkp->disemak_note}}");
			}

			if("{{$mkp->status_pelanjutan}}" == '13'){
				$('#ppm_dilulus_note').html("{{$mkp->dilulus_note}}");
			}

			if("{{$mkp->status_pelanjutan}}" == '14'){
				$('#ppm_dilantik_note').html("{{$mkp->dilantik_note}}");
			}
            

		/* Maklumat Kes Dalam Krt */
            $('#ppm_hasRT').on('click', function(){           
				if($(this).is(':checked')){
					$('#ppm_hasRT').val(1);
					$('#ppm_krt_profile_id').attr('disabled', false);
					
				} else {
					$('#ppm_state_id').attr('disabled', true);
					$('#ppm_daerah_id').attr('disabled', true);
					$('#ppm_krt_profile_id').attr('disabled', true);
				}
			});

            $('#ppm_state_id').val("{{$mkp->mkp_pemohon_state_id}}");
            $('#ppm_daerah_id').val("{{$mkp->mkp_pemohon_daerah_id}}");

            if("{{$mkp->hasRT}}" == 1){
				$('#ppm_hasRT').attr("checked", "checked");
				$('#ppm_hasRT').val(1);
			}

            if("{{$mkp->krt_profile_id}}" !== ''){
				var value = "{{$mkp->mkp_pemohon_daerah_id}}";
				$.ajax({
					type: "GET",
					url: mohon_penlanjutan_mkp_config.routes.mohon_penlanjutan_mkp_url,
					data: {type: 'get_krt', value: value},
					success: function (data) {
						
						$('#ppm_krt_profile_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{	
                            $('#ppm_krt_profile_id')
							.append($('<option>')
							.text(obj.krt_nama)
							.attr('value', obj.id));
							$('#ppm_krt_profile_id').val("{{$mkp->krt_profile_id}}");
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}else{
				var value = "{{$mkp->mkp_pemohon_daerah_id}}";
				$.ajax({
					type: "GET",
					url: mohon_penlanjutan_mkp_config.routes.mohon_penlanjutan_mkp_url,
					data: {type: 'get_krt', value: value},
					success: function (data) {
						$('#ppm_krt_profile_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#ppm_krt_profile_id')
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
			
        
		/* Maklumat MKP */
            $('#ppm1_mkp_gambar').attr('src', "{{ asset('storage/mkp_profile') }}"+"/"+ "{{$mkp->mkp_file_avatar}}");
			$('#ppm1_mkp_pemohon_nama').val("{{$mkp->mkp_pemohon_nama}}");
            $('#ppm1_mkp_pemohon_tarikh_lahir').val("{{$mkp->mkp_pemohon_tarikh_lahir}}");
            $('#ppm1_mkp_pemohon_daerah_id').val("{{$mkp->mkp_pemohon_daerah_id}}");

            if("{{$mkp->mkp_pemohon_dun_id}}" !== ''){
				var value = "{{$mkp->mkp_pemohon_state_id}}";
				$.ajax({
					type: "GET",
					url: mohon_penlanjutan_mkp_config.routes.mohon_penlanjutan_mkp_url,
					data: {type: 'get_dun', value: value},
					success: function (data) {
						$('#ppm1_mkp_pemohon_dun_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#ppm1_mkp_pemohon_dun_id')
							.append($('<option>')
							.text(obj.dun_description)
							.attr('value', obj.dun_id));
							$('#ppm1_mkp_pemohon_dun_id').val("{{$mkp->mkp_pemohon_dun_id}}");
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}else{
				var value = "{{$mkp->mkp_pemohon_state_id}}";
				$.ajax({
					type: "GET",
					url: mohon_penlanjutan_mkp_config.routes.mohon_penlanjutan_mkp_url,
					data: {type: 'get_dun', value: value},
					success: function (data) {
						$('#ppm1_mkp_pemohon_dun_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#ppm1_mkp_pemohon_dun_id')
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

            $('#ppm1_mkp_pemohon_mukim_id').val("{{$mkp->mkp_pemohon_mukim_id}}");
            $('#ppm1_mkp_pemohon_kaum_id').val("{{$mkp->mkp_pemohon_kaum_id}}");
            $('#ppm1_mkp_pemohon_alamat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
            $('#ppm1_mkp_pemohon_alamat').val("{{$mkp->mkp_pemohon_alamat}}");
            $('#ppm1_mkp_pemohon_no_phone').val("{{$mkp->mkp_pemohon_no_phone}}");
            $('#ppm1_mkp_pemohon_kategori_id').val("{{$mkp->mkp_pemohon_kategori_id}}");
            $('#ppm1_mkp_pemohon_akademik').val("{{$mkp->mkp_pemohon_akademik}}");
            $('#ppm1_mkp_tarikh_dilantik').val("{{$mkp->mkp_tarikh_dilantik}}");
            $('#ppm1_mkp_pemohon_ic').val("{{$mkp->mkp_pemohon_ic}}");
            $('#ppm1_mkp_pemohon_state_id').val("{{$mkp->mkp_pemohon_state_id}}");

            if("{{$mkp->mkp_pemohon_parlimen_id}}" !== ''){
				var value = "{{$mkp->mkp_pemohon_state_id}}";
				$.ajax({
					type: "GET",
					url: mohon_penlanjutan_mkp_config.routes.mohon_penlanjutan_mkp_url,
					data: {type: 'get_parlimen', value: value},
					success: function (data) {
						
						$('#ppm1_mkp_pemohon_parlimen_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{	
							$('#ppm1_mkp_pemohon_parlimen_id')
							.append($('<option>')
							.text(obj.parlimen_description)
							.attr('value', obj.parlimen_id));
							$('#ppm1_mkp_pemohon_parlimen_id').val("{{$mkp->mkp_pemohon_parlimen_id}}");
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}else{
				var value = "{{$mkp->mkp_pemohon_state_id}}";
				$.ajax({
					type: "GET",
					url: mohon_penlanjutan_mkp_config.routes.mohon_penlanjutan_mkp_url,
					data: {type: 'get_parlimen', value: value},
					success: function (data) {
						$('#ppm1_mkp_pemohon_parlimen_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#ppm1_mkp_pemohon_parlimen_id')
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

            if("{{$mkp->mkp_pemohon_pbt_id}}" !== ''){
				var value = "{{$mkp->mkp_pemohon_state_id}}";
				$.ajax({
						type: "GET",
						url: mohon_penlanjutan_mkp_config.routes.mohon_penlanjutan_mkp_url,
						data: {type: 'get_pbt', value: value},
						success: function (data) {
							$('#ppm1_mkp_pemohon_pbt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#ppm1_mkp_pemohon_pbt_id')
								.append($('<option>')
								.text(obj.pbt_description)
								.attr('value', obj.pbt_id));
								$('#ppm1_mkp_pemohon_pbt_id').val("{{$mkp->mkp_pemohon_pbt_id}}");
							});
						},
						error: function (data) {
							console.log('Error:', data);
						}
					}); 
			}else{
				var value = "{{$mkp->mkp_pemohon_state_id}}";
				$.ajax({
					type: "GET",
					url: mohon_penlanjutan_mkp_config.routes.mohon_penlanjutan_mkp_url,
					data: {type: 'get_pbt', value: value},
					success: function (data) {
						$('#ppm1_mkp_pemohon_pbt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#ppm1_mkp_pemohon_pbt_id')
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

            $('#ppm1_mkp_pemohon_jantina_id').val("{{$mkp->mkp_pemohon_jantina_id}}");
            $('#ppm1_mkp_pemohon_email').val("{{$mkp->mkp_pemohon_email}}");
            $('#ppm1_mkp_pemohon_alamat_p').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
            $('#ppm1_mkp_pemohon_alamat_p').val("{{$mkp->mkp_pemohon_alamat_p}}");
			$('#ppm1_mkp_pemohon_no_phone_p').val("{{$mkp->mkp_pemohon_no_phone_p}}");
            $('#ppm1_mkp_pemohon_tahap_id').val("{{$mkp->mkp_pemohon_tahap_id}}");
			$('#ppm1_mkp_pemohon_khusus').val("{{$mkp->mkp_pemohon_khusus}}");
			

		/* Maklumat Kursus Yang Dihadiri */
            $('#ppm2_spk_imediator_id').val("{{$mkp->id}}");
            var senarai_kursus_mkp_table = $('#senarai_kursus_mkp_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_senarai_kursus_mkp,
				"language": {
					"paginate": {
						"previous": "Sebelumnya",
						"next": "Seterusnya",
						searchPanes: {
							emptyPanes: 'There are no panes to display. :/'
						}
					},
					"sSearch": "Carian",
					"sLengthMenu": "Paparan _MENU_ rekod",
					"lengthMenu": "Paparan _MENU_ rekod setiap laman",
					"zeroRecords": "Tiada rekod ditemui",
					"info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
					"infoEmpty": "",
					"infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
				},
				dom: 'rtip',
				"bFilter": true,
				"bSort": false,
				responsive: true,
				"aoColumnDefs":[{          
					"aTargets": [ 0 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function (data, type, full, meta)  {
						return  meta.row+1;
					}
				},{          
					"aTargets": [ 1 ], 
					"width": "16%", 
					"mRender": function ( value, type, full )  {
						return full.kursus_nama;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "16%",
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.kursus_description;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "16%",
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.peringkat_description;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "16%",
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						return full.kursus_penganjur;
					}
				},{          
					"aTargets": [ 5 ], 
					"width": "16%",
					"mRender": function ( value, type, full )  {
						return full.file_dokument;
					}
				},{          
					"aTargets": [ 6 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
                        if (full.status_pelanjutan == null || full.status_pelanjutan == 2 || full.status_pelanjutan == 5 || full.status_pelanjutan == 7 || full.status_pelanjutan == 9 || full.status_pelanjutan == 11 || full.status_pelanjutan == 13 || full.status_pelanjutan == 14) {
                            button_a = '<button type="button" class="btn btn-icon" title="Download Dokumen Kursus" id="download_dokument" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-download"></i></button>';
                            button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_maklumat_kursus" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
                            return button_a + '|' + button_b;
                        } else {
                            button_a = '<button type="button" class="btn btn-icon" title="Download Dokumen Kursus" id="download_dokument" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-download"></i></button>';
                            return button_a;
                        }
                        
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

            $('#ppm3_spk_imediator_id').val("{{$mkp->id}}");
	
    });

    /* click add kursus */
        $(document).on('submit', '#form_ppm2', function(event){
			var info = $('.error_alert');
			event.preventDefault();
			var form_data = new FormData();
			form_data.append("ppm2_kursus_nama", $("#ppm2_kursus_nama").val() );
			form_data.append("ppm2_mkp_kategori_kursus_id", $("#ppm2_mkp_kategori_kursus_id").val() );
            form_data.append("ppm2_mkp_peringkat_kursus_id", $("#ppm2_mkp_peringkat_kursus_id").val() );
            form_data.append("ppm2_kursus_penganjur", $("#ppm2_kursus_penganjur").val() );
			form_data.append("ppm2_file_dokument",  $("#ppm2_file_dokument")[0].files[0]);
			form_data.append("ppm2_spk_imediator_id", $("#ppm2_spk_imediator_id").val() );
			form_data.append("post_imediator_kursus", "add" );
			console.log(form_data);
			$('#btn_submit_kursus').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit_kursus').prop('disabled', true);
			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm23.post_imediator_kursus') }}";
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
					$('#btn_submit_kursus').html(btn_text);                
					$('#btn_submit_kursus').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Maklumat Kursus ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_ppm2').trigger("reset");
					$('#btn_submit_kursus').html(btn_text);
					$('#btn_submit_kursus').prop('disabled', false);
					$('#senarai_kursus_mkp_table').DataTable().ajax.reload();
				}
			});
		});
	
	/* click delete kursus */
        $('body').on('click', '#delete_maklumat_kursus', function () {
			var delete_id = $(this).data("id");
			swal({
				title: "Anda pasti?",
				text: "Anda akan memadam rekod ini dari pangkalan data!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#dc3545",
				confirmButtonText: "Ya, sila padam!",
				cancelButtonText: "Tidak",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function (isConfirm) {
				if (isConfirm) {
					$.ajax({
						type: "GET",
						url: url_delete_kursus_mkp +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_kursus_mkp_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Maklumat Kursus Yang Dihadiri telah dipadam dari pangkalan data", "success");
						},
						error: function (data) {
							console.log('Error:', data);
						}
					});                    
				} else {
					swal("Tidak", "Proses pemadaman tidak berlaku", "error");
				}
			});
		});

    /* click download dokumen kursus */
        var download_dokument_config = {
			routes: {
				download_dokumen_kursus_url: "{{ route('rt-sm23.get_download_dokument_kursus','') }}",
			}
		};

        $('body').on('click', '#download_dokument', function () {
			var download_id = $(this).data("id");
			$.get(download_dokument_config.routes.download_dokumen_kursus_url + '/' + download_id, function (data) {
				let link = document.createElement("a");
				link.download = data.file_dokument;
				link.href = "{{ asset('storage/mkp_dokument_kursus') }}"+"/"+ data.file_dokument ;
				link.click();
			});
		});

    /* click btn submit */
		//my custom script
		var permohonan_pelanjutan_mkp_config = {
			routes: {
				permohonan_pelanjutan_mkp_url: "{{ route('rt-sm23.post_mohon_pelanjutan_mkp') }}",
			}
		};

		$(document).on('submit', '#form_ppm3', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data   = $("#form_ppm, #form_ppm1, #form_ppm3").serialize();
			var action = $('#post_mohon_pelanjutan_mkp').val();
			var btn_text;
			if (action == 'edit') {
				url = permohonan_pelanjutan_mkp_config.routes.permohonan_pelanjutan_mkp_url;
				type = "POST";
				btn_text = 'Hantar Permohonan Pelanjutan MKP&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=ppm_krt_profile_id]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_nama]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_tarikh_lahir]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_daerah_id]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_dun_id]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_mukim_id]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_kaum_id]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_alamat]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_no_phone]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_kategori_id]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_akademik]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_ic]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_state_id]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_parlimen_id]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_pbt_id]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_jantina_id]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_email]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_alamat_p]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_no_phone_p]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_tahap_id]').removeClass("is-invalid");
				$('[name=ppm1_mkp_pemohon_khusus]').removeClass("is-invalid");
                $('[name=ppm1_mkp_tarikh_dilantik]').removeClass("is-invalid");

				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'ppm_krt_profile_id') {
							$('[name=ppm_krt_profile_id]').addClass("is-invalid");
							$('.error_ppm_krt_profile_id').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_nama') {
							$('[name=ppm1_mkp_pemohon_nama]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_nama').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_tarikh_lahir') {
							$('[name=ppm1_mkp_pemohon_tarikh_lahir]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_tarikh_lahir').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_daerah_id') {
							$('[name=ppm1_mkp_pemohon_daerah_id]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_daerah_id').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_dun_id') {
							$('[name=ppm1_mkp_pemohon_dun_id]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_dun_id').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_mukim_id') {
							$('[name=ppm1_mkp_pemohon_mukim_id]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_mukim_id').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_kaum_id') {
							$('[name=ppm1_mkp_pemohon_kaum_id]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_kaum_id').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_alamat') {
							$('[name=ppm1_mkp_pemohon_alamat]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_alamat').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_no_phone') {
							$('[name=ppm1_mkp_pemohon_no_phone]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_no_phone').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_kategori_id') {
							$('[name=ppm1_mkp_pemohon_kategori_id]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_kategori_id').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_akademik') {
							$('[name=ppm1_mkp_pemohon_akademik]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_akademik').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_ic') {
							$('[name=ppm1_mkp_pemohon_ic]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_ic').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_state_id') {
							$('[name=ppm1_mkp_pemohon_state_id]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_state_id').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_parlimen_id') {
							$('[name=ppm1_mkp_pemohon_parlimen_id]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_parlimen_id').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_pbt_id') {
							$('[name=ppm1_mkp_pemohon_pbt_id]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_pbt_id').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_jantina_id') {
							$('[name=ppm1_mkp_pemohon_jantina_id]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_jantina_id').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_email') {
							$('[name=ppm1_mkp_pemohon_email]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_email').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_alamat_p') {
							$('[name=ppm1_mkp_pemohon_alamat_p]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_alamat_p').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_no_phone_p') {
							$('[name=ppm1_mkp_pemohon_no_phone_p]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_no_phone_p').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_tahap_id') {
							$('[name=ppm1_mkp_pemohon_tahap_id]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_tahap_id').html(error);
						}

						if(index == 'ppm1_mkp_pemohon_khusus') {
							$('[name=ppm1_mkp_pemohon_khusus]').addClass("is-invalid");
							$('.error_ppm1_mkp_pemohon_khusus').html(error);
						}

                        if(index == 'ppm1_mkp_tarikh_dilantik') {
							$('[name=ppm1_mkp_tarikh_dilantik]').addClass("is-invalid");
							$('.error_ppm1_mkp_tarikh_dilantik').html(error);
						}
					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm23.permohonan_pelanjutan_mkp')}}";
				}
			});
		});
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop