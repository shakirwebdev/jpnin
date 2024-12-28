@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var permohonan_pelaporan_ikes_config = {
			routes: {
				permohonan_pelaporan_ikes_url: "/rt/sm21/senarai-permohonan-ikes"
			}
		};   
        
    	var senarai_permohonan_pelaporan_ikes = $('#senarai_permohonan_pelaporan_ikes').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: 'l<"pull-right">Brtip',
            buttons: [
              'copy', 'excel', 'pdf', 'print'
            ],
			ajax: {url: permohonan_pelaporan_ikes_config.routes.permohonan_pelaporan_ikes_url},
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
                    return full.peringkat_description;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.kategori_description;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.kategori_description;
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
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Permohonan Pelaporan Kes" onclick="kemaskini_permohonan_ikes(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a;
                    }else if (full.status == '5') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Permohonan Pelaporan Kes" onclick="kemaskini_permohonan_ikes(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a;
                    }else if (full.status == '7') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Permohonan Pelaporan Kes" onclick="kemaskini_permohonan_ikes(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a;
                    }else if (full.status == '8') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Permohonan Pelaporan Kes" onclick="kemaskini_permohonan_ikes(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
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

	function kemaskini_permohonan_ikes(id){
		window.location.href = "{{ route('rt-sm21.permohonan_ikes','') }}"+"/"+id;
	}

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop