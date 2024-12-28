@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_ikes_kategori_config = {
			routes: {
				laporan_ikes_kategori_url: "/rt/sm32/laporan-bulanan-ikes-kp"
			}
		}; 

		var statistik_ikes_kategori = $('#statistik_ikes_kategori').DataTable( {
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
            ajax: {url: laporan_ikes_kategori_config.routes.laporan_ikes_kategori_url},
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
                var info = statistik_ikes_kategori.page.info();
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
                    return full.month;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "10px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
                    return full.total_keganasan;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_rusuhan;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_demonstrasi;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_protes_1;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_protes_2;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_protes_3;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_protes_4;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_protes_5;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_pergaduhan;
                }
            },{          
                "aTargets": [ 11 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_serangan_1;
                }
            },{          
                "aTargets": [ 12 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_serangan_2;
                }
            },{          
                "aTargets": [ 13 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_serangan_3;
                }
            },{          
                "aTargets": [ 14 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_serangan_4;
                }
            },{          
                "aTargets": [ 15 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_serangan_5;
                }
            },{          
                "aTargets": [ 16 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_serangan_6;
                }
            },{          
                "aTargets": [ 17 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_isu;
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