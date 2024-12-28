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
           url_table_latihan		= "{{ route('rt-sm23.get_keaktifan_latihan_table_mkp','') }}"+"/"+"{{$mkp->id}}";
           url_delete_latihan 		= "{{ route('rt-sm23.delete_keaktifan_latihan_mkp','') }}";
           url_table_sumbangan		= "{{ route('rt-sm23.get_keaktifan_sumbangan_mkp_table','') }}"+"/"+"{{$mkp->id}}";
           url_delete_sumbangan    	= "{{ route('rt-sm23.delete_keaktifan_sumbangan_mkp','') }}";

        /* Maklumat MKP */
            $('#mkm4_mkp_nama').val("{{$mkp->mkp_nama}}");
            $('#mkm4_mkp_no_ic').val("{{$mkp->mkp_no_ic}}");
            $('#mkm4_mkp_no_phone').val("{{$mkp->mkp_no_phone}}");
			$('#mkm4_mkp_email').val("{{$mkp->user_email}}");

        /* Maklumat Kriteria Penilaian Keaktifan Mediator */

            var senarai_latihan_table = $('#senarai_latihan_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_latihan,
				"language": {
					"paginate": {
						"previous": "Sebelumnya",
						"next": "Seterusnya",
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
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.latihan_nama;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.latihan_tarikh;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.latihan_tempat;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.latihan_penganjur;
					}
				},{          
					"aTargets": [ 5 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.peringkat_description;
					}
				},{          
					"aTargets": [ 6 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						if (full.status == null || full.status == 2 || full.status == 5 || full.status == 7 || full.status == 9 || full.status == 11 || full.status == 13 || full.status == 14) {
                            button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_latihan" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
							return button_a;
                        } else {
                            button_a = '';
                            return button_a;
                        }
						
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
    	    
            $('#mkm5_spk_imediator_id').val("{{$mkp->id}}");

            var senarai_sumbangan_table = $('#senarai_sumbangan_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_sumbangan,
				"language": {
					"paginate": {
						"previous": "Sebelumnya",
						"next": "Seterusnya",
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
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.sumbangan_nama;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.peringkat_description;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						if (full.status == null || full.status == 2 || full.status == 5 || full.status == 7 || full.status == 9 || full.status == 11 || full.status == 13 || full.status == 14) {
							button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_sumbangan" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
							return button_a;
                        } else {
                            button_a = '';
                            return button_a;
                        }
						
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

            $('#mkm6_spk_imediator_id').val("{{$mkp->id}}");
            $('#mkm7_spk_imediator_id').val("{{$mkp->id}}");
			$('#mkm7_spk_imediator_keaktifan_id').val("{{$mkp->spk_imediator_id}}");

            var d = new Date();
            var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();
            
            if("{{$mkp->tarikh_mkp_hantar_keaktifan}}" <= strDate){
                
			}else{
                $('#btn_submit').removeClass( "btn-primary" ).addClass("btn-secondary");
                $("#btn_submit").prop("disabled",true);
				$('#btn_edit').removeClass( "btn-primary" ).addClass("btn-secondary");
                $("#btn_edit").prop("disabled",true);
            }

			if("{{$mkp->status_mkp}}" == 1){
				$('#mkm_status_alert').hide();
				$('#mkm5_latihan_nama').attr('disabled', false);
                $('#mkm5_latihan_tarikh').attr('disabled', false);
                $('#mkm5_latihan_tempat').attr('disabled', false);
                $('#mkm5_latihan_penganjur').attr('disabled', false);
                $('#mkm5_ref_peringkat_id').attr('disabled', false);
				$('#btn_save').hide();
				$('#mkm6_sumbangan_nama').attr('disabled', false);
				$('#mkm6_ref_peringkat_id').attr('disabled', false);
				$('#btn_save_sumbangan').show();
				$('#btn_submit').show();
				$('#btn_edit').hide();
            }else{
				$('#mkm_status_alert').show();
				$('#mkm_no_rujukan_mkp').html("{{$mkp->no_rujukan_mkp}}");
				$('#mkm_status_mkp').show();
				$('#mkm_status_mkp_description').html("{{$mkp->status_mkp_description}}");
				$('#mkm_status_description').html("{{$mkp->status_description}}");
				$('#mkm5_latihan_nama').attr('disabled', true);
                $('#mkm5_latihan_tarikh').attr('disabled', true);
                $('#mkm5_latihan_tempat').attr('disabled', true);
                $('#mkm5_latihan_penganjur').attr('disabled', true);
                $('#mkm5_ref_peringkat_id').attr('disabled', true);
				$('#btn_save').hide();
				$('#mkm6_sumbangan_nama').attr('disabled', true);
				$('#mkm6_ref_peringkat_id').attr('disabled', true);
				$('#btn_save_sumbangan').hide();
				$('#btn_submit').hide();
				$('#btn_edit').hide();
			}

            
			if("{{$mkp->status}}" == 2){
				$('#mkm_status_alert').hide();
				$('#mkm5_latihan_nama').attr('disabled', false);
                $('#mkm5_latihan_tarikh').attr('disabled', false);
                $('#mkm5_latihan_tempat').attr('disabled', false);
                $('#mkm5_latihan_penganjur').attr('disabled', false);
                $('#mkm5_ref_peringkat_id').attr('disabled', false);
                $('#btn_save').show();
				$('#mkm6_sumbangan_nama').attr('disabled', false);
				$('#mkm6_ref_peringkat_id').attr('disabled', false);
				$('#btn_save_sumbangan').show();
				$('#btn_submit').show();
            }
			
			if("{{$mkp->status}}" == 5|| "{{$mkp->status}}" == 7|| "{{$mkp->status}}" == 8){
				$('#mkm_status_alert').hide();
				$('#mkm5_latihan_nama').attr('disabled', false);
                $('#mkm5_latihan_tarikh').attr('disabled', false);
                $('#mkm5_latihan_tempat').attr('disabled', false);
                $('#mkm5_latihan_penganjur').attr('disabled', false);
                $('#mkm5_ref_peringkat_id').attr('disabled', false);
                $('#btn_save').show();
				$('#mkm6_sumbangan_nama').attr('disabled', false);
				$('#mkm6_ref_peringkat_id').attr('disabled', false);
				$('#btn_save_sumbangan').show();
				$('#btn_submit').hide();
				$('#btn_edit').show();
            }else if("{{$mkp->status}}" == 1|| "{{$mkp->status}}" == 2|| "{{$mkp->status}}" == 3){
				$('#mkm_status_alert').show();
				$('#mkm_status_permohonan').show();
				$('#alert_status_permohonan').removeClass('alert-warning');
				$('#alert_status_permohonan').addClass('alert-primary');
				$('#mkm_no_rujukan_mkp').html("{{$mkp->no_rujukan_mkp}}");
				$('#mkm_status_description').html("{{$mkp->status_description}}");
				$('#mkm5_latihan_nama').attr('disabled', true);
                $('#mkm5_latihan_tarikh').attr('disabled', true);
                $('#mkm5_latihan_tempat').attr('disabled', true);
                $('#mkm5_latihan_penganjur').attr('disabled', true);
                $('#mkm5_ref_peringkat_id').attr('disabled', true);
				$('#btn_save').hide();
				$('#mkm6_sumbangan_nama').attr('disabled', true);
				$('#mkm6_ref_peringkat_id').attr('disabled', true);
				$('#btn_save_sumbangan').hide();
				$('#btn_submit').hide();
				$('#btn_edit').hide();
            }else{
				$('#btn_save').show();
				$('#btn_submit').show();
				$('#btn_edit').hide();
			}
            
           
		/* Maklumat Note Kemaskini */
			$('#mkm_status').val("{{$mkp->status}}");

			if($('#mkm_status').val() == '5'){
				$("#mkm_perlu_kemaskini").show();
				$('#mkm_status_description_1').html("{{$mkp->status_description}}");
				$('#mkm_disokong_note').html("{{$mkp->disokong_note}}");
			}

			if($('#mkm_status').val() == '7'){
				$("#mkm_perlu_kemaskini").show();
				$('#mkm_status_description_1').html("{{$mkp->status_description}}");
				$('#mkm_disokong_p_note').html("{{$mkp->disokong_p_note}}");
			}

			if($('#mkm_status').val() == '8'){
				$("#mkm_perlu_kemaskini").show();
				$('#mkm_status_description_1').html("{{$mkp->status_description}}");
				$('#mkm_disahkan_note').html("{{$mkp->disahkan_note}}");
			}

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm23.mohon_keaktifan_mkp') }}";
			});

	});

    /* click add latihan */
		$(document).on('submit', '#form_mkm5', function(event){
			var info = $('.error_alert_mkm5');
			event.preventDefault();

			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save').prop('disabled', true);

			var data = $("#form_mkm5").serialize();
			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm23.post_add_keaktifan_latihan_mkp') }}";
			type = "POST";

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {            
				info.hide().find('ul').empty();
				if(response.errors){
					$.each(response.errors, function(index, error){
						info.find('ul').append('<li>'+error+'</li>');
					});
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Latihan / Kursus Pembangunan Diri ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_mkm5').trigger("reset");
					$('#btn_save').html(btn_text);
					$('#btn_save').prop('disabled', false);
					$('#senarai_latihan_table').DataTable().ajax.reload();
				}
			});
		});

    /* click delete aktiviti */
        $('body').on('click', '#delete_latihan', function () {
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
						url: url_delete_latihan +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_latihan_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Latihan / Kursus Pembangunan Diri telah dipadam dari pangkalan data", "success");
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

    /* click add sumbangan */
		$(document).on('submit', '#form_mkm6', function(event){
			var info = $('.error_alert_mkm6');
			event.preventDefault();

			$('#btn_save_sumbangan').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save_sumbangan').prop('disabled', true);

			var data = $("#form_mkm6").serialize();
			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm23.post_add_keaktifan_sumbangan_mkp') }}";
			type = "POST";

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {            
				info.hide().find('ul').empty();
				if(response.errors){
					$.each(response.errors, function(index, error){
						info.find('ul').append('<li>'+error+'</li>');
					});
					$('#btn_save_sumbangan').html(btn_text);                
					$('#btn_save_sumbangan').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Sumbangan Dan Pengiktirafan ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_mkm6').trigger("reset");
					$('#btn_save_sumbangan').html(btn_text);
					$('#btn_save_sumbangan').prop('disabled', false);
					$('#senarai_sumbangan_table').DataTable().ajax.reload();
				}
			});
		});

    /* click delete sumbangan */
        $('body').on('click', '#delete_sumbangan', function () {
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
						url: url_delete_sumbangan +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_sumbangan_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Sumbangan Dan Pengiktirafan telah dipadam dari pangkalan data", "success");
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

    /* click btn Submit */
		var permohonan_keaktifan_mkp_config = {
			routes: {
				permohonan_keaktifan_mkp_url: "{{ route('rt-sm23.post_permohonan_keaktifan_mkp') }}",
				edit_permohonan_keaktifan_mkp_url: "{{ route('rt-sm23.post_edit_permohonan_keaktifan_mkp') }}"
			}
		};

        $(document).on('click', '#btn_submit', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data   = $("#form_mkm7").serialize();
			var action = $('#post_permohonan_keaktifan_mkp').val();
			var btn_text;
			if (action == 'add') {
				url = permohonan_keaktifan_mkp_config.routes.permohonan_keaktifan_mkp_url;
				type = "POST";
				btn_text = 'Hantar Permohonan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						
					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm23.mohon_keaktifan_mkp')}}";
				}
			});
		});

		$(document).on('click', '#btn_edit', function(event){    
			event.preventDefault();
			$('#btn_edit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_edit').prop('disabled', true);
			var data   = $("#form_mkm7").serialize();
			var action = $('#post_edit_permohonan_keaktifan_mkp').val();
			var btn_text;
			if (action == 'edit') {
				url = permohonan_keaktifan_mkp_config.routes.edit_permohonan_keaktifan_mkp_url;
				type = "POST";
				btn_text = 'Kemaskini Permohonan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						
					});
					$('#btn_edit').html(btn_text);                
					$('#btn_edit').prop('disabled', false);            
				} else {
					$('#btn_edit').html(btn_text);
					$('#btn_edit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm23.mohon_keaktifan_mkp')}}";
				}
			});
		});
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop