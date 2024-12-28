@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<style type="text/css">
	.avatar {
        vertical-align: middle;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        border-color: black;
    }
</style>
<script type="text/javascript">    
    
	$(document).ready( function () {

		/* Maklumat Kawasan Krt */
			$('#spapsp_nama_krt').html("{{$srs_ahli_peronda->nama_krt}}");
			$('#spapsp_alamat_krt').html("{{$srs_ahli_peronda->alamat_krt}}");
			$('#spapsp_negeri_krt').html("{{$srs_ahli_peronda->negeri_krt}}");
			$('#spapsp_daerah_krt').html("{{$srs_ahli_peronda->daerah_krt}}");
			$('#spapsp_parlimen_krt').html("{{$srs_ahli_peronda->parlimen_krt}}");
			$('#spapsp_dun_krt').html("{{$srs_ahli_peronda->dun_krt}}");
			$('#spapsp_pbt_krt').html("{{$srs_ahli_peronda->pbt_krt}}");

		/* Maklumat Pemohonan Ahli Peronda SRS */
			$('#spapsp_ajk_gambar').attr('src', "{{ asset('storage/ahli_peronda_srs') }}"+"/"+ "{{$srs_ahli_peronda->file_gambar_profile}}");
			$('#spapsp_srs_profile_id').val("{{$srs_ahli_peronda->srs_profile_id}}");
			$('#spapsp_peronda_nama').val("{{$srs_ahli_peronda->peronda_nama}}");
			$('#spapsp_peronda_tarikh_lahir').val("{{$srs_ahli_peronda->peronda_tarikh_lahir}}");
			$('#spapsp_peronda_kaum').val("{{$srs_ahli_peronda->peronda_kaum}}");
			$('#spapsp_peronda_jantina').val("{{$srs_ahli_peronda->peronda_jantina}}");
			$('#spapsp_peronda_warganegara').val("{{$srs_ahli_peronda->peronda_warganegara}}");
			$('#spapsp_peronda_agama').val("{{$srs_ahli_peronda->peronda_agama}}");
			$('#spapsp_peronda_ic').val("{{$srs_ahli_peronda->peronda_ic}}");
			$('#spapsp_peronda_alamat').val("{{$srs_ahli_peronda->peronda_alamat}}");
			$('#spapsp_peronda_poskod').val("{{$srs_ahli_peronda->peronda_poskod}}");
			$('#spapsp_peronda_phone').val("{{$srs_ahli_peronda->peronda_phone}}");
			$('#spapsp_peronda_tarikh_lantikan').val("{{$srs_ahli_peronda->peronda_tarikh_lantikan}}");
			$('#spapsp_srs_ahli_peronda_id').val("{{$srs_ahli_peronda->id}}");

			url = "{{ route('rt-sm13.get_senarai_pendidikan_table','') }}"+"/"+"{{$srs_ahli_peronda->id}}";
        
			var senarai_pendidikan_table = $('#senarai_pendidikan_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: url,
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
						return full.pendidikan_description;
					}
				},{       
					"aTargets": [ 2 ], 
					"width": "6%", 
					"mRender": function ( value, type, full )  {
						$checked 	= (full.srs_ahli_peronda_pendidikanID) ? 'checked' : '';
						$button_a 	= '<label class="custom-control custom-checkbox">' +
									'<input class="custom-control-input" type="checkbox" id="chkp_1' + full.id + '" value="' + full.id + '" onchange="getPendidikan(&apos;' + full.id + '&apos;)" ' +
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
				window.location.href = '{{route('rt-sm13.semak_pendaftaran_ahli_peronda_srs_ppd')}}';
			});

			$('#btn_next').click(function(){
				window.location.href = '{{route('rt-sm13.semak_pendaftaran_ahli_peronda_srs_ppd_2','')}}'+'/'+'{{$srs_ahli_peronda->id}}';
			});

	});

	function getPendidikan(id) {
		//checked
		if ($('#chkp_1' + id).is(':checked')) {
			// alert('checked');
			var spapsp_srs_ahli_peronda_id = $('#spapsp_srs_ahli_peronda_id').val();
			url_add_pendidikan = "{{ route('rt-sm13.add_pendidikan') }}";
			type = "POST";
			$.ajax({
				url: url_add_pendidikan,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"spapsp_srs_ahli_peronda_id": spapsp_srs_ahli_peronda_id,
						"srs_ahli_peronda_pendidikanID": id
						}
			});
		}

		//unchecked
		if (!$('#chkp_1' + id).is(':checked')) {
			// alert('unchecked');
			url_delete_pendidikan 	= "{{ route('rt-sm13.delete_pendidikan','') }}";
			$.ajax({
				type: "GET",
				url: url_delete_pendidikan +"/" + id,
			});
			
		}
	}

	

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop