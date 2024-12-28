@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
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

		/* Maklumat KRT Yang Dimohon */
			$('#kpk_krt_nama').html("{{$profile_krt->krt_nama}}");
			$('#kpk_krt_alamat').html("{{$profile_krt->krt_alamat}}");
			$('#kpk_tarikh_memohon').html("{{$profile_krt->created_at}}");

		/* Maklumat Pemohon */
			$('#kpk_pemohon_name').val("{{$profile_krt->user_fullname}}");
			$('#kpk_pemohon_ic').val("{{$profile_krt->no_ic}}");
			$('#kpk_pemohon_alamat').val("{{$profile_krt->user_address}}");
        
			url_1 = "{{ route('rt-sm1.get_kes_jenayah_table','') }}"+"/"+$('#kpk4_1_krt_profileID').val();
			url_2 = "{{ route('rt-sm1.get_masalah_sosial_table','') }}"+"/"+$('#kpk4_2_krt_profileID').val();

			var kes_jenayah_table = $('#kes_jenayah_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_1,
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
					"width": "60%", 
					"mRender": function ( value, type, full )  {
						return full.jenayah_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						$checked = (full.krt_kesJenayahID) ? 'checked' : '';
						$button_a = '<label class="custom-control custom-checkbox">' +
									'<input type="checkbox" class="custom-control-input" id="chkp_2' + full.id + '" value="' + full.id + '" onchange="getKesJenayah(&apos;' + full.id + '&apos;)" ' +
									$checked + '>' +
									'<span class="custom-control-label">&nbsp;</span></label>';
						return $button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var kes_jenayah_table = $('#masalah_sosial_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_2,
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
					"width": "60%", 
					"mRender": function ( value, type, full )  {
						return full.sosial_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						$checked = (full.krt_masalahSosialID) ? 'checked' : '';
						$button_a = '<label class="custom-control custom-checkbox">' +
									'<input type="checkbox" class="custom-control-input" id="chkp_3' + full.id + '" value="' + full.id + '" onchange="getMasalahSosial(&apos;' + full.id + '&apos;)" ' +
									$checked + '>' +
									'<span class="custom-control-label">&nbsp;</span></label>';
						return $button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

		/* Maklumat Note Kemaskini */
			$('#kpk_status').val("{{$profile_krt->status}}");
            
            if($('#kpk_status').val() == '5'){
                $("#kpk_perlu_kemaskini").show();
                $('#kpk_status_description').html("{{$profile_krt->status_description}}");
                $('#kpk_disemak_note').html("{{$profile_krt->disemak_note}}");
            }

            if($('#kpk_status').val() == '7'){
                $("#kpk_perlu_kemaskini").show();
                $('#kpk_status_description').html("{{$profile_krt->status_description}}");
                $('#kpk_disahkan_note').html("{{$profile_krt->disahkan_note}}");
            }

			if($('#kpk_status').val() == '8'){
                $("#kpk_perlu_kemaskini").show();
                $('#kpk_status_description').html("{{$profile_krt->status_description}}");
                $('#kpk_diluluskan_note').html("{{$profile_krt->diluluskan_note}}");
            }

	});

	function getKesJenayah(id) {
		//checked
		if ($('#chkp_2' + id).is(':checked')) {
			// alert('checked');
			var kpk4_1_krt_profileID 	= $('#kpk4_1_krt_profileID').val();
			url_add_kes_jenayah 		= "{{ route('rt-sm1.post_kes_jenayah') }}";
			type = "POST";
			$.ajax({
				url: url_add_kes_jenayah,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"kpk4_1_krt_profileID": kpk4_1_krt_profileID,
						"krt_kesJenayahID": id
						}
			});
		}

		//unchecked
		if (!$('#chkp_2' + id).is(':checked')) {
			// alert('unchecked');
            var kpk4_1_krt_profileID 	= $('#kpk4_1_krt_profileID').val();
			url_delete_kes_jenayah 		= "{{ route('rt-sm1.delete_kes_jenayah','') }}";
            type = "POST";
			$.ajax({
				url: url_delete_kes_jenayah,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"kpk4_1_krt_profileID": kpk4_1_krt_profileID,
						"krt_kesJenayahID": id
						}
			});
			
		}
	}

	function getMasalahSosial(id) {
		//checked
		if ($('#chkp_3' + id).is(':checked')) {
			// alert('checked');
			var kpk4_2_krt_profileID = $('#kpk4_2_krt_profileID').val();
			url_add_masalah_sosial = "{{ route('rt-sm1.post_masalah_sosial') }}";
			type = "POST";
			$.ajax({
				url: url_add_masalah_sosial,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"kpk4_2_krt_profileID": kpk4_2_krt_profileID,
						"krt_masalahSosialID": id
						}
			});
		}

		//unchecked
		if (!$('#chkp_3' + id).is(':checked')) {
			// alert('unchecked');
            var kpk4_2_krt_profileID 		= $('#kpk4_2_krt_profileID').val();
			url_delete_masalah_sosial 	= "{{ route('rt-sm1.delete_masalah_sosial','') }}";
            type = "POST";
			$.ajax({
				url: url_delete_masalah_sosial,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"kpk4_2_krt_profileID": kpk4_2_krt_profileID,
						"krt_masalahSosialID": id
						}
			});
			
		}
	}

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop