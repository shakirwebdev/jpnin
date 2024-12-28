@section('page-script')
@include('js.modal.j-modal-view-binaan-jambatan')
@include('js.modal.j-modal-view-bagunan-tumpang')
@include('js.modal.j-modal-view-bagunan-sewa')
@include('js.modal.j-modal-view-kabin-sedia-ada')
@include('js.modal.j-modal-view-cadangan-pembinaan-prt')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {

		//my custom script
			url_table_senarai_binaan 			= "{{ route('rt-sm2.get_profile_krt_senarai_binaan','') }}"+"/"+"{{$profile_krt->id}}";
			url_table_bagunan_tumpang			= "{{ route('rt-sm2.get_profile_krt_bagunan_tumpang','') }}"+"/"+"{{$profile_krt->id}}";
			url_table_bagunan_sewa				= "{{ route('rt-sm2.get_profile_krt_bagunan_sewa','') }}"+"/"+"{{$profile_krt->id}}";
			url_table_senarai_kabin 			= "{{ route('rt-sm2.get_profile_krt_senarai_kabin','') }}"+"/"+"{{$profile_krt->id}}";
			url_table_cadangan_pembinaan 		= "{{ route('rt-sm2.get_profile_krt_cadangan_pembinaan','') }}"+"/"+"{{$profile_krt->id}}";

		/* Maklumat Am Krt */
			$('#kpk_krt_nama').html("{{$profile_krt->krt_nama}}");
			$('#kpk_krt_alamat').html("{{$profile_krt->krt_alamat}}");
			$('#kpk_tarikh_memohon').html("{{$profile_krt->created_at}}");

		/* Maklumat Asas Kawasan */
			var senarai_binaan_jambatan_table = $('#senarai_binaan_jambatan_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_senarai_binaan,
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
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.jenis_premis_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.binaan_alamat;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.binaan_isu;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_binaan_jambatan(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_bagunan_tumpang_table = $('#senarai_bagunan_tumpang_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_bagunan_tumpang,
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
					"width": "38%", 
					"mRender": function ( value, type, full )  {
						return full.jenis_premis_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "50%", 
					"mRender": function ( value, type, full )  {
						return full.tumpang_alamat;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_bagunan_tumpang(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_bagunan_sewa_table = $('#senarai_bagunan_sewa_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_bagunan_sewa,
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
					"width": "38%", 
					"mRender": function ( value, type, full )  {
						return full.jenis_premis_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "50%", 
					"mRender": function ( value, type, full )  {
						return full.sewa_alamat;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_bagunan_sewa(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_kabin_table = $('#senarai_kabin_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_senarai_kabin,
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
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.jenis_kabin;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.kabin_alamat;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.kabin_kos;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_kabin(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_cadangan_pembinaan_table = $('#senarai_cadangan_pembinaan_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_cadangan_pembinaan,
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
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						jenis_premis = '';
						if (full.prt_jenis_premis == '1') {
							jenis_premis = 'Kompleks Perpaduan';
						} else if (full.prt_jenis_premis == '2') {
							jenis_premis = 'Pusat Rukun Tetangga';
						}
						return jenis_premis;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.prt_status_tanah_terkini;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.prt_cadangan_tahun;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_cadangan_pembinaan_prt(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
		
		/* Buuton */
			$('#btn_back').click(function(){
				window.location.href = "{{route('rt-sm2.profile_krt_hqrt_4','')}}"+"/"+"{{$profile_krt->id}}";
			});

			$('#btn_next').click(function(){
				window.location.href = "{{route('rt-sm2.profile_krt_hqrt_6','')}}"+"/"+"{{$profile_krt->id}}";
			});
        
    	

	});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop