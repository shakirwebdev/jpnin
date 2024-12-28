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
			url_table_peta_kawasan 		= "{{ route('rt-sm12.get_profile_srs_peta_kawasan_table','') }}"+"/"+"{{$profile_srs->id}}";

		/* Maklumat Kawasan Krt */
			$('#psp_2_nama_krt').html("{{$profile_srs->nama_krt}}");
			$('#psp_2_alamat_krt').html("{{$profile_srs->alamat_krt}}");
			$('#psp_2_negeri_krt').html("{{$profile_srs->negeri_krt}}");
			$('#psp_2_daerah_krt').html("{{$profile_srs->daerah_krt}}");
			$('#psp_2_parlimen_krt').html("{{$profile_srs->parlimen_krt}}");
			$('#psp_2_dun_krt').html("{{$profile_srs->dun_krt}}");
			$('#psp_2_pbt_krt').html("{{$profile_srs->pbt_krt}}");

		/* Maklumat Pemohon */
			$('#psp_2_nama_pemohon').val("{{$profile_srs->nama_pemohon}}");
			$('#psp_2_ic_pemohon').val("{{$profile_srs->ic_pemohon}}");
			$('#psp_2_address_pemohon').val("{{$profile_srs->address_pemohon}}");

		/* Maklumat Minit Meeting */
			url_senarai_minit_meeting_table 	= "{{ route('rt-sm12.get_senarai_minit_meeting_table','') }}"+"/"+"{{$profile_srs->id}}";

			var senarai_minit_meeting_table = $('#senarai_minit_meeting_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_senarai_minit_meeting_table,
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
					var info = senarai_minit_meeting_table.page.info();
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
						return full.mesyuarat_title;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "28%", 
					"mRender": function ( value, type, full )  {
						return full.keterangan;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%",
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Cetak Minit Mesyuarat JawatanKuasa" target="_blank" onclick="print_minit_mesyuarat(\'' + full.minit_mesyuarat_id + '\');"><i class="fa fa-print"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

		/* Maklumat Pelan Lakar */
			var senarai_peta_kawasan_srs_table = $('#senarai_peta_kawasan_srs_table').DataTable( {
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

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{route('rt-sm12.profile_srs_p_1','')}}"+"/"+"{{$profile_srs->id}}";
			});

	});

	/* click button print minit meeting */
		function print_minit_mesyuarat(id){
			window.location.href = "{{route('pdf.minit_mesyuarat','')}}"+"/"+id;
		}

	/* click download peta kawasan */
		//my custom script
		var download_peta_kawasan_config = {
			routes: {
				download_peta_kawasan_url: "{{ route('rt-sm12.get_data_srs_peta_kawasan','') }}",
			}
		};

		$('body').on('click', '#download_peta_kawasan', function () {
			var download_id = $(this).data("id");
			$.get(download_peta_kawasan_config.routes.download_peta_kawasan_url + '/' + download_id, function (data) {
				let link = document.createElement("a");
				link.download = data.file_peta;
				link.href = "{{ asset('storage/srs_peta_kawasan') }}"+"/"+ data.file_peta ;
				link.click();
			});
		});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop