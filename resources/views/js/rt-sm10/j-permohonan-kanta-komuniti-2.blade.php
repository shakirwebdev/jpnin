
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
            senarai_risiko_url			    = "{{ route('rt-sm10.get_senarai_risiko_kanta_table','') }}"+"/"+"{{$kanta_komuniti->id}}";
            delete_risiko_url 	            = "{{ route('rt-sm10.delete_risiko_kanta','') }}";

        /* Maklumat Am Kanta Komuniti */
            $('#pkk_state_id').val("{{$kanta_komuniti->state_id}}");
            $('#pkk_daerah_id').val("{{$kanta_komuniti->daerah_id}}");
            $('#pkk_kanta_nama').val("{{$kanta_komuniti->kanta_nama}}");
            $('#pkk_kanta_alamat').val("{{$kanta_komuniti->kanta_alamat}}");
			
			var kanta_jenis_kediaman_1 = "{{$kanta_komuniti->kanta_jenis_kediaman_1}}";
            if (kanta_jenis_kediaman_1 == "1") {
                $("input[name=pkk_kanta_jenis_kediaman_1]").prop('checked', true);
            }

            var kanta_jenis_kediaman_2 = "{{$kanta_komuniti->kanta_jenis_kediaman_2}}";
            if (kanta_jenis_kediaman_2 == "1") {
                $("input[name=pkk_kanta_jenis_kediaman_2]").prop('checked', true);
            }

            var kanta_jenis_kediaman_3 = "{{$kanta_komuniti->kanta_jenis_kediaman_3}}";
            if (kanta_jenis_kediaman_3 == "1") {
                $("input[name=pkk_kanta_jenis_kediaman_3]").prop('checked', true);
            }

            var kanta_jenis_kediaman_4 = "{{$kanta_komuniti->kanta_jenis_kediaman_4}}";
            if (kanta_jenis_kediaman_4 == "1") {
                $("input[name=pkk_kanta_jenis_kediaman_4]").prop('checked', true);
            }

        /* Maklumat Profile Kanta Komuniti */
            $('#pkk4_kanta_komuniti_id').val("{{$kanta_komuniti->id}}");
            var senarai_risiko_table = $('#senarai_risiko_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: senarai_risiko_url,
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
					"width": "45%", 
					"mRender": function ( value, type, full )  {
						return full.risiko_nama_agensi;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "23%", 
					"mRender": function ( value, type, full )  {
						return full.risiko_jenis;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.risiko_isu;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "6%", 
                    sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_risiko" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

            $('#pkk5_kanta_sejarah_lokasi').val("{{$kanta_komuniti->kanta_sejarah_lokasi}}");
            $('#pkk5_kanta_kelebihan_lokasi').val("{{$kanta_komuniti->kanta_kelebihan_lokasi}}");
            $('#pkk5_kanta_kemudahan').val("{{$kanta_komuniti->kanta_kemudahan}}");

            $('#pkk6_kanta_komuniti_id').val("{{$kanta_komuniti->id}}");

			$('#pkk5_kanta_sejarah_lokasi').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

			$('#pkk5_kanta_kelebihan_lokasi').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

			$('#pkk5_kanta_kemudahan').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

		/* Maklumat Note Kemaskini */   
			$('#pkk_status').val("{{$kanta_komuniti->status}}"); 

			if($('#pkk_status').val() == '5'){
				$("#pkk_perlu_kemaskini").show();
				$('#pkk_status_description').html("{{$kanta_komuniti->status_description}}");
				$('#pkk_disemak_note').html("{{$kanta_komuniti->disemak_note}}");
			}

			if($('#pkk_status').val() == '7'){
				$("#pkk_perlu_kemaskini").show();
				$('#pkk_status_description').html("{{$kanta_komuniti->status_description}}");
				$('#pkk_disahkan_note').html("{{$kanta_komuniti->disahkan_note}}");
			}

        /* Button */
			$('#btn_back').click(function(){
				window.location.href = "{{ route('rt-sm10.permohonan_kanta_komuniti_1','') }}"+"/"+"{{$kanta_komuniti->id}}";
			});

	});

    /* click add risiko */
		$(document).on('submit', '#form_pkk4', function(event){
			var info = $('.error_form_pkk4');
			event.preventDefault();

			$('#btn_save_risiko').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save_risiko').prop('disabled', true);

			var data = $("#form_pkk4").serialize();
			
            btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm10.add_kanta_komuniti_risiko') }}";
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
					$('#btn_save_risiko').html(btn_text);                
					$('#btn_save_risiko').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Risiko Lokasi ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_pkk4').trigger("reset");
					$('#btn_save_risiko').html(btn_text);
					$('#btn_save_risiko').prop('disabled', false);
					$('#senarai_risiko_table').DataTable().ajax.reload();
				}
			});
		});

    /* click delete risiko */
		$('body').on('click', '#delete_risiko', function () {
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
						url: delete_risiko_url +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_risiko_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Risiko Lokasi telah dipadam dari pangkalan data", "success");
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

    /* click btn next */
		//my custom script
		var update_kanta_komuniti_2_config = {
			routes: {
				update_kanta_komuniti_2_url: "{{ route('rt-sm10.post_permohonan_kanta_komuniti_2') }}",
			}
		};

        $(document).on('submit', '#form_pkk6', function(event){    
			event.preventDefault();
			$('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_next').prop('disabled', true);
			var data = $("#form_pkk5, #form_pkk6").serialize();
			var action = $('#post_permohonan_kanta_komuniti_2').val();
			var btn_text;
			if (action == 'edit') {
				url = update_kanta_komuniti_2_config.routes.update_kanta_komuniti_2_url;
				type = "POST";
				btn_text = 'Seterusnya &nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=pkk5_kanta_sejarah_lokasi]').removeClass("is-invalid");
				$('[name=pkk5_kanta_kelebihan_lokasi]').removeClass("is-invalid");
				$('[name=pkk5_kanta_kemudahan]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'pkk5_kanta_sejarah_lokasi') {
							$('[name=pkk5_kanta_sejarah_lokasi]').addClass("is-invalid");
							$('.error_pkk5_kanta_sejarah_lokasi').html(error);
						}

						if(index == 'pkk5_kanta_kelebihan_lokasi') {
							$('[name=pkk5_kanta_kelebihan_lokasi]').addClass("is-invalid");
							$('.error_pkk5_kanta_kelebihan_lokasi').html(error);
						}

						if(index == 'pkk5_kanta_kemudahan') {
							$('[name=pkk5_kanta_kemudahan]').addClass("is-invalid");
							$('.error_pkk5_kanta_kemudahan').html(error);
						}

					});
					$('#btn_next').html(btn_text);                
					$('#btn_next').prop('disabled', false);            
				} else {
					$('#btn_next').html(btn_text);
					$('#btn_next').prop('disabled', false); 
					window.location.href = "{{route('rt-sm10.permohonan_kanta_komuniti_3','')}}"+"/"+"{{$kanta_komuniti->id}}";
				}
			});
		});
    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop