@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_berisiko_ikes_config = {
			routes: {
				laporan_berisiko_ikes_1_url: "{{ route('rt-sm32.laporan_berisiko_ikes_ppd') }}",
				laporan_berisiko_ikes_2_url: "{{ route('rt-sm32.laporan_berisiko_ikes_2_ppd') }}",
				laporan_berisiko_ikes_3_url: "{{ route('rt-sm32.laporan_berisiko_ikes_3_ppd') }}"
			}
		}; 

		var laporan_ikes_hotspot = $('#laporan_ikes_hotspot').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: '<"top"B><"pull-right"l>rtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    title: 'Statistik Kawasan Berisiko i-Kes (HOTSPOT)',
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
            ajax: {url: laporan_berisiko_ikes_config.routes.laporan_berisiko_ikes_1_url},
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
                var info = laporan_ikes_hotspot.page.info();
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
                    return full.state;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "10px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
                    return full.total_a_s1;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_a_s2;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_a_s3;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_a_s4;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_b_s1;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_b_s2;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_b_s3;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_b_s4;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_c_s1;
                }
            },{          
                "aTargets": [ 11 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_c_s2;
                }
            },{          
                "aTargets": [ 12 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_c_s3;
                }
            },{          
                "aTargets": [ 13 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_c_s4;
                }
            },{          
                "aTargets": [ 14 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_all;
                }
            },{          
                "aTargets": [ 15 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.purata;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });

		var laporan_ikes_tension = $('#laporan_ikes_tension').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: '<"top"B><"pull-right"l>rtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    title: 'Statistik Kawasan Berisiko i-Kes (TENSION POINT)',
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
            ajax: {url: laporan_berisiko_ikes_config.routes.laporan_berisiko_ikes_2_url},
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
                var info = laporan_ikes_tension.page.info();
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
                    return full.state;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "10px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
                    return full.total_a_s1;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_a_s2;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_a_s3;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_a_s4;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_b_s1;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_b_s2;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_b_s3;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_b_s4;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_c_s1;
                }
            },{          
                "aTargets": [ 11 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_c_s2;
                }
            },{          
                "aTargets": [ 12 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_c_s3;
                }
            },{          
                "aTargets": [ 13 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_c_s4;
                }
            },{          
                "aTargets": [ 14 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_all;
                }
            },{          
                "aTargets": [ 15 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.purata;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });

		var laporan_ikes_paint = $('#laporan_ikes_paint').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: '<"top"B><"pull-right"l>rtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    title: 'Statistik Kawasan Berisiko i-Kes (PAINT POINt)',
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
            ajax: {url: laporan_berisiko_ikes_config.routes.laporan_berisiko_ikes_3_url},
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
                var info = laporan_ikes_paint.page.info();
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
                    return full.state;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "10px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
                    return full.total_a_s1;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_a_s2;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_a_s3;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_a_s4;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_b_s1;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_b_s2;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_b_s3;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_b_s4;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_c_s1;
                }
            },{          
                "aTargets": [ 11 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_c_s2;
                }
            },{          
                "aTargets": [ 12 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_c_s3;
                }
            },{          
                "aTargets": [ 13 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_c_s4;
                }
            },{          
                "aTargets": [ 14 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_all;
                }
            },{          
                "aTargets": [ 15 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.purata;
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