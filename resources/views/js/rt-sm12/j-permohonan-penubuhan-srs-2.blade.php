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
		/* Maklumat Kawasan Krt */
			$('#pps6_nama_krt').html("{{$srs_profile->nama_krt}}");
			$('#pps6_alamat_krt').html("{{$srs_profile->alamat_krt}}");
			$('#pps6_negeri_krt').html("{{$srs_profile->negeri_krt}}");
			$('#pps6_parlimen_krt').html("{{$srs_profile->parlimen_krt}}");
			$('#pps6_pbt_krt').html("{{$srs_profile->pbt_krt}}");
			$('#pps6_daerah_krt').html("{{$srs_profile->daerah_krt}}");
			$('#pps6_dun_krt').html("{{$srs_profile->dun_krt}}");
		
		/* Maklumat Pemohon */
			$('#pps6_pemohon_name').val("{{$user_profile->pemohon_name}}");
			$('#pps6_pemohon_ic').val("{{$user_profile->pemohon_ic}}");
			$('#pps6_pemohon_address').val("{{$user_profile->pemohon_address}}");

		/* Maklumat Minit Meeting */
			$('#pps7_keterangan').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
			$('#pps7_keterangan').on("paste",function(e) {
                e.preventDefault();
            });

			$('#pps7_srs_profile_id').val("{{$srs_profile->id}}");
			//my custom script
			url_senarai_minit_meeting_table 	= "{{ route('rt-sm12.get_senarai_minit_meeting_table','') }}"+"/"+"{{$srs_profile->id}}";
			url_senarai_minit_meeting_delete  	= "{{ route('rt-sm12.delete_senarai_minit_meeting','') }}";

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
						button_a = '<button type="button" class="btn btn-icon" title="Cetak Minit Mesyuarat JawatanKuasa" target="_blank" onclick="print_minit_mesyuarat(\'' + full.id + '\');"><i class="fa fa-print"></i></button>';
						button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_minit_meeting" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a + button_b;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

		/* Maklumat Note Kemaskini */
			$('#pps_status').val("{{$srs_profile->srs_status}}");
				
			if($('#pps_status').val() == '6'){
				$("#pps_perlu_kemaskini").show();
				$('#pps_status_description').html("{{$srs_profile->status_description}}");
				$('#pps_disemak_note').html("{{$srs_profile->disemak_note}}");
			}

		/* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{route('rt-sm12.permohonan_penubuhan_srs_1','')}}"+"/"+{{$srs_profile->id}};
			});

		$('#srs_profile_id').val("{{$srs_profile->id}}");
        
    });

	/* click add minit meeting */
	$(document).on('submit', '#form_pps7', function(event){
		var info = $('.error_alert_pps7');
		event.preventDefault();

		$('#btn_add_minit_meeting').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
		$('#btn_add_minit_meeting').prop('disabled', true);

		var data = $("#form_pps7").serialize();
		btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
		url = "{{ route('rt-sm12.post_minit_meeting') }}";
		type = "POST";

		$.ajax({
			url: url,
			type: type,
			data: data,
		}).done(function(response) {            
			info.hide().find('ul').empty();
			if(response.errors){
				$.each(response.errors, function(index, error){
					info.find('ul').append('<li>'+error+'</li>');
				});
				$('#btn_add_minit_meeting').html(btn_text);                
				$('#btn_add_minit_meeting').prop('disabled', false);
				info.slideDown();
			} else {
				swal("Senarai Minit Meeting ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
				$('#form_pps7').trigger("reset");
				$('#btn_add_minit_meeting').html(btn_text);
				$('#btn_add_minit_meeting').prop('disabled', false);
				$('#senarai_minit_meeting_table').DataTable().ajax.reload();
			}
		});
	});

	/* click button print minit meeting */
	function print_minit_mesyuarat(id){
        window.location.href = "{{route('pdf.minit_mesyuarat','')}}"+"/"+id;
	}

	/* click delete minit meeting */
	$('body').on('click', '#delete_minit_meeting', function () {
		var delete_id = $(this).data("id");
		swal({
			title: "Anda pasti?",
			text: "Anda akan memadam rekod ini dari pangkalan data!",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#dc3545",
			confirmButtonText: "Ya, sila padam!",
			cancelButtonText: "Tidak",
			closeOnConfirm: false,
			closeOnCancel: false
		}, function (isConfirm) {
			if (isConfirm) {
				$.ajax({
					type: "GET",
					url: url_senarai_minit_meeting_delete +"/" + delete_id,
					success: function (data) {
						// $('#peranan_form').trigger("reset");
						$('#senarai_minit_meeting_table').DataTable().ajax.reload();
						swal("Sudah dipadam!", "Rekod telah dipadam dari pangkalan data", "success");
					},
					error: function (data) {
						console.log('Error:', data);
					}
				});                    
			} else {
				swal("Tidak", "Proses pemadaman tidak berlaku", "error");
			}
		});
	});

	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop