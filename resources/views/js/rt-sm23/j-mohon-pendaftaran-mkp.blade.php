@include('js.modal.j-modal-gambar-mkp')
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
			var mohon_pendaftaran_mkp_config = {
				routes: {
					mohon_pendaftaran_mkp_url: "/rt/sm23/mohon-pendaftaran-mkp",
                }
			};

            url_senarai_kursus_mkp 	= "{{ route('rt-sm23.get_senarai_kursus_mkp_table','') }}"+"/"+"{{$mkp->id}}";
			

		/* Maklumat Kes Dalam Krt */	
            $('#mpm_hasRT').on('click', function(){           
				if($(this).is(':checked')){
					$('#mpm_hasRT').val(1);
					$('#mpm_krt_profile_id').attr('disabled', false);
					
				} else {
					$('#mpm_state_id').attr('disabled', true);
					$('#mpm_daerah_id').attr('disabled', true);
					$('#mpm_krt_profile_id').attr('disabled', true);
				}
			});

            $('#mpm_state_id').val("{{$mkp->mkp_pemohon_state_id}}");
            $('#mpm_daerah_id').val("{{$mkp->mkp_pemohon_daerah_id}}");
		
            if("{{$mkp->mkp_pemohon_daerah_id}}" !== ''){
				var value = "{{$mkp->mkp_pemohon_daerah_id}}";
				$.ajax({
					type: "GET",
					url: mohon_pendaftaran_mkp_config.routes.mohon_pendaftaran_mkp_url,
					data: {type: 'get_krt', value: value},
					success: function (data) {
						$('#mpm_krt_profile_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#mpm_krt_profile_id')
							.append($('<option>')
							.text(obj.krt_nama)
							.attr('value', obj.id));
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}else{
				
			}

            if("{{$mkp->hasRT}}" == 1){
				$('#mpm_hasRT').attr("checked", "checked");
				$('#mpm_hasRT').val(1);
				$('#mpm_krt_profile_id').attr('disabled', false);
			}else{
				$('#mpm_krt_profile_id').attr('disabled', true);
			}

            if("{{$mkp->krt_profile_id}}" !== ''){
				$('#mpm_krt_profile_id').attr('disabled', false);
				var value = "{{$mkp->mkp_pemohon_state_id}}";
				$.ajax({
					type: "GET",
					url: mohon_pendaftaran_mkp_config.routes.mohon_pendaftaran_mkp_url,
					data: {type: 'get_krt', value: value},
					success: function (data) {
						$('#mpm_krt_profile_id').val("{{$mkp->krt_profile_id}}");
						$('#mpm_krt_profile_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{	
                            
							$('#mpm_krt_profile_id')
							.append($('<option>')
							.text(obj.krt_nama)
							.attr('value', obj.id));
							
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}else{
				
			}
            

        /* Maklumat MKP */
            $('#mgm_mkp_id').val("{{$mkp->id}}");
            $('#mpm1_mkp_gambar').attr('src', "{{ asset('storage/mkp_profile') }}"+"/"+ "{{$mkp->mkp_file_avatar}}");
            $("#mpm1_mkp_pemohon_nama").val($("<div>").html("{{$mkp->mkp_pemohon_nama}}").text());
			//  $('#mpm1_mkp_pemohon_nama').val("{{$mkp->mkp_pemohon_nama}}");
            $('#mpm1_mkp_pemohon_daerah_id').val("{{$mkp->mkp_pemohon_daerah_id}}");

            if("{{$mkp->mkp_pemohon_state_id}}" !== ''){
				var value = "{{$mkp->mkp_pemohon_state_id}}";
				$.ajax({
					type: "GET",
					url: mohon_pendaftaran_mkp_config.routes.mohon_pendaftaran_mkp_url,
					data: {type: 'get_dun', value: value},
					success: function (data) {
						$('#mpm1_mkp_pemohon_dun_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#mpm1_mkp_pemohon_dun_id')
							.append($('<option>')
							.text(obj.dun_description)
							.attr('value', obj.dun_id));
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}else{
				
			}

            $('#mpm1_mkp_pemohon_no_phone').val("{{$mkp->mkp_pemohon_no_phone}}");
            $('#mpm1_mkp_pemohon_ic').val("{{$mkp->mkp_pemohon_ic}}");
            $('#mpm1_mkp_pemohon_state_id').val("{{$mkp->mkp_pemohon_state_id}}");
            
            if("{{$mkp->mkp_pemohon_state_id}}" !== ''){
				var value = "{{$mkp->mkp_pemohon_state_id}}";
				$.ajax({
					type: "GET",
					url: mohon_pendaftaran_mkp_config.routes.mohon_pendaftaran_mkp_url,
					data: {type: 'get_parlimen', value: value},
					success: function (data) {
						$('#mpm1_mkp_pemohon_parlimen_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#mpm1_mkp_pemohon_parlimen_id')
							.append($('<option>')
							.text(obj.parlimen_description)
							.attr('value', obj.parlimen_id));
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}else{
				
			}

            if("{{$mkp->mkp_pemohon_state_id}}" !== ''){
				var value = "{{$mkp->mkp_pemohon_state_id}}";
				$.ajax({
					type: "GET",
					url: mohon_pendaftaran_mkp_config.routes.mohon_pendaftaran_mkp_url,
					data: {type: 'get_pbt', value: value},
					success: function (data) {
						$('#mpm1_mkp_pemohon_pbt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#mpm1_mkp_pemohon_pbt_id')
							.append($('<option>')
							.text(obj.pbt_description)
							.attr('value', obj.pbt_id));
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}else{
				
			}

            $('#mpm1_mkp_pemohon_email').val("{{$mkp->mkp_pemohon_email}}");
            $('#mpm3_spk_imediator_id').val("{{$mkp->id}}");

            $('#mpm1_mkp_pemohon_tarikh_lahir').val("{{$mkp->mkp_pemohon_tarikh_lahir}}");

            if("{{$mkp->mkp_pemohon_dun_id}}" !== ''){
				$('#mpm1_mkp_pemohon_dun_id').attr('disabled', false);
				var value = "{{$mkp->mkp_pemohon_state_id}}";
				$.ajax({
					type: "GET",
					url: mohon_pendaftaran_mkp_config.routes.mohon_pendaftaran_mkp_url,
					data: {type: 'get_dun', value: value},
					success: function (data) {
						$('#mpm1_mkp_pemohon_dun_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#mpm1_mkp_pemohon_dun_id')
							.append($('<option>')
							.text(obj.dun_description)
							.attr('value', obj.dun_id));
							$('#mpm1_mkp_pemohon_dun_id').val("{{$mkp->mkp_pemohon_dun_id}}");
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}else{
				
			}

            $('#mpm1_mkp_pemohon_mukim_id').val("{{$mkp->mkp_pemohon_mukim_id}}");
            $('#mpm1_mkp_pemohon_kaum_id').val("{{$mkp->mkp_pemohon_kaum_id}}");
            $('#mpm1_mkp_pemohon_alamat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
            $('#mpm1_mkp_pemohon_alamat').val("{{$mkp->mkp_pemohon_alamat}}");
            $('#mpm1_mkp_pemohon_kategori_id').val("{{$mkp->mkp_pemohon_kategori_id}}");
            $('#mpm1_mkp_pemohon_akademik').val("{{$mkp->mkp_pemohon_akademik}}");
            $('#mpm1_mkp_tarikh_dilantik').val("{{$mkp->mkp_tarikh_dilantik}}");

            if("{{$mkp->mkp_pemohon_parlimen_id}}" !== ''){
				$('#mpm1_mkp_pemohon_parlimen_id').attr('disabled', false);
				var value = "{{$mkp->mkp_pemohon_state_id}}";
				$.ajax({
					type: "GET",
					url: mohon_pendaftaran_mkp_config.routes.mohon_pendaftaran_mkp_url,
					data: {type: 'get_parlimen', value: value},
					success: function (data) {
						
						$('#mpm1_mkp_pemohon_parlimen_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{	
							$('#mpm1_mkp_pemohon_parlimen_id')
							.append($('<option>')
							.text(obj.parlimen_description)
							.attr('value', obj.parlimen_id));
							$('#mpm1_mkp_pemohon_parlimen_id').val("{{$mkp->mkp_pemohon_parlimen_id}}");
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}else{
				
			}

            if("{{$mkp->mkp_pemohon_pbt_id}}" !== ''){
				$('#mpm1_mkp_pemohon_pbt_id').attr('disabled', false);
				var value = "{{$mkp->mkp_pemohon_state_id}}";
				$.ajax({
						type: "GET",
						url: mohon_pendaftaran_mkp_config.routes.mohon_pendaftaran_mkp_url,
						data: {type: 'get_pbt', value: value},
						success: function (data) {
							$('#mpm1_mkp_pemohon_pbt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
							$.each(data,function(key, obj) 
							{
								$('#mpm1_mkp_pemohon_pbt_id')
								.append($('<option>')
								.text(obj.pbt_description)
								.attr('value', obj.pbt_id));
								$('#mpm1_mkp_pemohon_pbt_id').val("{{$mkp->mkp_pemohon_pbt_id}}");
							});
						},
						error: function (data) {
							console.log('Error:', data);
						}
					}); 
			}else{
				
			}

            $('#mpm1_mkp_pemohon_jantina_id').val("{{$mkp->mkp_pemohon_jantina_id}}");
            $('#mpm1_mkp_pemohon_alamat_p').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
            $('#mpm1_mkp_pemohon_alamat_p').val("{{$mkp->mkp_pemohon_alamat_p}}");
			$('#mpm1_mkp_pemohon_no_phone_p').val("{{$mkp->mkp_pemohon_no_phone_p}}");
			$('#mpm1_mkp_pemohon_tahap_id').val("{{$mkp->mkp_pemohon_tahap_id}}");
			$('#mpm1_mkp_pemohon_khusus').val("{{$mkp->mkp_pemohon_khusus}}");
        
        /* Maklumat Kursus Yang Dihadiri */
            $('#mpm2_spk_imediator_id').val("{{$mkp->id}}");
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
                        if (full.status == 2 || full.status == 5 || full.status == 7 || full.status == 9 || full.status == 11 || full.status == 13 || full.status == 14) {
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

        /* Lock and unlock form */
            if("{{$mkp->status}}" == 2|| "{{$mkp->status}}" == 5|| "{{$mkp->status}}" == 7||"{{$mkp->status}}" == 9|| "{{$mkp->status}}" == 11|| "{{$mkp->status}}" == 13|| "{{$mkp->status}}" == 14){
				$('#mpm_hasRT').attr('disabled', false);
				// $('#mpm_krt_profile_id').attr('disabled', false);
                $('#btn_profile_picture').show();
                $('#mpm1_mkp_pemohon_tarikh_lahir').attr('disabled', false);
                $('#mpm1_mkp_pemohon_dun_id').attr('disabled', false);
                $('#mpm1_mkp_pemohon_mukim_id').attr('disabled', false);
                $('#mpm1_mkp_pemohon_kaum_id').attr('disabled', false);
                $('#mpm1_mkp_pemohon_alamat').attr('disabled', false);
                $('#mpm1_mkp_pemohon_kategori_id').attr('disabled', false);
                $('#mpm1_mkp_pemohon_akademik').attr('disabled', false);
                $('#mpm1_mkp_tarikh_dilantik').attr('disabled', false);
                $('#mpm1_mkp_pemohon_parlimen_id').attr('disabled', false);
                $('#mpm1_mkp_pemohon_pbt_id').attr('disabled', false);
                $('#mpm1_mkp_pemohon_jantina_id').attr('disabled', false);
                $('#mpm1_mkp_pemohon_alamat_p').attr('disabled', false);
                $('#mpm1_mkp_pemohon_no_phone_p').attr('disabled', false);
                $('#mpm1_mkp_pemohon_tahap_id').attr('disabled', false);
                $('#mpm1_mkp_pemohon_khusus').attr('disabled', false);
                $('#mpm2_kursus_nama').attr('disabled', false);
                $('#mpm2_mkp_kategori_kursus_id').attr('disabled', false);
                $('#mpm2_mkp_peringkat_kursus_id').attr('disabled', false);
                $('#mpm2_kursus_penganjur').attr('disabled', false);
                $('#mpm2_file_dokument').attr('disabled', false);
                $('#btn_submit_kursus').show();
                $('#btn_submit').show();
            }else{
				$('#mpm_status_alert').show();
                $('#mpm_hasRT').attr('disabled', true);
				$('#mpm_krt_profile_id').attr('disabled', true);
                $('#btn_profile_picture').hide();
                $('#mpm1_mkp_pemohon_tarikh_lahir').attr('disabled', true);
                $('#mpm1_mkp_pemohon_dun_id').attr('disabled', true);
                $('#mpm1_mkp_pemohon_mukim_id').attr('disabled', true);
                $('#mpm1_mkp_pemohon_kaum_id').attr('disabled', true);
                $('#mpm1_mkp_pemohon_alamat').attr('disabled', true);
                $('#mpm1_mkp_pemohon_kategori_id').attr('disabled', true);
                $('#mpm1_mkp_pemohon_akademik').attr('disabled', true);
                $('#mpm1_mkp_tarikh_dilantik').attr('disabled', true);
                $('#mpm1_mkp_pemohon_parlimen_id').attr('disabled', true);
                $('#mpm1_mkp_pemohon_pbt_id').attr('disabled', true);
                $('#mpm1_mkp_pemohon_jantina_id').attr('disabled', true);
                $('#mpm1_mkp_pemohon_alamat_p').attr('disabled', true);
                $('#mpm1_mkp_pemohon_no_phone_p').attr('disabled', true);
                $('#mpm1_mkp_pemohon_tahap_id').attr('disabled', true);
                $('#mpm1_mkp_pemohon_khusus').attr('disabled', true);
                $('#mpm2_kursus_nama').attr('disabled', true);
                $('#mpm2_mkp_kategori_kursus_id').attr('disabled', true);
                $('#mpm2_mkp_peringkat_kursus_id').attr('disabled', true);
                $('#mpm2_kursus_penganjur').attr('disabled', true);
                $('#mpm2_file_dokument').attr('disabled', true);
                $('#btn_submit_kursus').hide();
                $('#btn_submit').hide();
			}

        /* Maklumat Status Alert */
            $('#mpm_no_rujukan_mkp').html("{{$mkp->no_rujukan_mkp}}");
            $('#mpm_status_description').html("{{$mkp->status_description}}");

		/* Maklumat Note Kemaskini */
			if("{{$mkp->status}}" == '5'){
				$("#mpm_perlu_kemaskini").show();
				$('#mpm2_no_rujukan_mkp').html("{{$mkp->no_rujukan_mkp}}");
				$('#mpm2_status_description').html("{{$mkp->status_description}}");
				$('#mpm_disokong_note').html("{{$mkp->disokong_note}}");
			}

			if("{{$mkp->status}}" == '7'){
				$("#mpm_perlu_kemaskini").show();
				$('#mpm2_no_rujukan_mkp').html("{{$mkp->no_rujukan_mkp}}");
				$('#mpm2_status_description').html("{{$mkp->status_description}}");
				$('#mpm_disokong_p_note').html("{{$mkp->disokong_p_note}}");
			}

			if("{{$mkp->status}}" == '9'){
				$("#mpm_perlu_kemaskini").show();
				$('#mpm2_no_rujukan_mkp').html("{{$mkp->no_rujukan_mkp}}");
				$('#mpm2_status_description').html("{{$mkp->status_description}}");
				$('#mpm_disahkan_note').html("{{$mkp->disahkan_note}}");
			}

			if("{{$mkp->status}}" == '11'){
				$("#mpm_perlu_kemaskini").show();
				$('#mpm2_no_rujukan_mkp').html("{{$mkp->no_rujukan_mkp}}");
				$('#mpm2_status_description').html("{{$mkp->status_description}}");
				$('#mpm_disemak_note').html("{{$mkp->disemak_note}}");
			}

			if("{{$mkp->status}}" == '13'){
				$("#mpm_perlu_kemaskini").show();
				$('#mpm2_no_rujukan_mkp').html("{{$mkp->no_rujukan_mkp}}");
				$('#mpm2_status_description').html("{{$mkp->status_description}}");
				$('#mpmp_dilulus_note').html("{{$mkp->dilulus_note}}");
			}

			if("{{$mkp->status}}" == '14'){
				$("#mpm_perlu_kemaskini").show();
				$('#mpm2_no_rujukan_mkp').html("{{$mkp->no_rujukan_mkp}}");
				$('#mpm2_status_description').html("{{$mkp->status_description}}");
				$('#mpm_dilantik_note').html("{{$mkp->dilantik_note}}");
			}
	});

    /* click add gambar profile mkp */
		$(document).on('submit', '#form_mgm', function(event){
			var info = $('.error_form_mgm');
			event.preventDefault();

			var form_data = new FormData();
			form_data.append("mgm_mkp_file_avatar",  $("#mgm_mkp_file_avatar")[0].files[0]);
			form_data.append("mgm_mkp_id", $("#mgm_mkp_id").val() );
			form_data.append("post_edit_gambar_mkp", "edit" );
			console.log(form_data);

			$('#btn_edit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_edit').prop('disabled', true);

			btn_text = 'Kemaskini Gambar&nbsp;&nbsp;<i class="dropdown-icon fa fa-edit"></i>';
			url = "{{ route('rt-sm23.post_edit_gambar_mkp') }}";
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
					$('#btn_edit').html(btn_text);                
					$('#btn_edit').prop('disabled', false);
					info.slideDown();
				} else {
                    window.location.href = "{{route('rt-sm23.mohon_pendaftaran_mkp')}}";
                    $('#modal_gambar_mkp').modal('hide');
					$('#form_mgm').trigger("reset");
					$('#btn_edit').html(btn_text);
					$('#btn_edit').prop('disabled', false);
					
				}
			});
		});

    /* click add kursus */
        $(document).on('submit', '#form_mpm2', function(event){
			var info = $('.error_alert');
			event.preventDefault();
			var form_data = new FormData();
			form_data.append("mpm2_kursus_nama", $("#mpm2_kursus_nama").val() );
			form_data.append("mpm2_mkp_kategori_kursus_id", $("#mpm2_mkp_kategori_kursus_id").val() );
            form_data.append("mpm2_mkp_peringkat_kursus_id", $("#mpm2_mkp_peringkat_kursus_id").val() );
            form_data.append("mpm2_kursus_penganjur", $("#mpm2_kursus_penganjur").val() );
			form_data.append("mpm2_file_dokument",  $("#mpm2_file_dokument")[0].files[0]);
			form_data.append("mpm2_spk_imediator_id", $("#mpm2_spk_imediator_id").val() );
			form_data.append("post_imediator_kursus_mkp", "add" );
			console.log(form_data);
			$('#btn_submit_kursus').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit_kursus').prop('disabled', true);
			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm23.post_imediator_kursus_mkp') }}";
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
					$('#form_mpm2').trigger("reset");
					$('#btn_submit_kursus').html(btn_text);
					$('#btn_submit_kursus').prop('disabled', false);
					$('#senarai_kursus_mkp_table').DataTable().ajax.reload();
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
		var permohonan_mkp_1_config = {
			routes: {
				permohonan_mkp_1_url: "{{ route('rt-sm23.post_mohon_mkp') }}",
			}
		};

        $(document).on('submit', '#form_mpm3', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data   = $("#form_mpm, #form_mpm1, #form_mpm3").serialize();
			var action = $('#post_mohon_mkp').val();
			var btn_text;
			if (action == 'edit') {
				url = permohonan_mkp_1_config.routes.permohonan_mkp_1_url;
				type = "POST";
				btn_text = 'Hantar Permohonan MKP&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=mpm_krt_profile_id]').removeClass("is-invalid");
				$('[name=mpm1_mkp_pemohon_tarikh_lahir]').removeClass("is-invalid");
				$('[name=mpm1_mkp_pemohon_dun_id]').removeClass("is-invalid");
				$('[name=mpm1_mkp_pemohon_mukim_id]').removeClass("is-invalid");
				$('[name=mpm1_mkp_pemohon_kaum_id]').removeClass("is-invalid");
				$('[name=mpm1_mkp_pemohon_alamat]').removeClass("is-invalid");
				$('[name=mpm1_mkp_pemohon_kategori_id]').removeClass("is-invalid");
				$('[name=mpm1_mkp_pemohon_akademik]').removeClass("is-invalid");
				$('[name=mpm1_mkp_pemohon_parlimen_id]').removeClass("is-invalid");
				$('[name=mpm1_mkp_pemohon_pbt_id]').removeClass("is-invalid");
				$('[name=mpm1_mkp_pemohon_jantina_id]').removeClass("is-invalid");
				$('[name=mpm1_mkp_pemohon_alamat_p]').removeClass("is-invalid");
				$('[name=mpm1_mkp_pemohon_no_phone_p]').removeClass("is-invalid");
				$('[name=mpm1_mkp_pemohon_tahap_id]').removeClass("is-invalid");
				$('[name=mpm1_mkp_pemohon_khusus]').removeClass("is-invalid");
				$('[name=mpm1_mkp_tarikh_dilantik]').removeClass("is-invalid");

				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'mpm_krt_profile_id') {
							$('[name=mpm_krt_profile_id]').addClass("is-invalid");
							$('.error_mpm_krt_profile_id').html(error);
						}

						if(index == 'mpm1_mkp_pemohon_tarikh_lahir') {
							$('[name=mpm1_mkp_pemohon_tarikh_lahir]').addClass("is-invalid");
							$('.error_mpm1_mkp_pemohon_tarikh_lahir').html(error);
						}

						if(index == 'mpm1_mkp_pemohon_dun_id') {
							$('[name=mpm1_mkp_pemohon_dun_id]').addClass("is-invalid");
							$('.error_mpm1_mkp_pemohon_dun_id').html(error);
						}

						if(index == 'mpm1_mkp_pemohon_mukim_id') {
							$('[name=mpm1_mkp_pemohon_mukim_id]').addClass("is-invalid");
							$('.error_mpm1_mkp_pemohon_mukim_id').html(error);
						}

						if(index == 'mpm1_mkp_pemohon_kaum_id') {
							$('[name=mpm1_mkp_pemohon_kaum_id]').addClass("is-invalid");
							$('.error_mpm1_mkp_pemohon_kaum_id').html(error);
						}

						if(index == 'mpm1_mkp_pemohon_alamat') {
							$('[name=mpm1_mkp_pemohon_alamat]').addClass("is-invalid");
							$('.error_mpm1_mkp_pemohon_alamat').html(error);
						}

						if(index == 'mpm1_mkp_pemohon_kategori_id') {
							$('[name=mpm1_mkp_pemohon_kategori_id]').addClass("is-invalid");
							$('.error_mpm1_mkp_pemohon_kategori_id').html(error);
						}

						if(index == 'mpm1_mkp_pemohon_akademik') {
							$('[name=mpm1_mkp_pemohon_akademik]').addClass("is-invalid");
							$('.error_mpm1_mkp_pemohon_akademik').html(error);
						}

						if(index == 'mpm1_mkp_pemohon_parlimen_id') {
							$('[name=mpm1_mkp_pemohon_parlimen_id]').addClass("is-invalid");
							$('.error_mpm1_mkp_pemohon_parlimen_id').html(error);
						}

						if(index == 'mpm1_mkp_pemohon_pbt_id') {
							$('[name=mpm1_mkp_pemohon_pbt_id]').addClass("is-invalid");
							$('.error_mpm1_mkp_pemohon_pbt_id').html(error);
						}

						if(index == 'mpm1_mkp_pemohon_jantina_id') {
							$('[name=mpm1_mkp_pemohon_jantina_id]').addClass("is-invalid");
							$('.error_mpm1_mkp_pemohon_jantina_id').html(error);
						}

						if(index == 'mpm1_mkp_pemohon_alamat_p') {
							$('[name=mpm1_mkp_pemohon_alamat_p]').addClass("is-invalid");
							$('.error_mpm1_mkp_pemohon_alamat_p').html(error);
						}

						if(index == 'mpm1_mkp_pemohon_no_phone_p') {
							$('[name=mpm1_mkp_pemohon_no_phone_p]').addClass("is-invalid");
							$('.error_mpm1_mkp_pemohon_no_phone_p').html(error);
						}

						if(index == 'mpm1_mkp_pemohon_tahap_id') {
							$('[name=mpm1_mkp_pemohon_tahap_id]').addClass("is-invalid");
							$('.error_mpm1_mkp_pemohon_tahap_id').html(error);
						}

						if(index == 'mpm1_mkp_pemohon_khusus') {
							$('[name=mpm1_mkp_pemohon_khusus]').addClass("is-invalid");
							$('.error_mpm1_mkp_pemohon_khusus').html(error);
						}

						if(index == 'mpm1_mkp_tarikh_dilantik') {
							$('[name=mpm1_mkp_tarikh_dilantik]').addClass("is-invalid");
							$('.error_mpm1_mkp_tarikh_dilantik').html(error);
						}
					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm23.mohon_pendaftaran_mkp')}}";
				}
			});
		});
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop