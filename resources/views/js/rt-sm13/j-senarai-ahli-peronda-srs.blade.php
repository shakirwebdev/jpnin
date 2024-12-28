@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {

		//my custom script
			var senarai_ahli_peronda_config = {
			routes: {
				senarai_senarai_ahli_peronda_config_url: "/rt/sm13/senarai-ahli-peronda-srs"
			}
		};
        
		var senarai_ahli_peronda_srs_table = $('#senarai_ahli_peronda_srs_table').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_ahli_peronda_config.routes.senarai_senarai_ahli_peronda_config_url},
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
                    return full.nama_srs;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.ahli_peronda_nama;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.ahli_peronda_ic;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "6%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.ahli_peronda_umur;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "28%", 
                "mRender": function ( value, type, full )  {
					return full.ahli_peronda_alamat;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.ahli_peronda_status;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.status == '1') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Pendaftaran Ahli Peronda SRS" onclick="kemaskini_ahli_peronda_srs(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a;
                    }else if (full.status == '2') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Pendaftaran Ahli Peronda SRS" onclick="kemaskini_ahli_peronda_srs(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
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

	function kemaskini_ahli_peronda_srs(id){
		window.location.href = "{{ route('rt-sm13.ahli_peronda_srs','') }}"+"/"+id;
	}

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop