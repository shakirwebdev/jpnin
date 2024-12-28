@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_maklumat_asas_config = {
			routes: {
				laporan_maklumat_asas_url: "/rt/sm30/laporan-maklumat-asas-krt-3-ppd"
			}
		}; 

		var laporan_maklumat_asas_rt_3 = $('#laporan_maklumat_asas_rt_3').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: '<"top"B><"pull-right"l>rtip',
            buttons: [
                {
                    extend: 'csvHtml5'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Laporan Maklumat Asas RT',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            ajax: {url: laporan_maklumat_asas_config.routes.laporan_maklumat_asas_url},
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
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                    return  meta.row+1;
                }
            },{          
                "aTargets": [ 1 ], 
                "width": "100px", 
                "mRender": function ( value, type, full )  {
                    return full.state;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "100px", 
                "mRender": function ( value, type, full )  {
                    return full.daerah;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "150px", 
                "mRender": function ( value, type, full )  {
                    return full.krt_nama;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_r_sebuah;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "10px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.total_r_teres;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "10px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.total_r_kampung;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "10px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.total_r_stinggan;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "10px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.total_r_berkembar;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "10px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.total_r_flat;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_r_kondo;
                }
            },{          
                "aTargets": [ 11 ], 
                "width": "10px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.total_r_apartment;
                }
            },{          
                "aTargets": [ 12 ], 
                "width": "10px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.total_r_kedai;
                }
            },{          
                "aTargets": [ 13 ], 
                "width": "200px", 
				"mRender": function ( value, type, full )  {
					return full.kemudahan_awam;
                }
            },{          
                "aTargets": [ 14 ], 
                "width": "200px", 
				"mRender": function ( value, type, full )  {
					return full.kes_jenayah;
                }
            },{          
                "aTargets": [ 15 ], 
                "width": "200px", 
				"mRender": function ( value, type, full )  {
					return full.maslah_sosial;
                }
            },{          
                "aTargets": [ 16 ], 
                "width": "200px", 
				"mRender": function ( value, type, full )  {
					return full.kawasan_pertanian;
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