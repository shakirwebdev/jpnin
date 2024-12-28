@section('page-script')
@include('js.modal.j-modal-arahan-tindakan-ikes')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var arahan_tindakan_ikes_p_config = {
			routes: {
				arahan_tindakan_ikes_p_url: "/rt/sm21/senarai-at-ikes-p"
			}
		}; 

		$("#saip_state_id").on( 'change', function () {
			senarai_permohonan_pelaporan_kes.column('1:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#saip_daerah_id').find('option').remove();
            $('#saip_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: arahan_tindakan_ikes_p_config.routes.arahan_tindakan_ikes_p_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#saip_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#saip_daerah_id')
                            .append($('<option>')
                            .text(obj.daerah_description)
                            .attr('value', obj.daerah_description));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

        $("#saip_daerah_id").on( 'change', function () {
			senarai_permohonan_pelaporan_kes.column('2:visible').search( $(this).val() ).draw();
		}); 
		
		var senarai_permohonan_pelaporan_kes = $('#senarai_permohonan_pelaporan_kes').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: 'l<"pull-right">Brtip',
            buttons: [
              'copy', 'excel', 'pdf', 'print'
            ],
			ajax: {url: arahan_tindakan_ikes_p_config.routes.arahan_tindakan_ikes_p_url},
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
                "width": "13%", 
                "mRender": function ( value, type, full )  {
                    return full.state_description;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "13%", 
                "mRender": function ( value, type, full )  {
                    return full.daerah_description;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "13%", 
                "mRender": function ( value, type, full )  {
                    return full.peringkat_description;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "13%", 
                "mRender": function ( value, type, full )  {
                    return full.kategori_description;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.kluster_description;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
					return full.status_description;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.status == '1') {
                        button_a = '<button type="button" class="btn btn-icon" title="Paparan Pelaporan i-Kes" onclick="paparan_ikes(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        button_b = '<button type="button" class="btn btn-icon" title="Arahan Tindakan Pelaporan i-Kes" onclick="load_arahan_tindakan_ikes(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a + '|' + button_b;
                    } else {
                        button_b = '';
                        return button_b;
                    }
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });
        
    });

	function paparan_ikes(id){
        window.location.href = "{{ route('rt-sm21.paparan_pelaporan_ikes_p','') }}"+"/"+id;
    }

    /* submit arahan tindakan */
		//my custom script
		var add_arahan_tindakan_config = {
			routes: {
				add_arahan_tindakan_url: "{{ route('rt-sm21.post_add_arahan_tindakan_p') }}",
			}
		};

        $(document).on('submit', '#form_matip', function(event){    
			event.preventDefault();
			$('#btn_submit').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_submit').prop('disabled', true);
			var data = $("#form_matip").serialize();
			var action = $('#post_add_arahan_tindakan_p').val();
			var btn_text;
			if (action == 'add') {
				url = add_arahan_tindakan_config.routes.add_arahan_tindakan_url;
				type = "POST";
				btn_text = 'Hantar Arahan Tindakan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i>';
			}

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=matip_tempoh_tindakan]').removeClass("is-invalid");
				$('[name=matip_tarikh_arahan]').removeClass("is-invalid");
				$('[name=matip_jenis_arahan_id]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'matip_tempoh_tindakan') {
							$('[name=matip_tempoh_tindakan]').addClass("is-invalid");
							$('.error_matip_tempoh_tindakan').html(error);
						}

						if(index == 'matip_tarikh_arahan') {
							$('[name=matip_tarikh_arahan]').addClass("is-invalid");
							$('.error_matip_tarikh_arahan').html(error);
						}

						if(index == 'matip_jenis_arahan_id') {
							$('[name=matip_jenis_arahan_id]').addClass("is-invalid");
							$('.error_matip_jenis_arahan_id').html(error);
						}

					});
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);            
				} else {
					$('#modal_arahan_tindakan_ikes').modal('hide');
					swal("Maklumat Arahan Tindakan i-kes ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_matip').trigger("reset");
					$('#btn_submit').html(btn_text);                
					$('#btn_submit').prop('disabled', false);
					$('#senarai_permohonan_pelaporan_kes').DataTable().ajax.reload();
				}
			});
		});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop