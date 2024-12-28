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

</style>
<script type="text/javascript">    
    
	$(document).ready( function () {

		//my custom script
			url_table_pihak_terlibat		= "{{ route('rt-sm23.get_laporan_mediasi_terlibat_table','') }}"+"/"+"{{$laporan_mediasi->id}}";
			
        /* Maklumat Mediator */
			$('#lkmu_mkp_nama').val("{{$laporan_mediasi->mkp_nama}}");
			$('#lkmu_mkp_no_ic').val("{{$laporan_mediasi->mkp_no_ic}}");
			$('#lkmu_mkp_no_phone').val("{{$laporan_mediasi->mkp_no_phone}}");

		/* Maklumat Pembantu Mediator */
			$('#lkmu_mediasi_pembantu_nama').val("{{$laporan_mediasi->mediasi_pembantu_nama}}");
			$('#lkmu_mediasi_pembantu_ic').val("{{$laporan_mediasi->mediasi_pembantu_ic}}");
			$('#lkmu_mediasi_pembantu_phone').val("{{$laporan_mediasi->mediasi_pembantu_phone}}");

        /* Maklumat Status Semakan */
            $('#lkmu_imediator_mediasi_id').val("{{$laporan_mediasi->id}}");
            $('#lkmu_disahkan_note').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

		/* Maklumat Kes Mediasi */
			$('#lkmu2_mediasi_alamat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

			var senarai_pihak_terlibat_table = $('#senarai_pihak_terlibat_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_pihak_terlibat,
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
					"width": "44%", 
					"mRender": function ( value, type, full )  {
						return full.pihak_pertama;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "44%", 
					"mRender": function ( value, type, full )  {
						return full.pihak_kedua;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
			
            $('#lkmu_ref_mkp_kategori_id').val("{{$laporan_mediasi->ref_mkp_kategori_id}}");
			$('#lkmu_mediasi_tarikh').val("{{$laporan_mediasi->mediasi_tarikh}}");
			$('#lkmu_mediasi_alamat').val("{{$laporan_mediasi->mediasi_alamat}}");
			$('#lkmu_mediasi_ngo_terlibat').val("{{$laporan_mediasi->mediasi_ngo_terlibat}}");
			$('#lkmu_mediasi_ringkasan_kes').val("{{$laporan_mediasi->mediasi_ringkasan_kes}}");
			$('#lkmu_mediasi_status_kes').val("{{$laporan_mediasi->mediasi_status_kes}}");
			if($('#lkmu_mediasi_status_kes').val() == 'Berjaya'){
				$("#mediasi_note_penyelesaian_kes").show();
				$("#mediasi_note_sebab_kes_xberjaya").hide();
			}else if($('#lkmu_mediasi_status_kes').val() == 'Tidak Berjaya'){
				$("#mediasi_note_penyelesaian_kes").hide();
				$("#mediasi_note_sebab_kes_xberjaya").show();
			}
			$('#lkmu_mediasi_note_penyelesaian_kes').val("{{$laporan_mediasi->mediasi_note_penyelesaian_kes}}");
			$('#lkmu_mediasi_note_sebab_kes_xberjaya').val("{{$laporan_mediasi->mediasi_note_sebab_kes_xberjaya}}");

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm23.senarai_laporan_kes_upmk') }}";
			});

	});

    
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
@stop