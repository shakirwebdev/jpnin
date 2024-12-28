@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var senarai_permohonan_muhibbah_bpp_config = {
			routes: {
				senarai_permohonan_muhibbah_bpp_url: "/rt/sm22/senarai-permohonan-muhibbah-bpp"
			}
		};   
        
    	var senarai_permohonan_muhibbah = $('#senarai_permohonan_muhibbah').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: 'l<"pull-right">Brtip',
            buttons: [
              'copy', 'excel', 'pdf', 'print'
            ],
			ajax: {url: senarai_permohonan_muhibbah_bpp_config.routes.senarai_permohonan_muhibbah_bpp_url},
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
                    return full.imuhibbah_tajuk;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.imuhibbah_tarikh_laporan;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.imuhibbah_tarikh_j_berlaku;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.user_fullname;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.status_description;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.status == '2') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Permohonan Pelaporan i-Ramal" onclick="kemaskini_permohonan_imuhibbah(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a;
                    }else if (full.status == '15') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Permohonan Pelaporan i-Ramal" onclick="kemaskini_permohonan_imuhibbah(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a;
                    }else if (full.status == '12') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Permohonan Pelaporan i-Ramal" onclick="kemaskini_permohonan_imuhibbah(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
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

	function kemaskini_permohonan_imuhibbah(id){
		window.location.href = "{{ route('rt-sm22.permohonan_muhibbah_bpp','') }}"+"/"+id;
	}

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop