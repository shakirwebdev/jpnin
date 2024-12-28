
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
            senarai_langkah_masalah_url			    = "{{ route('rt-sm10.get_senarai_langkah_masalah_kanta_table','') }}"+"/"+"{{$kanta_komuniti->id}}";
            delete_langkah_masalah_url 	            = "{{ route('rt-sm10.delete_langkah_masalah_kanta','') }}";
            senarai_pemimpin_url			        = "{{ route('rt-sm10.get_senarai_pemimpin_kanta_table','') }}"+"/"+"{{$kanta_komuniti->id}}";
            delete_pemimpin_url 	                = "{{ route('rt-sm10.delete_pemimpin_kanta','') }}";
            

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
            $('#pkk10_kanta_komuniti_id').val("{{$kanta_komuniti->id}}");
            var senarai_langkah_masalah_table = $('#senarai_langkah_masalah_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: senarai_langkah_masalah_url,
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
					"width": "23%", 
					"mRender": function ( value, type, full )  {
						return full.masalah_tajuk;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.langkah_diambil;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "20%", 
					"mRender": function ( value, type, full )  {
						return full.langkah_pelaksanaan;
					}
				},{          
					"aTargets": [ 4 ], 
					"width": "25%", 
					"mRender": function ( value, type, full )  {
						return full.langkah_status;
					}
				},{          
					"aTargets": [ 5 ], 
					"width": "6%", 
                    sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_langkah_masalah" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

            $('#pkk11_kanta_komuniti_id').val("{{$kanta_komuniti->id}}");
            var senarai_pemimpin_table = $('#senarai_pemimpin_table').DataTable( {
				processing: true,
				serverSide: true,
				ajax: senarai_pemimpin_url,
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
					"width": "30%", 
					"mRender": function ( value, type, full )  {
						return full.pemimpin_nama;
					}
				},{          
					"aTargets": [ 2 ], 
					"width": "58%", 
					"mRender": function ( value, type, full )  {
						return full.pemimpin_catatan;
					}
				},{          
					"aTargets": [ 3 ], 
					"width": "6%", 
                    sClass: 'text-center',
					"mRender": function ( value, type, full )  {
						button_a = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_pemimpin" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
						return button_a;
					}
				}],
				"order": [[ 0, 'asc' ]],
				initComplete: function () {
					$('[data-toggle="tooltip"]').tooltip();
				}
			});

			$('#pkk11_pemimpin_catatan').on('keyup keypress', function(e) {
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

			$('#pkk12_kanta_komuniti_id').val("{{$kanta_komuniti->id}}");

        /* Button */
        $('#btn_back').click(function(){
			window.location.href = "{{ route('rt-sm10.permohonan_kanta_komuniti_3','') }}"+"/"+"{{$kanta_komuniti->id}}";
		});

	});

    /* click add langkah masalah */
		$(document).on('submit', '#form_pkk10', function(event){
			var info = $('.error_form_pkk10');
			event.preventDefault();

			$('#btn_save_langkah_masalah').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save_langkah_masalah').prop('disabled', true);

			var data = $("#form_pkk10").serialize();
			
            btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm10.add_kanta_komuniti_langkah_masalah') }}";
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
					$('#btn_save_langkah_masalah').html(btn_text);                
					$('#btn_save_langkah_masalah').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Maklumat Langkah Cadangan Langkah Untuk Menangani Isu dan Masalah ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_pkk7').trigger("reset");
					$('#btn_save_langkah_masalah').html(btn_text);
					$('#btn_save_langkah_masalah').prop('disabled', false);
					$('#senarai_langkah_masalah_table').DataTable().ajax.reload();
				}
			});
		});

    /* click delete langkah masalah */
		$('body').on('click', '#delete_langkah_masalah', function () {
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
						url: delete_langkah_masalah_url +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_langkah_masalah_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Langkah Cadangan Langkah Untuk Menangani Isu dan Masalah telah dipadam dari pangkalan data", "success");
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

    /* click add pemimpin */
		$(document).on('submit', '#form_pkk11', function(event){
			var info = $('.error_form_pkk11');
			event.preventDefault();

			$('#btn_save_pemimpin').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save_pemimpin').prop('disabled', true);

			var data = $("#form_pkk11").serialize();
			
            btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm10.add_kanta_komuniti_pemimpin') }}";
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
					$('#btn_save_pemimpin').html(btn_text);                
					$('#btn_save_pemimpin').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Maklumat Pemimpin Tempatan dan Organisasi Tempatan ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_pkk7').trigger("reset");
					$('#btn_save_pemimpin').html(btn_text);
					$('#btn_save_pemimpin').prop('disabled', false);
					$('#senarai_pemimpin_table').DataTable().ajax.reload();
				}
			});
		});

    /* click delete langkah pemimpin */
		$('body').on('click', '#delete_pemimpin', function () {
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
						url: delete_pemimpin_url +"/" + delete_id,
						success: function (data) {
							// $('#peranan_form').trigger("reset");
							$('#senarai_pemimpin_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Pemimpin Tempatan dan Organisasi Tempatan telah dipadam dari pangkalan data", "success");
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

	/* click btn submit */
		//my custom script
		var update_kanta_komuniti_3_config = {
			routes: {
				update_kanta_komuniti_3_url: "{{ route('rt-sm10.post_permohonan_kanta_komuniti_3') }}",
			}
		};

		$(document).on('submit', '#form_pkk12', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data = $("#form_pkk12").serialize();
			var action = $('#post_permohonan_kanta_komuniti_3').val();
			var btn_text;
			if (action == 'edit') {
				url = update_kanta_komuniti_3_config.routes.update_kanta_komuniti_3_url;
				type = "POST";
				btn_text = 'Hantar Permohonan &nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			} 
			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						

					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#btn_submit').html(btn_text);
					$('#btn_submit').prop('disabled', false); 
					window.location.href = "{{route('rt-sm10.permohonan_kanta_komuniti')}}";
				}
			});
		});
    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop