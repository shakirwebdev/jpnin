@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_aktiviti_2_config = {
			routes: {
				laporan_aktiviti_2_url: "/rt/sm30/laporan-aktiviti-rt-2-ppn"
			}
		}; 

        $("#larpn_daerah_id").on( 'change', function () {
			laporan_aktiviti_2.column('1:visible').search( $(this).val() ).draw();
		});

        
		var laporan_aktiviti_2 = $('#laporan_aktiviti_2').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: '<"top"B><"pull-right"l>rtip',
            buttons: [
                {
                    extend: 'csvHtml5'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Laporan Aktiviti RT',
                    orientation: 'landscape',
                    pageSize: 'LETTER',
					customize:  function (doc) {
                    doc.layout = 'lightHorizotalLines;'
                    doc.pageMargins = [20, 20, 20, 20];
                    doc.defaultStyle.fontSize = 11;
                    doc.styles.tableHeader.fontSize = 11;
                    doc.styles.title.fontSize = 14;
 
                    // How do I set column widths to [100,150,150,100,100,'*']  ?
 
            }
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            ajax: {url: laporan_aktiviti_2_config.routes.laporan_aktiviti_2_url},
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
                    return full.krt_name;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.penganjur;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.tajuk_aktiviti;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.total_lelaki;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.total_perempuan;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.total_umur_1;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.total_umur_2;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.total_umur_3;
                }
            },{          
                "aTargets": [ 11 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.total_umur_4;
                }
            },{          
                "aTargets": [ 12 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.total_umur_5;
                }
            },{          
                "aTargets": [ 13 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.total_umur_6;
                }
            },{          
                "aTargets": [ 14 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.total_umur_7;
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