@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var semakan_permohonan_muhibbah_bpp_config = {
			routes: {
				semakan_permohonan_muhibbah_bpp_url: "/rt/sm22/senarai-semakan-permohonan-muhibbah-bpp"
			}
		}; 

        $("#smpmp_state_id").on( 'change', function () {
			senarai_permohonan_muhibbah.column('1:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#smpmp_daerah_id').find('option').remove();
            $('#smpmp_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: semakan_permohonan_muhibbah_bpp_config.routes.semakan_permohonan_muhibbah_bpp_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#smpmp_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#smpmp_daerah_id')
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

        $("#smpmp_daerah_id").on( 'change', function () {
			senarai_permohonan_muhibbah.column('2:visible').search( $(this).val() ).draw();
		});  
        
    	var senarai_permohonan_muhibbah = $('#senarai_permohonan_muhibbah').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: 'l<"pull-right">Brtip',
            buttons: [
              'copy', 'excel', 'pdf', 'print'
            ],
			ajax: {url: semakan_permohonan_muhibbah_bpp_config.routes.semakan_permohonan_muhibbah_bpp_url},
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
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.state_description;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.daerah_description;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.imuhibbah_tajuk;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.imuhibbah_tarikh_laporan;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.imuhibbah_tarikh_j_berlaku;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.user_fullname;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.status_description;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.status == '4') {
                        button_a = '<button type="button" class="btn btn-icon" title="Semakan Permohonan Pelaporan i-Ramal" onclick="semakan_permohonan_imuhibbah(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a;
                    }else if (full.status == '9') {
                        button_a = '<button type="button" class="btn btn-icon" title="Semakan Permohonan Pelaporan i-Ramal" onclick="semakan_permohonan_imuhibbah(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a;
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

	function semakan_permohonan_imuhibbah(id){
		window.location.href = "{{ route('rt-sm22.semakan_permohonan_muhibbah_bpp','') }}"+"/"+id;
	}

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop