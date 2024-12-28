@include('js.modal.j-modal-add-pemakluman-operasi-rondaan')
@include('js.modal.j-modal-view-pemakluman-operasi-rondaan')
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">    
    
    $(document).ready( function () {
        
    	//my custom script
        var senarai_ops_rondaan_config = {
            routes: {
                senarai_ops_rondaan_config_url: "/rt/sm14/pemakluman-ops-rondaan-srs"
            }
        };

        var senarai_pemakluman_ops_rondaan = $('#senarai_pemakluman_ops_rondaan').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_ops_rondaan_config.routes.senarai_ops_rondaan_config_url},
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
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.nama_krt;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.nama_srs;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.ops_tarikh_mula_ronda;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.ops_tarikh_surat;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
					return full.direkod_date;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.user_fullname;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    button_a = '<button type="button" class="btn btn-icon" title="Paparan Pemakluman Operasi Rondaan" onclick="load_view_pemakluman_operasi_rondaan(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
					button_b = '<button type="button" class="btn btn-icon" title="Buang Maklumat" id="delete_pemakluman_operasi_rondaan" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
                    return button_a + button_b;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });
        
    });

    //add Pemakluman_rondaan
		//my custom script
		var add_ops_rondaan_config = {
			routes: {
				add_ops_rondaan_url: "{{ route('rt-sm14.add_pemakluman_ops_rondaan') }}",
			}
		};

		$(document).on('submit', '#form_mapor', function(event){    
			event.preventDefault();
			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save').prop('disabled', true);
			var data = $("#form_mapor").serialize();
			var action = $('#add_pemakluman_ops_rondaan').val();
			var btn_text;
			if (action == 'add') {
				url = add_ops_rondaan_config.routes.add_ops_rondaan_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
			}

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=mapor_srs_profile_id]').removeClass("is-invalid");
				$('[name=mapor_ops_tarikh_mula_ronda]').removeClass("is-invalid");
				$('[name=mapor_ops_tarikh_surat]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'mapor_srs_profile_id') {
							$('[name=mapor_srs_profile_id]').addClass("is-invalid");
							$('.error_mapor_srs_profile_id').html(error);
						}

						if(index == 'mapor_ops_tarikh_mula_ronda') {
							$('[name=mapor_ops_tarikh_mula_ronda]').addClass("is-invalid");
							$('.error_mapor_ops_tarikh_mula_ronda').html(error);
						}

						if(index == 'mapor_ops_tarikh_surat') {
							$('[name=mapor_ops_tarikh_surat]').addClass("is-invalid");
							$('.error_mapor_ops_tarikh_surat').html(error);
						}

					});
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);            
				} else {
					$('#modal_add_pemakluman_operasi_rondaan').modal('hide');
					swal("Maklumat Pemakluman Operasi Rondaan Ada ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_mapor').trigger("reset");
					$('#senarai_pemakluman_ops_rondaan').DataTable().ajax.reload();
				}
			});
		});

    // click delete Pemakluman_rondaan
        //my custom script
        delete_pemakluman_operasi_rondaan 	= "{{ route('rt-sm14.delete_pemakluman_ops_rondaan','') }}";

		$('body').on('click', '#delete_pemakluman_operasi_rondaan', function () {
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
						url: delete_pemakluman_operasi_rondaan +"/" + delete_id,
						success: function (data) {
							$('#senarai_pemakluman_ops_rondaan').DataTable().ajax.reload();
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

    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop