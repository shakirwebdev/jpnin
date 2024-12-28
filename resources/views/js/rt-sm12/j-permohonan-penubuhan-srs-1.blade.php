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
			$('#pps4_nama_krt').html("{{$srs_profile->nama_krt}}");
			$('#pps4_alamat_krt').html("{{$srs_profile->alamat_krt}}");
			$('#pps4_negeri_krt').html("{{$srs_profile->negeri_krt}}");
			$('#pps4_parlimen_krt').html("{{$srs_profile->parlimen_krt}}");
			$('#pps4_pbt_krt').html("{{$srs_profile->pbt_krt}}");
			$('#pps4_daerah_krt').html("{{$srs_profile->daerah_krt}}");
			$('#pps4_dun_krt').html("{{$srs_profile->dun_krt}}");

		/* Maklumat Pemohon */
			$('#pps4_pemohon_name').val("{{$user_profile->pemohon_name}}");
			$('#pps4_pemohon_ic').val("{{$user_profile->pemohon_ic}}");
			$('#pps4_pemohon_address').val("{{$user_profile->pemohon_address}}");

			$('#pps5_p_sukarela_kad').mask('999999999999');
			
		/* Maklumat Peronda Sukarela */	
			$('#pps5_p_sukarela_alamat_k').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
			$('#pps5_p_sukarela_alamat_k').on("paste",function(e) {
                e.preventDefault();
            });
			
			$('#pps5_srs_profile_id').val("{{$srs_profile->id}}");

			//my custom script
			url_senarai_peronda_sukarela 			= "{{ route('rt-sm12.get_senarai_peronda_sukarela_table','') }}"+"/"+"{{$srs_profile->id}}";
			url_delete_senarai_peronda_sukarela  	= "{{ route('rt-sm12.delete_peronda_sukarela','') }}";

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
				},{          
					"aTargets": [ 6 ], 
					"width": "6%",
					sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete-peronda-sukarela" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
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
				window.location.href = "{{route('rt-sm12.permohonan_penubuhan_srs','')}}"+"/"+{{$srs_profile->id}};
			});

			$('#btn_next').click(function(){
				window.location.href = "{{route('rt-sm12.permohonan_penubuhan_srs_2','')}}"+"/"+{{$srs_profile->id}};
			});
	});
		
	/* click add peronda sukarela */
	$(document).on('submit', '#form_pps5', function(event){
		var info = $('.error_alert_pps5');
		event.preventDefault();

		$('#btn_save_peronda_sukarela').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
		$('#btn_save_peronda_sukarela').prop('disabled', true);

		var data = $("#form_pps5").serialize();
		btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
		url = "{{ route('rt-sm12.post_peronda_sukarela') }}";
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
				$('#btn_save_peronda_sukarela').html(btn_text);                
				$('#btn_save_peronda_sukarela').prop('disabled', false);
				info.slideDown();
			} else {
				swal("Senarai Peronda Sukarela ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
				$('#form_pps5').trigger("reset");
				$('#btn_save_peronda_sukarela').html(btn_text);
				$('#btn_save_peronda_sukarela').prop('disabled', false);
				$('#senarai_peronda_sukarela_table').DataTable().ajax.reload();
			}
		});
	});

	/* click delete peronda sukarela */
	$('body').on('click', '#delete-peronda-sukarela', function () {
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
					url: url_delete_senarai_peronda_sukarela +"/" + delete_id,
					success: function (data) {
						// $('#peranan_form').trigger("reset");
						$('#senarai_peronda_sukarela_table').DataTable().ajax.reload();
						swal("Sudah dipadam!", "Rekod peronda sukarela telah dipadam dari pangkalan data", "success");
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
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
@stop