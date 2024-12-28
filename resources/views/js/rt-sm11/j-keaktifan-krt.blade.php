@include('js.modal.j-modal-add-markah-keaktifan-krt')
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">    
    
	$(document).ready( function () {

		//my custom script
		var senarai_keaktifan_krt_config = {
			routes: {
				senarai_keaktifan_krt_url: "/rt/sm11/keaktifan-krt"
			}
		};

        var senarai_keaktifan_krt = $('#senarai_keaktifan_krt').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_keaktifan_krt_config.routes.senarai_keaktifan_krt_url},
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
                "width": "4%", 
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                    return  meta.row+1;
                }
            },{          
                "aTargets": [ 1 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.nama_krt;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "12%", 
                "mRender": function ( value, type, full )  {
                    return full.no_rujukan_krt;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "4%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.bil_ajk;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "6%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.bil_mesyuarat;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "6%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.bil_aktiviti;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "6%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.bil_kewangan;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "6%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.bil_cawangan;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "4%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.bil_srs;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "6%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.markah + '%';
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "6%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.status;
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