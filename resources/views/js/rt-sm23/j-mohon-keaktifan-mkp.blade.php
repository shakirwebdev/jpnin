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
            url_table_mediasi		= "{{ route('rt-sm23.get_kes_mediasi_mkp_table','') }}"+"/"+"{{$mkp->id}}";
            url_table_aktiviti		= "{{ route('rt-sm23.get_keaktifan_aktiviti_mkp_table','') }}"+"/"+"{{$mkp->id}}";
            url_delete_aktiviti 	= "{{ route('rt-sm23.delete_keaktifan_aktiviti_mkp','') }}";

		/* Maklumat MKP */
            $('#mkm_mkp_nama').val("{{$mkp->mkp_nama}}");
            $('#mkm_mkp_no_ic').val("{{$mkp->mkp_no_ic}}");
            $('#mkm_mkp_no_phone').val("{{$mkp->mkp_no_phone}}");
			$('#mkm_mkp_email').val("{{$mkp->user_email}}");

		/* Maklumat Kriteria Penilaian Keaktifan Mediator */
            
            var senarai_kes_mediasi_table = $('#senarai_kes_mediasi_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_mediasi,
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
					"width": "38%", 
					"mRender": function ( value, type, full )  {
						return full.kluster_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					"mRender": function ( value, type, full )  {
						return full.mediasi_status_kes;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "38%", 
					"mRender": function ( value, type, full )  {
						return full.peringkat_description;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
			
            var senarai_aktiviti_table = $('#senarai_aktiviti_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_aktiviti,
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
						return full.aktiviti_nama;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.aktiviti_tarikh;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.aktiviti_tempat;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "17%", 
					"mRender": function ( value, type, full )  {
						return full.aktiviti_jawatan;
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
                            button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_aktiviti" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
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
			$('#total_kes').html("{{$total_kes->total_kes}}");
            $('#pkkmkp2_spk_imediator_id').val("{{$mkp->id}}");
			
			
			if("{{$mkp->status_mkp}}" == 1){
				$('#mkm_status_alert').hide();
				$('#pkkmkp2_aktiviti_nama').attr('disabled', false);
                $('#pkkmkp2_aktiviti_tarikh').attr('disabled', false);
                $('#pkkmkp2_aktiviti_tempat').attr('disabled', false);
                $('#pkkmkp2_aktiviti_jawatan').attr('disabled', false);
                $('#pkkmkp2_ref_peringkat_id').attr('disabled', false);
                $('#btn_save').show();
            }else{
				$('#mkm_status_alert').show();
				$('#mkm_no_rujukan_mkp').html("{{$mkp->no_rujukan_mkp}}");
				$('#mkm_status_mkp').show();
				$('#mkm_status_mkp_description').html("{{$mkp->status_mkp_description}}");
				$('#mkm_status_description').html("{{$mkp->status_description}}");
				$('#pkkmkp2_aktiviti_nama').attr('disabled', true);
                $('#pkkmkp2_aktiviti_tarikh').attr('disabled', true);
                $('#pkkmkp2_aktiviti_tempat').attr('disabled', true);
                $('#pkkmkp2_aktiviti_jawatan').attr('disabled', true);
                $('#pkkmkp2_ref_peringkat_id').attr('disabled', true);
                $('#btn_save').hide();
			}

			if("{{$mkp->status}}" == 2 || "{{$mkp->status}}" == 5 || "{{$mkp->status}}" == 6){
				$('#mkm_status_alert').hide();
				$('#pkkmkp2_aktiviti_nama').attr('disabled', false);
                $('#pkkmkp2_aktiviti_tarikh').attr('disabled', false);
                $('#pkkmkp2_aktiviti_tempat').attr('disabled', false);
                $('#pkkmkp2_aktiviti_jawatan').attr('disabled', false);
                $('#pkkmkp2_ref_peringkat_id').attr('disabled', false);
                $('#btn_save').show();
            }else if("{{$mkp->status}}" == 1 || "{{$mkp->status}}" == 2 || "{{$mkp->status}}" == 3){
				$('#mkm_status_alert').show();
				$('#mkm_no_rujukan_mkp').html("{{$mkp->no_rujukan_mkp}}");
				$('#mkm_status_permohonan').show();
				$('#alert_status_permohonan').removeClass('alert-warning');
				$('#alert_status_permohonan').addClass('alert-primary');
				$('#mkm_status_mkp_description').html("{{$mkp->status_mkp_description}}");
				$('#mkm_status_description').html("{{$mkp->status_description}}");
				$('#pkkmkp2_aktiviti_nama').attr('disabled', true);
                $('#pkkmkp2_aktiviti_tarikh').attr('disabled', true);
                $('#pkkmkp2_aktiviti_tempat').attr('disabled', true);
                $('#pkkmkp2_aktiviti_jawatan').attr('disabled', true);
                $('#pkkmkp2_ref_peringkat_id').attr('disabled', true);
                $('#btn_save').hide();
            }else{
				$('#mkm_status_alert').hide();
				
                $('#btn_save').show();
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
			$('#btn_next').click(function(){
				window.location.href = "{{ route('rt-sm23.mohon_keaktifan_mkp_1') }}";
			});
	});

    /* click add aktiviti */
		$(document).on('submit', '#form_pkkmkp2', function(event){
			var info = $('.error_alert_pkkmkp2');
			event.preventDefault();

			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save').prop('disabled', true);

			var data = $("#form_pkkmkp2").serialize();
			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm23.post_add_keaktifan_aktiviti_mkp') }}";
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
					swal("Aktiviti / Program Sosial / Kemasyarakatan ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_pkkmkp2').trigger("reset");
					$('#btn_save').html(btn_text);
					$('#btn_save').prop('disabled', false);
					$('#senarai_aktiviti_table').DataTable().ajax.reload();
				}
			});
		});

    /* click delete aktiviti */
		$('body').on('click', '#delete_aktiviti', function () {
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
						url: url_delete_aktiviti +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_aktiviti_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Aktiviti / Program Sosial / Kemasyarakatan telah dipadam dari pangkalan data", "success");
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

	

	

	

	

	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop