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
			url_table_bentuk_tindakan = "{{ route('rt-sm21.get_bentuk_tindakan_table','') }}"+"/"+"{{$ikes->id}}";
			url_table_bentuk_terlibat = "{{ route('rt-sm21.get_bentuk_terlibat_table','') }}"+"/"+"{{$ikes->id}}";

		/* Maklumat Kes Dalam Krt */
			if("{{$ikes->hasRT}}" == 1){
				$('#apipn2_hasRT').attr("checked", "checked");
			}
			$('#apipn2_negeri_id').val("{{$ikes->krt_state_id}}");
			$('#apipn2_daerah_id').val("{{$ikes->krt_daerah_id}}");
			$('#apipn2_krt_profile_id').val("{{$ikes->krt_profile_id}}");

		/* Maklumat Pemohon */
			$('#apipn2_user_fullname').val("{{$ikes->nama_permohon}}");
			$('#apipn2_user_no_ic').val("{{$ikes->ic_pemohon}}");
			$('#apipn2_user_no_phone').val("{{$ikes->phone_pemohon}}");
			$('#apipn2_dihantar_alamat').val("{{$ikes->dihantar_alamat}}");

		/* Maklumat Kes Kejadian */
			if("{{$ikes->hasTindakan}}" == 1){
				$('#apipn2_hasTindakan').attr("checked", "checked");
			}

			$('#apipn2_ikes_keterangan_tindakan').val("{{$ikes->ikes_keterangan_tindakan}}");
        
			var senarai_bentuk_tindakan_table = $('#senarai_bentuk_tindakan_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_bentuk_tindakan,
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
						return full.tindakan_description;
					}
				},{       
					"aTargets": [ 2 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						$checked 	= (full.spk_ikes_tindakan_id) ? 'checked' : '';
						$button_a 	= '<label class="custom-control custom-checkbox">' +
									'<input class="custom-control-input" type="checkbox" id="chkp_1' + full.id + '" value="' + full.id + '" onchange="getIkesTindakan(&apos;' + full.id + '&apos;)" ' +
									$checked + ' disabled>' +
									'<span class="custom-control-label">&nbsp;</span></label>';
						return $button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			var senarai_pihak_terlibat_table = $('#senarai_pihak_terlibat_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url_table_bentuk_terlibat,
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
						return full.pihak_description;
					}
				},{       
					"aTargets": [ 2 ], 
					"width": "6%", 
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						$checked 	= (full.spk_ikes_terlibat_id) ? 'checked' : '';
						$button_a 	= '<label class="custom-control custom-checkbox">' +
									'<input class="custom-control-input" type="checkbox" id="chkp_2' + full.id + '" value="' + full.id + '" onchange="getIkesTerlibat(&apos;' + full.id + '&apos;)" ' +
									$checked + ' disabled>' +
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
                window.location.href = "{{route('rt-sm21.paparan_pelaporan_ikes_ts_p_1','')}}"+"/"+"{{$ikes->id}}";
            });

            $('#btn_next').click(function(){
                window.location.href = "{{ route('rt-sm21.paparan_pelaporan_ikes_ts_p_3','') }}"+"/"+"{{$ikes->id}}";
            });

	});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop