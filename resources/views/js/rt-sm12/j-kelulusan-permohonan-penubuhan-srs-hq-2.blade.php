@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {

		//my custom script
			url_senarai_minit_meeting_table 	= "{{ route('rt-sm12.get_senarai_minit_meeting_table','') }}"+"/"+"{{$kelulusan_penubuhan_srs->id}}";
			url_table_peta_kawasan 		= "{{ route('rt-sm12.get_profile_srs_peta_kawasan_table','') }}"+"/"+"{{$kelulusan_penubuhan_srs->id}}";


		/* Maklumat Kawasan Krt */
			$('#kppsh_2_nama_krt').html("{{$kelulusan_penubuhan_srs->nama_krt}}");
			$('#kppsh_2_alamat_krt').html("{{$kelulusan_penubuhan_srs->alamat_krt}}");
			$('#kppsh_2_negeri_krt').html("{{$kelulusan_penubuhan_srs->negeri_krt}}");
			$('#kppsh_2_daerah_krt').html("{{$kelulusan_penubuhan_srs->daerah_krt}}");
			$('#kppsh_2_parlimen_krt').html("{{$kelulusan_penubuhan_srs->parlimen_krt}}");
			$('#kppsh_2_dun_krt').html("{{$kelulusan_penubuhan_srs->dun_krt}}");
			$('#kppsh_2_pbt_krt').html("{{$kelulusan_penubuhan_srs->pbt_krt}}");

		/* Maklumat Pemohon */
			$('#kppsh_2_nama_pemohon').val("{{$kelulusan_penubuhan_srs->nama_pemohon}}");
			$('#kppsh_2_ic_pemohon').val("{{$kelulusan_penubuhan_srs->ic_pemohon}}");
			$('#kppsh_2_address_pemohon').val("{{$kelulusan_penubuhan_srs->address_pemohon}}");

		/* Maklumat Status Kelulusan */
			$('#kppsh_2_srs_id').val("{{$kelulusan_penubuhan_srs->id}}");

    	/* Maklumat Minit Meeting */
			
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
				window.location.href = "{{route('rt-sm12.kelulusan_permohonan_penubuhan_srs_hq_1','')}}"+"/"+"{{$kelulusan_penubuhan_srs->id}}";
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

	/* Button Hantar Kelulusan */
		//my custom script
		var kelulusan_penubuhan_srs_config = {
			routes: {
				kelulusan_penubuhan_action_url: "{{ route('rt-sm12.post_kelulusan_permohonan_penubuhan_srs') }}",
			}
		};

		$(document).on('submit', '#form_kppsh_2', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data = $("#form_kppsh_2").serialize();
			var action = $('#post_kelulusan_permohonan_penubuhan_srs').val();
			var btn_text;
			if (action == 'edit') {
				url = kelulusan_penubuhan_srs_config.routes.kelulusan_penubuhan_action_url;
				type = "POST";
				btn_text = 'Hantar &nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=kppsh_2_srs_status]').removeClass("is-invalid");
				$('[name=kppsh_2_diluluskan_note]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'kppsh_2_srs_status') {
							$('[name=kppsh_2_srs_status]').addClass("is-invalid");
							$('.error_kppsh_2_srs_status').html(error);
						}

						if(index == 'kppsh_2_diluluskan_note') {
							$('[name=kppsh_2_diluluskan_note]').addClass("is-invalid");
							$('.error_kppsh_2_diluluskan_note').html(error);
						}

					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm12.kelulusan_permohonan_penubuhan_srs')}}";
				}
			});
		});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop