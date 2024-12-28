@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {

		/* Maklumat Kawasan Krt */
			$('#kppsh_1_nama_krt').html("{{$kelulusan_penubuhan_srs->nama_krt}}");
			$('#kppsh_1_alamat_krt').html("{{$kelulusan_penubuhan_srs->alamat_krt}}");
			$('#kppsh_1_negeri_krt').html("{{$kelulusan_penubuhan_srs->negeri_krt}}");
			$('#kppsh_1_daerah_krt').html("{{$kelulusan_penubuhan_srs->daerah_krt}}");
			$('#kppsh_1_parlimen_krt').html("{{$kelulusan_penubuhan_srs->parlimen_krt}}");
			$('#kppsh_1_dun_krt').html("{{$kelulusan_penubuhan_srs->dun_krt}}");
			$('#kppsh_1_pbt_krt').html("{{$kelulusan_penubuhan_srs->pbt_krt}}");

		/* Maklumat Pemohon */
			$('#kppsh_1_nama_pemohon').val("{{$kelulusan_penubuhan_srs->nama_pemohon}}");
			$('#kppsh_1_ic_pemohon').val("{{$kelulusan_penubuhan_srs->ic_pemohon}}");
			$('#kppsh_1_address_pemohon').val("{{$kelulusan_penubuhan_srs->address_pemohon}}");

		/* Maklumat Asas */
			$('#kppsh_1_nama_srs').val("{{$kelulusan_penubuhan_srs->nama_srs}}");
			$('#kppsh_1_jumlah_peronda').val("{{$kelulusan_penubuhan_srs->jumlah_peronda}}");
			var srs_kawalan = "{{$kelulusan_penubuhan_srs->srs_kawalan}}";
			$("input[name=kppsh_1_srs_kawalan][value=" + srs_kawalan + "]").prop('checked', true);

		/* Maklumat Peronda */
			//my custom script
			url_senarai_peronda 	  = "{{ route('rt-sm12.get_senarai_peronda_table','') }}"+"/"+"{{$kelulusan_penubuhan_srs->id}}";
			
			var senarai_peronda_table = $('#senarai_peronda_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_senarai_peronda,
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
					"width": "60%", 
					"mRender": function ( value, type, full )  {
						return full.peronda_nama;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					"mRender": function ( value, type, full )  {
						return full.peronda_kad;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

		/* Maklumat Peronda Sukarela */
			//my custom script
			url_senarai_peronda_sukarela 	   = "{{ route('rt-sm12.get_senarai_peronda_sukarela_table','') }}"+"/"+"{{$kelulusan_penubuhan_srs->id}}";

			var senarai_peronda_sukarela_table = $('#senarai_peronda_sukarela_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_senarai_peronda_sukarela,
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
					"width": "10%", 
					"mRender": function ( value, type, full )  {
						return full.p_sukarela_nama;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "10%", 
					"mRender": function ( value, type, full )  {
						return full.p_sukarela_kad;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "10%", 
					"mRender": function ( value, type, full )  {
						return full.jantina_description;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "10%", 
					"mRender": function ( value, type, full )  {
						return full.p_sukarela_pekerjaan;
					}
				},{          
					"aTargets": [ 5 ], 
					"width": "10%", 
					"mRender": function ( value, type, full )  {
						return full.p_sukarela_alamat_k;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
        
		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{route('rt-sm12.kelulusan_permohonan_penubuhan_srs_hq','')}}"+"/"+{{$kelulusan_penubuhan_srs->id}};
			});

			$('#btn_next').click(function(){
				window.location.href = "{{route('rt-sm12.kelulusan_permohonan_penubuhan_srs_hq_2','')}}"+"/"+{{$kelulusan_penubuhan_srs->id}};
			});

	});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop