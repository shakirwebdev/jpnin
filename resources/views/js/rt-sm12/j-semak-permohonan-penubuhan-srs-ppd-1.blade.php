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

        /* Maklumat Kawasan Krt */
			$('#sppsp_1_nama_krt').html("{{$surat_penubuhan_srs->nama_krt}}");
			$('#sppsp_1_alamat_krt').html("{{$surat_penubuhan_srs->alamat_krt}}");
			$('#sppsp_1_negeri_krt').html("{{$surat_penubuhan_srs->negeri_krt}}");
			$('#sppsp_1_daerah_krt').html("{{$surat_penubuhan_srs->daerah_krt}}");
			$('#sppsp_1_parlimen_krt').html("{{$surat_penubuhan_srs->parlimen_krt}}");
			$('#sppsp_1_dun_krt').html("{{$surat_penubuhan_srs->dun_krt}}");
			$('#sppsp_1_pbt_krt').html("{{$surat_penubuhan_srs->pbt_krt}}");

		/* Maklumat Pemohon */
			$('#sppsp_1_nama_pemohon').val("{{$surat_penubuhan_srs->nama_pemohon}}");
			$('#sppsp_1_ic_pemohon').val("{{$surat_penubuhan_srs->ic_pemohon}}");
			$('#sppsp_1_address_pemohon').val("{{$surat_penubuhan_srs->address_pemohon}}");

		/* Maklumat Asas */
			$('#sppsp_1_nama_srs').val("{{$surat_penubuhan_srs->nama_srs}}");
			$('#sppsp_1_jumlah_peronda').val("{{$surat_penubuhan_srs->jumlah_peronda}}");
			var srs_kawalan = "{{$surat_penubuhan_srs->srs_kawalan}}";
			$("input[name=sppsp_1_srs_kawalan][value=" + srs_kawalan + "]").prop('checked', true);

		/* Maklumat Peronda */
			//my custom script
			url_senarai_peronda 	  = "{{ route('rt-sm12.get_senarai_peronda_table','') }}"+"/"+"{{$surat_penubuhan_srs->id}}";
			
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
				rowCallback: function(nRow, aData, index) {
					var info = senarai_peronda_table.page.info();
					$('td', nRow).eq(0).html(info.page * info.length + (index + 1));
				},
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
			url_senarai_peronda_sukarela 	   = "{{ route('rt-sm12.get_senarai_peronda_sukarela_table','') }}"+"/"+"{{$surat_penubuhan_srs->id}}";

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
				rowCallback: function(nRow, aData, index) {
					var info = senarai_peronda_sukarela_table.page.info();
					$('td', nRow).eq(0).html(info.page * info.length + (index + 1));
				},
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

		/* Maklumat Note Kemaskini */
			$('#sppsp_status').val("{{$surat_penubuhan_srs->srs_status}}");
				
			if($('#sppsp_status').val() == '8'){
				$("#sppsp_perlu_kemaskini").show();
				$('#sppsp_status_description').html("{{$surat_penubuhan_srs->status_description}}");
				$('#sppsp_disahkan_note').html("{{$surat_penubuhan_srs->disahkan_note}}");
			}
	    

		$('#btn_back').click(function(){
			window.location.href = "{{route('rt-sm12.semak_permohonan_penubuhan_srs_ppd','')}}"+"/"+{{$surat_penubuhan_srs->id}};
		});

		$('#btn_next').click(function(){
			window.location.href = "{{route('rt-sm12.semak_permohonan_penubuhan_srs_ppd_2','')}}"+"/"+{{$surat_penubuhan_srs->id}};
		});

	});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop