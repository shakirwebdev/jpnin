@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_ikes_kluster_config = {
			routes: {
				laporan_ikes_kluster_url: "/rt/sm32/laporan-ikes-kluster-p"
			}
		}; 

		var laporan_kluster_ikes = $('#laporan_kluster_ikes').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: '<"top"B><"pull-right"l>rtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    title: 'Statistik Bulanan i-Kes Mengikut Bulanan',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                },
                {
                    extend: 'csvHtml5',
					exportOptions: {
						columns: "thead th:not(.noExport)",
						rows: function (indx, rowData, domElement) {
							return $(domElement).css("display") != "none";
						}
					}
                }
                
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            iDisplayLength: -1,
            ajax: {url: laporan_ikes_kluster_config.routes.laporan_ikes_kluster_url},
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
            rowCallback: function(nRow, aData, index) {
                var info = laporan_kluster_ikes.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
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
                    return full.kluster;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "150px",
                "mRender": function ( value, type, full )  {
                    return full.sub_kluster;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_jan;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_feb;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_mar;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_may;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_jun;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_jul;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_aug;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_sep;
                }
            },{          
                "aTargets": [ 11 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_oct;
                }
            },{          
                "aTargets": [ 12 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_nov;
                }
            },{          
                "aTargets": [ 13 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_dec;
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