@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<style>
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

		//my custom script
			url = "{{ route('rt-sm13.get_senarai_pendidikan_table','') }}"+"/"+"{{$srs_ahli_peronda->id}}";

		/* Maklumat Kawasan Krt */
			$('#apspd_nama_krt').html("{{$srs_ahli_peronda->nama_krt}}");
			$('#apspd_alamat_krt').html("{{$srs_ahli_peronda->alamat_krt}}");
			$('#apspd_negeri_krt').html("{{$srs_ahli_peronda->negeri_krt}}");
			$('#apspd_daerah_krt').html("{{$srs_ahli_peronda->daerah_krt}}");
			$('#apspd_parlimen_krt').html("{{$srs_ahli_peronda->parlimen_krt}}");
			$('#apspd_dun_krt').html("{{$srs_ahli_peronda->dun_krt}}");
			$('#apspd_pbt_krt').html("{{$srs_ahli_peronda->pbt_krt}}");

		/* Maklumat Pemohonan Ahli Peronda SRS */
			$('#apspd_ajk_gambar').attr('src', "{{ asset('storage/ahli_peronda_srs') }}"+"/"+ "{{$srs_ahli_peronda->file_gambar_profile}}");
			$('#apspd_srs_profile_id').val("{{$srs_ahli_peronda->srs_profile_id}}");
			$('#apspd_peronda_nama').val("{{$srs_ahli_peronda->peronda_nama}}");
			$('#apspd_peronda_tarikh_lahir').val("{{$srs_ahli_peronda->peronda_tarikh_lahir}}");
			$('#apspd_peronda_kaum').val("{{$srs_ahli_peronda->peronda_kaum}}");
			$('#apspd_peronda_jantina').val("{{$srs_ahli_peronda->peronda_jantina}}");
			$('#apspd_peronda_warganegara').val("{{$srs_ahli_peronda->peronda_warganegara}}");
			$('#apspd_peronda_agama').val("{{$srs_ahli_peronda->peronda_agama}}");
			$('#apspd_peronda_ic').val("{{$srs_ahli_peronda->peronda_ic}}");
			$('#apspd_peronda_alamat').val("{{$srs_ahli_peronda->peronda_alamat}}");
			$('#apspd_peronda_poskod').val("{{$srs_ahli_peronda->peronda_poskod}}");
			$('#apspd_peronda_phone').val("{{$srs_ahli_peronda->peronda_phone}}");
			$('#apspd_peronda_tarikh_lantikan').val("{{$srs_ahli_peronda->peronda_tarikh_lantikan}}");
			$('#apspd_srs_ahli_peronda_id').val("{{$srs_ahli_peronda->id}}");

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
					sClass: 'text-center',
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
				window.location.href = '{{route('rt-sm13.senarai_ahli_peronda_srs_ppd')}}';
			});

			$('#btn_next').click(function(){
				window.location.href = '{{route('rt-sm13.senarai_ahli_peronda_srs_ppd_2','')}}'+'/'+'{{$srs_ahli_peronda->id}}';
			});

	});

	function getPendidikan(id) {
		//checked
		if ($('#chkp_1' + id).is(':checked')) {
			// alert('checked');
			var apspd_srs_ahli_peronda_id = $('#apspd_srs_ahli_peronda_id').val();
			url_add_pendidikan = "{{ route('rt-sm13.add_pendidikan') }}";
			type = "POST";
			$.ajax({
				url: url_add_pendidikan,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"apspd_srs_ahli_peronda_id": apspd_srs_ahli_peronda_id,
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