@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {
		//my custom script
			url_table_peta_kawasan 			= "{{ route('rt-sm1.get_peta_kawasan_table','') }}"+"/"+"{{$profile_krt->id}}";
			url_kemudahan_awam_table 		= "{{ route('rt-sm1.get_kawasan_pertanian_table','') }}"+"/"+"{{$profile_krt->id}}";

		/* Maklumat KRT Yang Dimohon */
			$('#kpk_krt_nama').html("{{$profile_krt->krt_nama}}");
			$('#kpk_krt_alamat').html("{{$profile_krt->krt_alamat}}");
			$('#kpk_tarikh_memohon').html("{{$profile_krt->created_at}}");

		/* Maklumat Pemohon */
			$('#kpk_pemohon_name').val("{{$profile_krt->user_fullname}}");
			$('#kpk_pemohon_ic').val("{{$profile_krt->no_ic}}");
			$('#kpk_pemohon_alamat').val("{{$profile_krt->user_address}}");

		/* Maklumat Asas Kawasan */
			var senarai_peta_kawasan_table = $('#senarai_peta_kawasan_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_peta_kawasan,
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
						return full.file_title;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "30%", 
					"mRender": function ( value, type, full )  {
						return full.file_catatan;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "30%", 
					"mRender": function ( value, type, full )  {
						return full.file_peta;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Download Fail Peta Kawasan" id="download_peta_kawasan" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-download"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
		
			var kawasan_pertanian_table = $('#kawasan_pertanian_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_kemudahan_awam_table,
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
					"width": "40%", 
					"mRender": function ( value, type, full )  {
						return full.pertanian_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "27%", 
					"mRender": function ( value, type, full )  {
						return full.kawasan_pertanian_dalam;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "27%", 
					"mRender": function ( value, type, full )  {
						return full.kawasan_pertanian_luar;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{route('rt-sm1.pengesahan_permohonan_krt_ppn_2','')}}"+"/"+"{{$profile_krt->id}}";
			});

			$('#btn_next').click(function(){
				window.location.href = "{{route('rt-sm1.pengesahan_permohonan_krt_ppn_5','')}}"+"/"+"{{$profile_krt->id}}";
			});

	});

	/* click download peta kawasan */
		//my custom script
		var download_peta_kawasan_config = {
			routes: {
				download_peta_kawasan_url: "{{ route('rt-sm1.get_peta_kawasan','') }}",
			}
		};

		$('body').on('click', '#download_peta_kawasan', function () {
			var download_id = $(this).data("id");
			$.get(download_peta_kawasan_config.routes.download_peta_kawasan_url + '/' + download_id, function (data) {
				let link = document.createElement("a");
				link.download = data.file_peta;
				link.href = "{{ asset('storage/peta_kawasan') }}"+"/"+ data.file_peta ;
				link.click();
			});
		});
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop