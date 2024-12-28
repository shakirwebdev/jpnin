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

</style>
<script type="text/javascript">    
    
	$(document).ready( function () {

		//my custom script
			url_table_bilangan_terlibat 		= "{{ route('rt-sm21.get_ikes_bilangan_terlibat','') }}"+"/"+"{{$ikes->id}}";
			url_table_bilangan_cedera 			= "{{ route('rt-sm21.get_ikes_bilangan_cedera','') }}"+"/"+"{{$ikes->id}}";
			url_table_bilangan_cedera_parah 	= "{{ route('rt-sm21.get_ikes_bilangan_cedera_parah','') }}"+"/"+"{{$ikes->id}}";
			url_table_bilangan_kematian 		= "{{ route('rt-sm21.get_ikes_bilangan_kematian','') }}"+"/"+"{{$ikes->id}}";

		/* Maklumat Kes Dalam Krt */
			if("{{$ikes->hasRT}}" == 1){
				$('#apipn1_hasRT').attr("checked", "checked");
			}
			$('#apipn1_negeri_id').val("{{$ikes->krt_state_id}}");
			$('#apipn1_daerah_id').val("{{$ikes->krt_daerah_id}}");
			$('#apipn1_krt_profile_id').val("{{$ikes->krt_profile_id}}");

		/* Maklumat Pemohon */
			$('#apipn1_user_fullname').val("{{$ikes->nama_permohon}}");
			$('#apipn1_user_no_ic').val("{{$ikes->ic_pemohon}}");
			$('#apipn1_user_no_phone').val("{{$ikes->phone_pemohon}}");
			$('#apipn1_dihantar_alamat').val("{{$ikes->dihantar_alamat}}");

		/* Maklumat Kes Kejadian */
			$('#apipn1_ikes_bil_terlibat').val("{{$ikes->ikes_bil_terlibat}}");
			$('#apipn1_status_etnik_id').val("{{$ikes->status_etnik_id}}");
			$('#apipn1_status_warganegara_id').val("{{$ikes->status_warganegara_id}}");
			$('#apipn1_ikes_bil_tangkapan').val("{{$ikes->ikes_bil_tangkapan}}");
        
			var senarai_jumlah_terlibat_table = $('#senarai_jumlah_terlibat_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_bilangan_terlibat,
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
						return full.kaum_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					"mRender": function ( value, type, full )  {
						return full.jumlah_bilangan_terlibat;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_jumlah_cedera_ringan_table = $('#senarai_jumlah_cedera_ringan_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_bilangan_cedera,
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
						return full.kaum_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					"mRender": function ( value, type, full )  {
						return full.jumlah_cedera_ringan;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_jumlah_cedera_parah_table = $('#senarai_jumlah_cedera_parah_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_bilangan_cedera_parah,
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
						return full.kaum_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					"mRender": function ( value, type, full )  {
						return full.jumlah_cedera_parah;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_jumlah_kematian_table = $('#senarai_jumlah_kematian_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_bilangan_kematian,
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
						return full.kaum_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					"mRender": function ( value, type, full )  {
						return full.jumlah_kematian;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{route('rt-sm21.semakan_permohonan_ikes_bpp','')}}"+"/"+"{{$ikes->id}}";
			});

			$('#btn_next').click(function(){
				window.location.href = "{{route('rt-sm21.semakan_permohonan_ikes_bpp_2','')}}"+"/"+"{{$ikes->id}}";
			});

	});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop