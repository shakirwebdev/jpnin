
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
            senarai_kaum_url			    = "{{ route('rt-sm10.get_senarai_kaum_table','') }}"+"/"+"{{$kanta_komuniti->id}}";
            delete_kaum_url 	            = "{{ route('rt-sm10.delete_kaum','') }}";
            senarai_penduduk_url			= "{{ route('rt-sm10.get_senarai_penduduk_table','') }}"+"/"+"{{$kanta_komuniti->id}}";
            delete_penduduk_url 	        = "{{ route('rt-sm10.delete_penduduk','') }}";

        /* Maklumat Am Kanta Komuniti */
            $('#pkk_state_id').val("{{$kanta_komuniti->state_id}}");
            $('#pkk_daerah_id').val("{{$kanta_komuniti->daerah_id}}");
			$('#pkk_kanta_alamat').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

        /* Maklumat Profile Kanta Komuniti */
            $('#pkk1_kanta_komuniti_id').val("{{$kanta_komuniti->id}}");
            var senarai_kaum_table = $('#senarai_kaum_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: senarai_kaum_url,
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
					"width": "48%", 
					"mRender": function ( value, type, full )  {
						return full.kaum_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.bilangan;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.peratus + '%';
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "6%", 
                    sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_kaum" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

            $('#pkk2_kanta_komuniti_id').val("{{$kanta_komuniti->id}}");
            var senarai_penduduk_table = $('#senarai_penduduk_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: senarai_penduduk_url,
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
						return full.kaum_description;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "23%", 
					"mRender": function ( value, type, full )  {
						return full.bilangan_rumah;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.peratus + '%';
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "6%", 
                    sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_penduduk" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});
            
            $('#pkk3_kanta_komuniti_id').val("{{$kanta_komuniti->id}}");
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
				window.location.href = "{{ route('rt-sm10.permohonan_kanta_komuniti') }}";
			});

	});

    /* click add kaum */
		$(document).on('submit', '#form_pkk1', function(event){
			var info = $('.error_form_pkk1');
			event.preventDefault();

			$('#btn_save_kaum').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save_kaum').prop('disabled', true);

			var data = $("#form_pkk1").serialize();
			
            btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm10.add_kanta_komuniti_kaum') }}";
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
					$('#btn_save_kaum').html(btn_text);                
					$('#btn_save_kaum').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Kaum ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_pkk1').trigger("reset");
					$('#btn_save_kaum').html(btn_text);
					$('#btn_save_kaum').prop('disabled', false);
					$('#senarai_kaum_table').DataTable().ajax.reload();
				}
			});
		});

    /* click delete kaum */
		$('body').on('click', '#delete_kaum', function () {
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
						url: delete_kaum_url +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_kaum_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Kaum telah dipadam dari pangkalan data", "success");
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
    
    /* click add penduduk */
		$(document).on('submit', '#form_pkk2', function(event){
			var info = $('.error_form_pkk2');
			event.preventDefault();

			$('#btn_save_penduduk').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save_penduduk').prop('disabled', true);

			var data = $("#form_pkk2").serialize();
			
            btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm10.add_kanta_komuniti_penduduk') }}";
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
					$('#btn_save_penduduk').html(btn_text);                
					$('#btn_save_penduduk').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Komposisi Penduduk ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_pkk2').trigger("reset");
					$('#btn_save_penduduk').html(btn_text);
					$('#btn_save_penduduk').prop('disabled', false);
					$('#senarai_penduduk_table').DataTable().ajax.reload();
				}
			});
		});

    /* click delete penduduk */
		$('body').on('click', '#delete_penduduk', function () {
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
						url: delete_penduduk_url +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_penduduk_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Kaum telah dipadam dari pangkalan data", "success");
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
		var update_kanta_komuniti_config = {
			routes: {
				update_kanta_komuniti_url: "{{ route('rt-sm10.post_permohonan_kanta_komuniti_1') }}",
			}
		};

        $(document).on('submit', '#form_pkk3', function(event){    
			event.preventDefault();
			$('#btn_next').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_next').prop('disabled', true);
			var data = $("#form_pkk, #form_pkk3").serialize();
			var action = $('#post_permohonan_kanta_komuniti_1').val();
			var btn_text;
			if (action == 'edit') {
				url = update_kanta_komuniti_config.routes.update_kanta_komuniti_url;
				type = "POST";
				btn_text = 'Seterusnya &nbsp;<i class="dropdown-icon fe fe-arrow-right"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=pkk_kanta_nama]').removeClass("is-invalid");
				$('[name=pkk_kanta_alamat]').removeClass("is-invalid");
				$('[name=pkk_kanta_jenis_kediaman_1]').removeClass("is-invalid");
				$('[name=pkk_kanta_jenis_kediaman_2]').removeClass("is-invalid");
				$('[name=pkk_kanta_jenis_kediaman_3]').removeClass("is-invalid");
				$('[name=pkk_kanta_jenis_kediaman_4]').removeClass("is-invalid");
				
                if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'pkk_kanta_nama') {
							$('[name=pkk_kanta_nama]').addClass("is-invalid");
							$('.error_pkk_kanta_nama').html(error);
						}

						if(index == 'pkk_kanta_alamat') {
							$('[name=pkk_kanta_alamat]').addClass("is-invalid");
							$('.error_pkk_kanta_alamat').html(error);
						}

						if(index == 'pkk_kanta_jenis_kediaman_1') {
							$('[name=pkk_kanta_jenis_kediaman_1]').addClass("is-invalid");
							$('.error_pkk_kanta_jenis_kediaman_1').html(error);
						}

						if(index == 'pkk_kanta_jenis_kediaman_2') {
							$('[name=pkk_kanta_jenis_kediaman_2]').addClass("is-invalid");
							$('.error_pkk_kanta_jenis_kediaman_2').html(error);
						}

						if(index == 'pkk_kanta_jenis_kediaman_3') {
							$('[name=pkk_kanta_jenis_kediaman_3]').addClass("is-invalid");
							$('.error_pkk_kanta_jenis_kediaman_3').html(error);
						}

						if(index == 'pkk_kanta_jenis_kediaman_4') {
							$('[name=pkk_kanta_jenis_kediaman_4]').addClass("is-invalid");
							$('.error_pkk_kanta_jenis_kediaman_4').html(error);
						}

					});
					$('#btn_next').html(btn_text);                
					$('#btn_next').prop('disabled', false);            
				} else {
					$('#btn_next').html(btn_text);
					$('#btn_next').prop('disabled', false); 
					window.location.href = "{{route('rt-sm10.permohonan_kanta_komuniti_2','')}}"+"/"+"{{$kanta_komuniti->id}}";
				}
			});
		});
    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop