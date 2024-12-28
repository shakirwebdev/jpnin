
@section('page-script')
@include('js.modal.j-modal-add-ahli-sejiwa')
@include('js.modal.j-modal-view-ahli-sejiwa')
@include('js.modal.j-modal-add-perkhidmatan-sejiwa')
@include('js.modal.j-modal-view-perkhidmatan-sejiwa')
@include('js.modal.j-modal-add-cabaran-sejiwa')
@include('js.modal.j-modal-view-cabaran-sejiwa')
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

        /* Maklumat Kawasan Krt */
            $('#psk4_nama_krt').html("{{$sejiwa->nama_krt}}");
            $('#psk4_alamat_krt').html("{{$sejiwa->alamat_krt}}");
            $('#psk4_negeri_krt').html("{{$sejiwa->negeri_krt}}");
            $('#psk4_parlimen_krt').html("{{$sejiwa->parlimen_krt}}");
            $('#psk4_pbt_krt').html("{{$sejiwa->pbt_krt}}");
            $('#psk4_daerah_krt').html("{{$sejiwa->daerah_krt}}");
            $('#psk4_dun_krt').html("{{$sejiwa->dun_krt}}");

        /* Maklumat Am Sejiwa */
            $('#psk4_sejiwa_nama').val("{{$sejiwa->sejiwa_nama}}");
            $('#psk4_sejiwa_tarikh_ditubuhkan').val("{{$sejiwa->sejiwa_tarikh_ditubuhkan}}");
            $('#psk4_sejiwa_pusat_operasi').val("{{$sejiwa->sejiwa_pusat_operasi}}");
           
        /* Maklumat Ahli Sejiwa */
            url_ahli_sejiwa_table 			= "{{ route('rt-sm10.get_senarai_ahli_sejiwa_table','') }}"+"/"+"{{$sejiwa->id}}";
            url_delete_ahli_sejiwa 		    = "{{ route('rt-sm10.delete_ahli_sejiwa','') }}";

            var senarai_ahli_sejiwa_table = $('#senarai_ahli_sejiwa_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_ahli_sejiwa_table,
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
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.ahli_sejiwa_nama;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.ahli_sejiwa_ic;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.ahli_sejiwa_pekerjaan;
                    }
                },{          
                    "aTargets": [ 4 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_ahli_sejiwa(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_ahli_sejiwa" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
                        return button_a + '|' + button_b;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

         /* Maklumat Bidang /  Jenis Fokus Perkhidmatan SeJiwa */
            url_perkhidmatan_sejiwa_table 			= "{{ route('rt-sm10.get_senarai_perkhidmatan_sejiwa_table','') }}"+"/"+"{{$sejiwa->id}}";
            url_delete_perkhidmatan_sejiwa 		    = "{{ route('rt-sm10.delete_perkhidmatan_sejiwa','') }}";

            var senarai_perkhidmatan_sejiwa_table = $('#senarai_perkhidmatan_sejiwa_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_perkhidmatan_sejiwa_table,
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
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.perkhidmatan_sejiwa_keperluan;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.perkhidmatan_sejiwa_perkhidmatan;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "6%",
                    sClass: 'text-center', 
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_perkhidmatan_sejiwa(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_perkhidmatan_sejiwa" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
                        return button_a + '|' + button_b;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

        /* Pegawai Rujukan / Penyelia Sejiwa */
            $('#psk6_sejiwa_pegawai_nama').val("{{$sejiwa->sejiwa_pegawai_nama}}");
            $('#psk6_sejiwa_pegawai_phone').val("{{$sejiwa->sejiwa_pegawai_phone}}");
            $('#psk6_sejiwa_pegawai_jawatan').val("{{$sejiwa->sejiwa_pegawai_jawatan}}");
            $('#psk6_sejiwa_pegawai_emel').val("{{$sejiwa->sejiwa_pegawai_emel}}");

        /* Maklumat Cabaran Dan Cara Menangani */
             url_cabaran_sejiwa_table 			= "{{ route('rt-sm10.get_senarai_cabaran_sejiwa_table','') }}"+"/"+"{{$sejiwa->id}}";
             url_delete_cabaran_sejiwa 		    = "{{ route('rt-sm10.delete_cabaran_sejiwa','') }}";
        
            var senarai_cabaran_sejiwa_table = $('#senarai_cabaran_sejiwa_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_cabaran_sejiwa_table,
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
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.cabaran_sejiwa_cabaran;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.cabaran_sejiwa_mengatasi;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_cabaran_sejiwa(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_cabaran_sejiwa" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
                        return button_a + '|' + button_b;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

            $('#psk8_sejiwa_id').val("{{$sejiwa->id}}");

        /* Maklumat Note Kemaskini */
            $('#psk_status').val("{{$sejiwa->status}}");

            if($('#psk_status').val() == '5'){
                $("#psk_perlu_kemaskini").show();
                $('#psk_status_description').html("{{$sejiwa->status_description}}");
                $('#psk_disemak_note').html("{{$sejiwa->disemak_note}}");
            }

            if($('#psk_status').val() == '7'){
                $("#psk_perlu_kemaskini").show();
                $('#psk_status_description').html("{{$sejiwa->status_description}}");
                $('#psk_disahkan_note').html("{{$sejiwa->disahkan_note}}");
            }

	    /* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{ route('rt-sm10.permohonan_sejiwa_krt_1','') }}"+"/"+"{{$sejiwa->id}}";
            });

	});

    /* Ahli Sejiwa */

		//add ahli sejiwa
		//my custom script
		var add_ahli_sejiwa_config = {
			routes: {
				add_ahli_sejiwa_url: "{{ route('rt-sm10.add_ahli_sejiwa') }}",
			}
		};

        $(document).on('submit', '#form_psk4', function(event){    
			event.preventDefault();
			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save').prop('disabled', true);
			var data = $("#form_psk4").serialize();
			var action = $('#add_ahli_sejiwa').val();
			var btn_text;
			if (action == 'add') {
				url = add_ahli_sejiwa_config.routes.add_ahli_sejiwa_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
			}

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=psk4_ahli_sejiwa_nama]').removeClass("is-invalid");
				$('[name=psk4_ahli_sejiwa_ic]').removeClass("is-invalid");
				$('[name=psk4_ahli_sejiwa_pekerjaan]').removeClass("is-invalid");
				$('[name=psk4_kaum_id]').removeClass("is-invalid");
				$('[name=psk4_ahli_sejiwa_jawatan]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'psk4_ahli_sejiwa_nama') {
							$('[name=psk4_ahli_sejiwa_nama]').addClass("is-invalid");
							$('.error_psk4_ahli_sejiwa_nama').html(error);
						}

						if(index == 'psk4_ahli_sejiwa_ic') {
							$('[name=psk4_ahli_sejiwa_ic]').addClass("is-invalid");
							$('.error_psk4_ahli_sejiwa_ic').html(error);
						}

						if(index == 'psk4_ahli_sejiwa_pekerjaan') {
							$('[name=psk4_ahli_sejiwa_pekerjaan]').addClass("is-invalid");
							$('.error_psk4_ahli_sejiwa_pekerjaan').html(error);
						}

						if(index == 'psk4_kaum_id') {
							$('[name=psk4_kaum_id]').addClass("is-invalid");
							$('.error_psk4_kaum_id').html(error);
						}
						
						if(index == 'psk4_ahli_sejiwa_jawatan') {
							$('[name=psk4_ahli_sejiwa_jawatan]').addClass("is-invalid");
							$('.error_psk4_ahli_sejiwa_jawatan').html(error);
						}

					});
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);            
				} else {
					$('#modal_add_ahli_sejiwa').modal('hide');
					swal("Maklumat Ahli Sejiwa ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_psk4').trigger("reset");
					$('#senarai_ahli_sejiwa_table').DataTable().ajax.reload();
                    $('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);
                }
			});
		});

        // click delete biro
		$('body').on('click', '#delete_ahli_sejiwa', function () {
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
						url: url_delete_ahli_sejiwa +"/" + delete_id,
						success: function (data) {
							$('#senarai_ahli_sejiwa_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Ahli Sejiwa telah dipadam dari pangkalan data", "success");
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

    /* Perkhidmatan Sejiwa */

        //add ahli sejiwa
		//my custom script
		var add_perkhidmatan_sejiwa_config = {
			routes: {
				add_perkhidmatan_sejiwa_url: "{{ route('rt-sm10.add_perkhidmatan_sejiwa') }}",
			}
		};

        $(document).on('submit', '#form_psk5', function(event){    
			event.preventDefault();
			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save').prop('disabled', true);
			var data = $("#form_psk5").serialize();
			var action = $('#add_perkhidmatan_sejiwa').val();
			var btn_text;
			if (action == 'add') {
				url = add_perkhidmatan_sejiwa_config.routes.add_perkhidmatan_sejiwa_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
			}

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=psk5_perkhidmatan_sejiwa_keperluan]').removeClass("is-invalid");
				$('[name=psk5_perkhidmatan_sejiwa_perkhidmatan]').removeClass("is-invalid");
				$('[name=psk5_perkhidmatan_sejiwa_kerjasama]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'psk5_perkhidmatan_sejiwa_keperluan') {
							$('[name=psk5_perkhidmatan_sejiwa_keperluan]').addClass("is-invalid");
							$('.error_psk5_perkhidmatan_sejiwa_keperluan').html(error);
						}

						if(index == 'psk5_perkhidmatan_sejiwa_perkhidmatan') {
							$('[name=psk5_perkhidmatan_sejiwa_perkhidmatan]').addClass("is-invalid");
							$('.error_psk5_perkhidmatan_sejiwa_perkhidmatan').html(error);
						}

						if(index == 'psk5_perkhidmatan_sejiwa_kerjasama') {
							$('[name=psk5_perkhidmatan_sejiwa_kerjasama]').addClass("is-invalid");
							$('.error_psk5_perkhidmatan_sejiwa_kerjasama').html(error);
						}

					});
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);            
				} else {
					$('#modal_add_perkhidmatan_sejiwa').modal('hide');
					swal("Maklumat Perkhidmatan Sejiwa ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_psk5').trigger("reset");
					$('#senarai_perkhidmatan_sejiwa_table').DataTable().ajax.reload();
                    $('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);
                }
			});
		});

        // click delete biro
		$('body').on('click', '#delete_perkhidmatan_sejiwa', function () {
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
						url: url_delete_perkhidmatan_sejiwa +"/" + delete_id,
						success: function (data) {
							$('#senarai_perkhidmatan_sejiwa_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Jenis Fokus Perkhidmatan Sejiwa telah dipadam dari pangkalan data", "success");
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

    /* Cabaran Dan Cara Menangani */

        //add cabaran sejiwa
		//my custom script
		var add_cabaran_sejiwa_config = {
			routes: {
				add_cabaran_sejiwa_url: "{{ route('rt-sm10.add_cabaran_sejiwa') }}",
			}
		};

        $(document).on('submit', '#form_psk7', function(event){    
			event.preventDefault();
			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save').prop('disabled', true);
			var data = $("#form_psk7").serialize();
			var action = $('#add_cabaran_sejiwa').val();
			var btn_text;
			if (action == 'add') {
				url = add_cabaran_sejiwa_config.routes.add_cabaran_sejiwa_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
			}

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=psk7_cabaran_sejiwa_cabaran]').removeClass("is-invalid");
				$('[name=psk7_cabaran_sejiwa_mengatasi]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'psk7_cabaran_sejiwa_cabaran') {
							$('[name=psk7_cabaran_sejiwa_cabaran]').addClass("is-invalid");
							$('.error_psk7_cabaran_sejiwa_cabaran').html(error);
						}

						if(index == 'psk7_cabaran_sejiwa_mengatasi') {
							$('[name=psk7_cabaran_sejiwa_mengatasi]').addClass("is-invalid");
							$('.error_psk7_cabaran_sejiwa_mengatasi').html(error);
						}

					});
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);            
				} else {
					$('#modal_add_cabaran_sejiwa').modal('hide');
					swal("Maklumat Cabaran ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_psk7').trigger("reset");
					$('#senarai_cabaran_sejiwa_table').DataTable().ajax.reload();
                    $('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);
                }
			});
		});

        // click delete biro
		$('body').on('click', '#delete_cabaran_sejiwa', function () {
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
						url: url_delete_cabaran_sejiwa +"/" + delete_id,
						success: function (data) {
							$('#senarai_cabaran_sejiwa_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Cabaran telah dipadam dari pangkalan data", "success");
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

    /* Button Submit Permohonan Sejiwa */
        //my custom script
        var permohonan_sejiwa_config = {
            routes: {
                permohonan_sejiwa_url: "{{ route('rt-sm10.post_profil_sejiwa_krt_1') }}",
            }
        };

        $(document).on('submit', '#form_psk8', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data   = $("#form_psk6, #form_psk8").serialize();
            var action = $('#post_profil_sejiwa_krt_1').val();
            var btn_text;
            if (action == 'edit') {
                url = permohonan_sejiwa_config.routes.permohonan_sejiwa_url;
                type = "POST";
                btn_text = 'Hantar Permohonan Sejiwa &nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=psk6_sejiwa_pegawai_nama]').removeClass("is-invalid");
                $('[name=psk6_sejiwa_pegawai_phone]').removeClass("is-invalid");
                $('[name=psk6_sejiwa_pegawai_jawatan]').removeClass("is-invalid");
                $('[name=psk6_sejiwa_pegawai_emel]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'psk6_sejiwa_pegawai_nama') {
                            $('[name=psk6_sejiwa_pegawai_nama]').addClass("is-invalid");
                            $('.error_psk6_sejiwa_pegawai_nama').html(error);
                        }

                        if(index == 'psk6_sejiwa_pegawai_phone') {
                            $('[name=psk6_sejiwa_pegawai_phone]').addClass("is-invalid");
                            $('.error_psk6_sejiwa_pegawai_phone').html(error);
                        }

                        if(index == 'psk6_sejiwa_pegawai_jawatan') {
                            $('[name=psk6_sejiwa_pegawai_jawatan]').addClass("is-invalid");
                            $('.error_psk6_sejiwa_pegawai_jawatan').html(error);
                        }

                        if(index == 'psk6_sejiwa_pegawai_emel') {
                            $('[name=psk6_sejiwa_pegawai_emel]').addClass("is-invalid");
                            $('.error_psk6_sejiwa_pegawai_emel').html(error);
                        }
                    });
                    $('#btn_submit').html(btn_text);                
                    $('#btn_submit').prop('disabled', false);            
                } else {
                    $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm10.permohonan_sejiwa_krt')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
@stop