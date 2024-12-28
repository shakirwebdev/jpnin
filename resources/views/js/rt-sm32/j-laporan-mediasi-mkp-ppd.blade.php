@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_mediasi_mkp_config = {
			routes: {
				laporan_mediasi_mkp_url: "/rt/sm32/laporan-mediasi-mkp-ppd"
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
                    title: 'Laporan Kes Mediasi',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
			ajax: {url: laporan_mediasi_mkp_config.routes.laporan_mediasi_mkp_url},
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
                    return full.state_description;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
                    return full.daerah_description;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
                    return full.parlimen_description;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
                    return full.dun_description;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
                    return full.pbt_description;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.mediasi_tarikh;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.nama_mediator;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.mediasi_pembantu_nama;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.mediasi_alamat;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.kluster;
                }
            },{          
                "aTargets": [ 11 ], 
                "width": "100px", 
                "mRender": function ( value, type, full )  {
					return full.mediasi_ringkasan_kes;
                }
            },{          
                "aTargets": [ 12 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.status_description;
                }
            },{          
                "aTargets": [ 13 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.mediasi_ngo_terlibat;
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