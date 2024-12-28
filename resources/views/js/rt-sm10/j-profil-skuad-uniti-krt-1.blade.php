@include('js.modal.j-modal-add-biro-skuad-uniti')
@include('js.modal.j-modal-view-biro-skuad-uniti')
@include('js.modal.j-modal-add-jaringan-skuad-uniti')
@include('js.modal.j-modal-view-jaringan-skuad-uniti')
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

        /* Maklumat Kawasan Krt */
            $('#psuk_nama_krt').html("{{$skuad_uniti->nama_krt}}");
            $('#psuk_alamat_krt').html("{{$skuad_uniti->alamat_krt}}");
            $('#psuk_negeri_krt').html("{{$skuad_uniti->negeri_krt}}");
            $('#psuk_parlimen_krt').html("{{$skuad_uniti->parlimen_krt}}");
            $('#psuk_pbt_krt').html("{{$skuad_uniti->pbt_krt}}");
            $('#psuk_daerah_krt').html("{{$skuad_uniti->daerah_krt}}");
            $('#psuk_dun_krt').html("{{$skuad_uniti->dun_krt}}");

        /* Maklumat Am Kawasan Krt */
            $('#psuk1_skuad_nama').val("{{$skuad_uniti->skuad_nama}}");
            $('#psuk1_skuad_tarikh_ditubuhkan').val("{{$skuad_uniti->skuad_tarikh_ditubuhkan}}");
            $('#psuk1_skuad_skop_perkhidmatan').val("{{$skuad_uniti->skuad_skop_perkhidmatan}}");
            $('#psuk1_skuad_skop_perkhidmatan').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});

        /* Maklumat Ketua Skuad Uniti */
            $('#psuk2_skuad_nama_ketua').val("{{$skuad_uniti->skuad_nama_ketua}}");
            $('#psuk2_skuad_phone_ketua').val("{{$skuad_uniti->skuad_phone_ketua}}");
            $('#psuk2_skuad_email_ketua').val("{{$skuad_uniti->skuad_email_ketua}}");
            $('#psuk2_skuad_ic_ketua').val("{{$skuad_uniti->skuad_ic_ketua}}");
            $('#psuk2_skuad_alamat_ketua').val("{{$skuad_uniti->skuad_alamat_ketua}}");
            $('#psuk2_skuad_pekerjaan_ketua').val("{{$skuad_uniti->skuad_pekerjaan_ketua}}");
            $('#psuk2_skuad_alamat_ketua').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
            $('#psuk2_skuad_ic_ketua').mask('999999999999');

        /* Maklumat Setiausaha Skuad Uniti */
            $('#psuk2_skuad_nama_setiausaha').val("{{$skuad_uniti->skuad_nama_setiausaha}}");
            $('#psuk2_skuad_phone_setiausaha').val("{{$skuad_uniti->skuad_phone_setiausaha}}");
            $('#psuk2_skuad_email_setiausaha').val("{{$skuad_uniti->skuad_email_setiausaha}}");
            $('#psuk2_skuad_ic_setiausaha').val("{{$skuad_uniti->skuad_ic_setiausaha}}");
            $('#psuk2_skuad_alamat_setiausaha').val("{{$skuad_uniti->skuad_alamat_setiausaha}}");
            $('#psuk2_skuad_pekerjaan_setiausaha').val("{{$skuad_uniti->skuad_pekerjaan_setiausaha}}");
            $('#psuk2_skuad_alamat_setiausaha').on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();

					// Ajax code here

					return false;
				}
			});
            $('#psuk2_skuad_ic_setiausaha').mask('999999999999');

        /* Maklumat Biro Skuad Uniti */

            //my custom script
		    url_senarai_biro_table 			= "{{ route('rt-sm10.get_senarai_biro_table','') }}"+"/"+"{{$skuad_uniti->id}}";
            url_delete_biro 				= "{{ route('rt-sm10.delete_biro','') }}";
        
            var senarai_biro_table = $('#senarai_biro_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_senarai_biro_table,
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
                        return full.biro_nama;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.biro_nama_penuh;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.biro_ic;
                    }
                },{          
                    "aTargets": [ 4 ], 
                    "width": "6%", 
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_biro_skuad_uniti(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_biro" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
                        return button_a + '|' + button_b;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

        /* Maklumat Jaringan Kerjasama Strategik */

            //my custom script
		    url_senarai_jaringan_table 			= "{{ route('rt-sm10.get_senarai_jaringan_table','') }}"+"/"+"{{$skuad_uniti->id}}";
            url_delete_jaringan 				= "{{ route('rt-sm10.delete_jaringan','') }}";

            var senarai_jaringan_table = $('#senarai_jaringan_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_senarai_jaringan_table,
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
                        return full.jaringan_agensi_nama;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.jaringan_nama_pegawai;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "20%", 
                    "mRender": function ( value, type, full )  {
                        return full.jaringan_no_telefon;
                    }
                },{          
                    "aTargets": [ 4 ], 
                    "width": "6%", 
                    "mRender": function ( value, type, full )  {
                        button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_jaringan_skuad_uniti(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_jaringan" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
                        return button_a + '|' + button_b;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

        /* Maklumat Profil Skuad Uniti */
            $('#psuk5_skuad_uniti_id').val("{{$skuad_uniti->id}}");

        /* Maklumat Note Kemaskini */
            $('#psuk_status').val("{{$skuad_uniti->status}}");
            
            if($('#psuk_status').val() == '5'){
                $("#psuk_perlu_kemaskini").show();
                $('#psuk_status_description').html("{{$skuad_uniti->status_description}}");
                $('#psuk_disemak_note').html("{{$skuad_uniti->disemak_note}}");
            }

            if($('#psuk_status').val() == '7'){
                $("#psuk_perlu_kemaskini").show();
                $('#psuk_status_description').html("{{$skuad_uniti->status_description}}");
                $('#psuk_diakui_note').html("{{$skuad_uniti->diakui_note}}");
            }

	    /* Button */
            $('#btn_back').click(function(){
                window.location.href = "{{ route('rt-sm10.profil_skuad_uniti_krt') }}";
            });

	});

    /* Biro Skuad Uniti */

		//add Biro Skuad Unit
		//my custom script
		var add_biro_skuad_uniti_config = {
			routes: {
				add_biro_skuad_uniti_url: "{{ route('rt-sm10.add_biro_skuad_uniti') }}",
			}
		};

		$(document).on('submit', '#form_psuk3', function(event){    
			event.preventDefault();
			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save').prop('disabled', true);
			var data = $("#form_psuk3").serialize();
			var action = $('#add_biro_skuad_uniti').val();
			var btn_text;
			if (action == 'add') {
				url = add_biro_skuad_uniti_config.routes.add_biro_skuad_uniti_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
			}

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=psuk3_biro_nama]').removeClass("is-invalid");
				$('[name=psuk3_biro_nama_penuh]').removeClass("is-invalid");
				$('[name=psuk3_biro_ic]').removeClass("is-invalid");
				$('[name=psuk3_biro_phone]').removeClass("is-invalid");
				$('[name=psuk3_biro_emel]').removeClass("is-invalid");
				$('[name=psuk3_biro_pekerjaan]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'psuk3_biro_nama') {
							$('[name=psuk3_biro_nama]').addClass("is-invalid");
							$('.error_psuk3_biro_nama').html(error);
						}

						if(index == 'psuk3_biro_nama_penuh') {
							$('[name=psuk3_biro_nama_penuh]').addClass("is-invalid");
							$('.error_psuk3_biro_nama_penuh').html(error);
						}

						if(index == 'psuk3_biro_ic') {
							$('[name=psuk3_biro_ic]').addClass("is-invalid");
							$('.error_psuk3_biro_ic').html(error);
						}

						if(index == 'psuk3_biro_phone') {
							$('[name=psuk3_biro_phone]').addClass("is-invalid");
							$('.error_psuk3_biro_phone').html(error);
						}
						
						if(index == 'psuk3_biro_emel') {
							$('[name=psuk3_biro_emel]').addClass("is-invalid");
							$('.error_psuk3_biro_emel').html(error);
						}

						if(index == 'psuk3_biro_pekerjaan') {
							$('[name=psuk3_biro_pekerjaan]').addClass("is-invalid");
							$('.error_psuk3_biro_pekerjaan').html(error);
						}

					});
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);            
				} else {
					$('#modal_add_biro_skuad_uniti').modal('hide');
					swal("Maklumat Biro Skuad Uniti ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_mabj').trigger("reset");
					$('#senarai_biro_table').DataTable().ajax.reload();
                    $('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);
                    $("#form_psuk3").trigger('reset');
				}
			});
		});

        // click delete biro
		$('body').on('click', '#delete_biro', function () {
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
						url: url_delete_biro +"/" + delete_id,
						success: function (data) {
							$('#senarai_biro_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod peranan telah dipadam dari pangkalan data", "success");
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

    /* Jaringan Kerjasama Strategik */

        //add Biro Skuad Unit
		//my custom script
		var add_jaringan_skuad_uniti_config = {
			routes: {
				add_jaringan_skuad_uniti_url: "{{ route('rt-sm10.add_jaringan_skuad_uniti') }}",
			}
		};

        $(document).on('submit', '#form_psuk4', function(event){    
			event.preventDefault();
			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save').prop('disabled', true);
			var data = $("#form_psuk4").serialize();
			var action = $('#add_jaringan_skuad_uniti').val();
			var btn_text;
			if (action == 'add') {
				url = add_jaringan_skuad_uniti_config.routes.add_jaringan_skuad_uniti_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
			}

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=psuk4_jaringan_agensi_nama]').removeClass("is-invalid");
				$('[name=psuk4_jaringan_nama_pegawai]').removeClass("is-invalid");
				$('[name=psuk4_jaringan_no_telefon]').removeClass("is-invalid");
				$('[name=psuk4_jaringan_kerjasama]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'psuk4_jaringan_agensi_nama') {
							$('[name=psuk4_jaringan_agensi_nama]').addClass("is-invalid");
							$('.error_psuk4_jaringan_agensi_nama').html(error);
						}

						if(index == 'psuk4_jaringan_nama_pegawai') {
							$('[name=psuk4_jaringan_nama_pegawai]').addClass("is-invalid");
							$('.error_psuk4_jaringan_nama_pegawai').html(error);
						}

						if(index == 'psuk4_jaringan_no_telefon') {
							$('[name=psuk4_jaringan_no_telefon]').addClass("is-invalid");
							$('.error_psuk4_jaringan_no_telefon').html(error);
						}

						if(index == 'psuk4_jaringan_kerjasama') {
							$('[name=psuk4_jaringan_kerjasama]').addClass("is-invalid");
							$('.error_psuk4_jaringan_kerjasama').html(error);
						}
						
					});
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);            
				} else {
					$('#modal_add_jaringan_skuad_uniti').modal('hide');
					swal("Maklumat Jaringan Kerjasama Strategik ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_psuk4').trigger("reset");
					$('#senarai_jaringan_table').DataTable().ajax.reload();
                    $('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);
                }
			});
		});

        // click delete biro
		$('body').on('click', '#delete_jaringan', function () {
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
						url: url_delete_jaringan +"/" + delete_id,
						success: function (data) {
							$('#senarai_jaringan_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod Jaringan Kerjasama Strategik telah dipadam dari pangkalan data", "success");
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

    /* Button Next */

        //my custom script
        var tambah_skuad_uniti_config = {
            routes: {
                tambah_skuad_uniti_url: "{{ route('rt-sm10.post_profil_skuad_uniti_krt') }}",
            }
        };

        $(document).on('submit', '#form_psuk5', function(event){    
            event.preventDefault();
            $('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
            $('#btn_submit').prop('disabled', true);
            var data   = $("#form_psuk1, #form_psuk2, #form_psuk5").serialize();
            var action = $('#post_profil_skuad_uniti_krt').val();
            var btn_text;
            if (action == 'edit') {
                url = tambah_skuad_uniti_config.routes.tambah_skuad_uniti_url;
                type = "POST";
                btn_text = 'Hantar Profil Skuad Uniti &nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
            } 
            $.ajax({
                url: url,
                type: type,
                data: data,
            }).done(function(response) {        
                $('[name=psuk1_skuad_nama]').removeClass("is-invalid");
                $('[name=psuk1_skuad_tarikh_ditubuhkan]').removeClass("is-invalid");
                $('[name=psuk1_skuad_skop_perkhidmatan]').removeClass("is-invalid");
                $('[name=psuk2_skuad_nama_ketua]').removeClass("is-invalid");
                $('[name=psuk2_skuad_phone_ketua]').removeClass("is-invalid");
                $('[name=psuk2_skuad_email_ketua]').removeClass("is-invalid");
                $('[name=psuk2_skuad_ic_ketua]').removeClass("is-invalid");
                $('[name=psuk2_skuad_alamat_ketua]').removeClass("is-invalid");
                $('[name=psuk2_skuad_pekerjaan_ketua]').removeClass("is-invalid");
                $('[name=psuk2_skuad_nama_setiausaha]').removeClass("is-invalid");
                $('[name=psuk2_skuad_phone_setiausaha]').removeClass("is-invalid");
                $('[name=psuk2_skuad_email_setiausaha]').removeClass("is-invalid");
                $('[name=psuk2_skuad_ic_setiausaha]').removeClass("is-invalid");
                $('[name=psuk2_skuad_alamat_setiausaha]').removeClass("is-invalid");
                $('[name=psuk2_skuad_pekerjaan_setiausaha]').removeClass("is-invalid");
                
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        if(index == 'psuk1_skuad_nama') {
                            $('[name=psuk1_skuad_nama]').addClass("is-invalid");
                            $('.error_psuk1_skuad_nama').html(error);
                        }

                        if(index == 'psuk1_skuad_tarikh_ditubuhkan') {
                            $('[name=psuk1_skuad_tarikh_ditubuhkan]').addClass("is-invalid");
                            $('.error_psuk1_skuad_tarikh_ditubuhkan').html(error);
                        }

                        if(index == 'psuk1_skuad_skop_perkhidmatan') {
                            $('[name=psuk1_skuad_skop_perkhidmatan]').addClass("is-invalid");
                            $('.error_psuk1_skuad_skop_perkhidmatan').html(error);
                        }

                        if(index == 'psuk2_skuad_nama_ketua') {
                            $('[name=psuk2_skuad_nama_ketua]').addClass("is-invalid");
                            $('.error_psuk2_skuad_nama_ketua').html(error);
                        }

                        if(index == 'psuk2_skuad_phone_ketua') {
                            $('[name=psuk2_skuad_phone_ketua]').addClass("is-invalid");
                            $('.error_psuk2_skuad_phone_ketua').html(error);
                        }

                        if(index == 'psuk2_skuad_email_ketua') {
                            $('[name=psuk2_skuad_email_ketua]').addClass("is-invalid");
                            $('.error_psuk2_skuad_email_ketua').html(error);
                        }

                        if(index == 'psuk2_skuad_ic_ketua') {
                            $('[name=psuk2_skuad_ic_ketua]').addClass("is-invalid");
                            $('.error_psuk2_skuad_ic_ketua').html(error);
                        }

                        if(index == 'psuk2_skuad_alamat_ketua') {
                            $('[name=psuk2_skuad_alamat_ketua]').addClass("is-invalid");
                            $('.error_psuk2_skuad_alamat_ketua').html(error);
                        }

                        if(index == 'psuk2_skuad_pekerjaan_ketua') {
                            $('[name=psuk2_skuad_pekerjaan_ketua]').addClass("is-invalid");
                            $('.error_psuk2_skuad_pekerjaan_ketua').html(error);
                        }

                        if(index == 'psuk2_skuad_nama_setiausaha') {
                            $('[name=psuk2_skuad_nama_setiausaha]').addClass("is-invalid");
                            $('.error_psuk2_skuad_nama_setiausaha').html(error);
                        }

                        if(index == 'psuk2_skuad_phone_setiausaha') {
                            $('[name=psuk2_skuad_phone_setiausaha]').addClass("is-invalid");
                            $('.error_psuk2_skuad_phone_setiausaha').html(error);
                        }

                        if(index == 'psuk2_skuad_email_setiausaha') {
                            $('[name=psuk2_skuad_email_setiausaha]').addClass("is-invalid");
                            $('.error_psuk2_skuad_email_setiausaha').html(error);
                        }

                        if(index == 'psuk2_skuad_ic_setiausaha') {
                            $('[name=psuk2_skuad_ic_setiausaha]').addClass("is-invalid");
                            $('.error_psuk2_skuad_ic_setiausaha').html(error);
                        }

                        if(index == 'psuk2_skuad_alamat_setiausaha') {
                            $('[name=psuk2_skuad_alamat_setiausaha]').addClass("is-invalid");
                            $('.error_psuk2_skuad_alamat_setiausaha').html(error);
                        }

                        if(index == 'psuk2_skuad_pekerjaan_setiausaha') {
                            $('[name=psuk2_skuad_pekerjaan_setiausaha]').addClass("is-invalid");
                            $('.error_psuk2_skuad_pekerjaan_setiausaha').html(error);
                        }

                    });
                    $('#btn_submit').html(btn_text);                
                    $('#btn_submit').prop('disabled', false);            
                } else {
                    $('#btn_submit').html(btn_text);
                    $('#btn_submit').prop('disabled', false); 
                    window.location.href = "{{route('rt-sm10.profil_skuad_uniti_krt')}}";
                }
            });
        });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
@stop