@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {

		/* Maklumat Kawasan Krt */
			$('#aps1_nama_krt').html("{{$srs_ahli_peronda->nama_krt}}");
			$('#aps1_alamat_krt').html("{{$srs_ahli_peronda->alamat_krt}}");
			$('#aps1_negeri_krt').html("{{$srs_ahli_peronda->negeri_krt}}");
			$('#aps1_parlimen_krt').html("{{$srs_ahli_peronda->daerah_krt}}");
			$('#aps1_pbt_krt').html("{{$srs_ahli_peronda->parlimen_krt}}");
			$('#aps1_daerah_krt').html("{{$srs_ahli_peronda->dun_krt}}");
			$('#aps1_dun_krt').html("{{$srs_ahli_peronda->pbt_krt}}");

		/* Maklumat Pemohonan Ahli Peronda SRS */
			$('#aps1_srs_ahli_peronda_id').val("{{$srs_ahli_peronda->id}}");
			$('#aps1_peronda_status').val("{{$srs_ahli_peronda->peronda_status}}");

			url = "{{ route('rt-sm13.get_senarai_pekerjaan_srs_table','') }}"+"/"+"{{$srs_ahli_peronda->id}}";
		
			var senarai_pekerjaan_srs_table = $('#senarai_pekerjaan_srs_table').DataTable( {
				processing: true,
				serverSide: true,
				"pageLength": 50,
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
				rowCallback: function(nRow, aData, index) {
					var info = senarai_pekerjaan_srs_table.page.info();
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
						return full.profession_description;
					}
				},{       
					"aTargets": [ 2 ], 
					"width": "6%", 
					"mRender": function ( value, type, full )  {
						$checked 	= (full.srs_ahli_peronda_pekerjaanID) ? 'checked' : '';
						$button_a 	= '<label class="custom-control custom-checkbox">' +
									'<input class="custom-control-input" type="checkbox" id="chkp_1' + full.id + '" value="' + full.id + '" onchange="getPekerjaan(&apos;' + full.id + '&apos;)" ' +
									$checked + '>' +
									'<span class="custom-control-label">&nbsp;</span></label>';
						return $button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			$('#aps2_srs_ahli_peronda_id').val("{{$srs_ahli_peronda->id}}");
		
		/* Button */

			$('#btn_back').click(function(){
				window.location.href = "{{route('rt-sm13.ahli_peronda_srs','')}}"+"/"+{{$srs_ahli_peronda->id}};
			});

	});

	function getPekerjaan(id) {
		//checked
		if ($('#chkp_1' + id).is(':checked')) {
			// alert('checked');
			var aps1_srs_ahli_peronda_id = $('#aps1_srs_ahli_peronda_id').val();
			url_add_pekerjaan_srs = "{{ route('rt-sm13.add_pekerjaan_srs') }}";
			type = "POST";
			$.ajax({
				url: url_add_pekerjaan_srs,
				type: type,
				data: {
						"_token": "{{ csrf_token() }}",
						"aps1_srs_ahli_peronda_id": aps1_srs_ahli_peronda_id,
						"srs_ahli_peronda_pekerjaanID": id
						}
			});
		}

		//unchecked
		if (!$('#chkp_1' + id).is(':checked')) {
			// alert('unchecked');
			url_delete_pekerjaan_srs 	= "{{ route('rt-sm13.delete_pekerjaan_srs','') }}";
			$.ajax({
				type: "GET",
				url: url_delete_pekerjaan_srs +"/" + id,
			});
			
		}
	}

	/* Submit Ahli peronda */
		//my custom script
		var update_ahli_peronda_srs_1_config = {
			routes: {
				update_ahli_peronda_srs_1_url: "{{ route('rt-sm13.post_ahli_peronda_srs_1') }}",
			}
		};

		$(document).on('submit', '#form_aps2', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data = $("#form_aps1, #form_aps2").serialize();
			var action = $('#post_ahli_peronda_srs_1').val();
			var btn_text;
			if (action == 'edit') {
				url = update_ahli_peronda_srs_1_config.routes.update_ahli_peronda_srs_1_url;
				type = "POST";
				btn_text = 'Kemaskini Maklumat Ahli Peronda&nbsp;&nbsp;<i class="dropdown-icon fa fa-plus"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=aps1_peronda_status]').removeClass("is-invalid");

				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'aps1_peronda_status') {
							$('[name=aps1_peronda_status]').addClass("is-invalid");
							$('.error_aps1_peronda_status').html(error);
						}

					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm13.senarai_ahli_peronda_srs')}}";
				}
			});
		});
	
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop