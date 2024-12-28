@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_kluster_mediasi_mkp_config = {
			routes: {
				laporan_kluster_mediasi_mkp_url: "/rt/sm32/laporan-kluster-mediasi-mkp-upmk"
			}
		}; 

        var laporan_mediasi_mk = $('#laporan_mediasi_mk').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: '<"top"B><"pull-right"l>rtip',
            buttons: [
                {
                    extend: 'csvHtml5'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Laporan Kluster Kes Mediasi',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            iDisplayLength: -1,
			ajax: {url: laporan_kluster_mediasi_mkp_config.routes.laporan_kluster_mediasi_mkp_url},
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
                "width": "30px", 
                "mRender": function ( value, type, full )  {
                    return full.state;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "30px", 
                "mRender": function ( value, type, full )  {
                    return full.total_kejiranan;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "30px", 
                "mRender": function ( value, type, full )  {
                    return full.total_keluarga;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "30px", 
                "mRender": function ( value, type, full )  {
                    return full.total_harta;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "30px", 
                "mRender": function ( value, type, full )  {
                    return full.total_alamsekitar;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "30px", 
                "mRender": function ( value, type, full )  {
					return full.total_kepenggunaan;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "30px", 
                "mRender": function ( value, type, full )  {
					return full.total_kesihatan;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "30px", 
                "mRender": function ( value, type, full )  {
					return full.total_kontrak;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "30px", 
                "mRender": function ( value, type, full )  {
					return full.total_intelek;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "30px", 
                "mRender": function ( value, type, full )  {
					return full.total_pembinaan;
                }
            },{          
                "aTargets": [ 11 ], 
                "width": "30px", 
                "mRender": function ( value, type, full )  {
					return full.total_agama;
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