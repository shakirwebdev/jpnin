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

		//my custom script
			url_table_jenis_pertubuhan = "{{ route('rt-sm2.get_profile_krt_jenis_pertubuhan_table','') }}"+"/"+"{{$profile_krt->id}}";

		/* Maklumat AM KRT */
			$('#pk_krt_nama').html("{{$profile_krt->krt_nama}}");
			$('#pk_krt_alamat').html("{{$profile_krt->krt_alamat}}");
			$('#pk_tarikh_memohon').html("{{$profile_krt->created_at}}");
		
		/* Maklumat Asas kawasan */
			$('#pk6_krt_profileID').val("{{$profile_krt->id}}");
			var senarai_jenis_pertubuhan_table = $('#senarai_jenis_pertubuhan_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_jenis_pertubuhan,
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
						return full.jenis_pertubuhan_description;
					}
				},{       
					"aTargets": [ 2 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						$checked 	= (full.krt_JenisPertubuhanID) ? 'checked' : '';
						$button_a 	= '<label class="custom-control custom-checkbox">' +
									'<input class="custom-control-input" type="checkbox" id="chkp_1' + full.id + '" value="' + full.id + '" onchange="getJenisPertubuhan(&apos;' + full.id + '&apos;)" ' +
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
			
		/* Button */
			$('#btn_back').click(function(){
				window.location.href = '{{route('rt-sm2.profile_krt_1')}}';
			});

			$('#btn_next').click(function(){
				window.location.href = '{{route('rt-sm2.profile_krt_3')}}';
			});
	});

	function getJenisPertubuhan(id) {
		//checked
		if ($('#chkp_1' + id).is(':checked')) {
			// alert('checked');
			var pk6_krt_profileID 		= $('#pk6_krt_profileID').val();
			url_add_jenis_pertubuhan 	= "{{ route('rt-sm2.post_profile_krt_jenis_pertubuhan') }}";
			type = "POST";
			$.ajax({
				url: url_add_jenis_pertubuhan,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"pk6_krt_profileID": pk6_krt_profileID,
						"krt_JenisPertubuhanID": id
						}
			});
		}

		//unchecked
		if (!$('#chkp_1' + id).is(':checked')) {
			// alert('unchecked');
            var pk6_krt_profileID 			= $('#pk6_krt_profileID').val();
			url_delete_jenis_pertubuhan 	= "{{ route('rt-sm2.post_delete_profile_krt_jenis_pertubuhan','') }}";
            type = "POST";
			$.ajax({
				url: url_delete_jenis_pertubuhan,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"pk6_krt_profileID": pk6_krt_profileID,
						"krt_JenisPertubuhanID": id
						}
			});
			
		}
	}

	
	

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop