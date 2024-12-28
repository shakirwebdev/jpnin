@include('js.modal.j-modal-add-penarikan-diri-srs')
@include('js.modal.j-modal-view-penarikan-diri-srs')
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 
    
	$(document).ready( function () {
        
    	//my custom script
        var senarai_penarikan_diri_config = {
            routes: {
                senarai_penarikan_diri_url: "/rt/sm18/permohonan-penarikan-diri-ahli-srs"
            }
        };

        var senarai_penarikan_diri_ahli = $('#senarai_penarikan_diri_ahli').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_penarikan_diri_config.routes.senarai_penarikan_diri_url},
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
                    return full.nama_peronda;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.ic_peronda;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
                    return full.direkod_date;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.direkod_oleh;
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
                    button_a = '<button type="button" class="btn btn-icon" title="Paparan Penarikan Diri Ahli Peronda SRS" onclick="load_view_penarikan_diri_srs(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });
        
    });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop