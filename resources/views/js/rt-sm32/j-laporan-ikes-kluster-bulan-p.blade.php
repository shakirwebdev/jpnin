@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_ikes_kluster_bulan_config = {
			routes: {
				laporan_ikes_kluster_bulan_url: "/rt/sm32/laporan-ikes-kluster-bulan-p"
			}
		}; 

		var statistik_ikes_kluster_bulan = $('#statistik_ikes_kluster_bulan').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: '<"top"><"pull-right"l>rtip',
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            iDisplayLength: -1,
            ajax: {url: laporan_ikes_kluster_bulan_config.routes.laporan_ikes_kluster_bulan_url},
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
                var info = statistik_ikes_kluster_bulan.page.info();
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
                    return full.total_jan_1;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_feb_1;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_mac_1;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_apr_1;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_may_1;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "10px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
                    return full.total_jun_1;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_jul_1;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_aug_1;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_sep_1;
                }
            },{          
                "aTargets": [ 11 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_oct_1;
                }
            },{          
                "aTargets": [ 12 ], 
                "width": "10px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
                    return full.total_nov_1;
                }
            },{          
                "aTargets": [ 13 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_dec_1;
                }
            },{          
                "aTargets": [ 14 ], 
                "width": "10px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
                    return full.total_jan_2;
                }
            },{          
                "aTargets": [ 15 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_feb_2;
                }
            },{          
                "aTargets": [ 16 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_mac_2;
                }
            },{          
                "aTargets": [ 17 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_apr_2;
                }
            },{          
                "aTargets": [ 18 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_may_2;
                }
            },{          
                "aTargets": [ 19 ], 
                "width": "10px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
                    return full.total_jun_2;
                }
            },{          
                "aTargets": [ 20 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_jul_2;
                }
            },{          
                "aTargets": [ 21 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_aug_2;
                }
            },{          
                "aTargets": [ 22 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_sep_2;
                }
            },{          
                "aTargets": [ 23 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_oct_2;
                }
            },{          
                "aTargets": [ 24 ], 
                "width": "10px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
                    return full.total_nov_2;
                }
            },{          
                "aTargets": [ 25 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_dec_2;
                }
            },{          
                "aTargets": [ 26 ], 
                "width": "10px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
                    return full.total_jan_3;
                }
            },{          
                "aTargets": [ 27 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_feb_3;
                }
            },{          
                "aTargets": [ 28 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_mac_3;
                }
            },{          
                "aTargets": [ 29 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_apr_3;
                }
            },{          
                "aTargets": [ 30 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_may_3;
                }
            },{          
                "aTargets": [ 31 ], 
                "width": "10px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
                    return full.total_jun_3;
                }
            },{          
                "aTargets": [ 32 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_jul_3;
                }
            },{          
                "aTargets": [ 33 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_aug_3;
                }
            },{          
                "aTargets": [ 34 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_sep_3;
                }
            },{          
                "aTargets": [ 35 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_oct_3;
                }
            },{          
                "aTargets": [ 36 ], 
                "width": "10px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
                    return full.total_nov_3;
                }
            },{          
                "aTargets": [ 37 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_dec_3;
                }
            },{          
                "aTargets": [ 38 ], 
                "width": "10px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
                    return full.total_jan_4;
                }
            },{          
                "aTargets": [ 39 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_feb_4;
                }
            },{          
                "aTargets": [ 40 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_mac_4;
                }
            },{          
                "aTargets": [ 41 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_apr_4;
                }
            },{          
                "aTargets": [ 42 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_may_4;
                }
            },{          
                "aTargets": [ 43 ], 
                "width": "10px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
                    return full.total_jun_4;
                }
            },{          
                "aTargets": [ 44 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_jul_4;
                }
            },{          
                "aTargets": [ 45 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_aug_4;
                }
            },{          
                "aTargets": [ 46 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_sep_4;
                }
            },{          
                "aTargets": [ 47 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_oct_4;
                }
            },{          
                "aTargets": [ 48 ], 
                "width": "10px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
                    return full.total_nov_4;
                }
            },{          
                "aTargets": [ 49 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_dec_4;
                }
            },{          
                "aTargets": [ 50 ], 
                "width": "10px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
                    return full.total_jan_5;
                }
            },{          
                "aTargets": [ 51 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_feb_5;
                }
            },{          
                "aTargets": [ 52 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_mac_5;
                }
            },{          
                "aTargets": [ 53 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_apr_5;
                }
            },{          
                "aTargets": [ 54 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_may_5;
                }
            },{          
                "aTargets": [ 55 ], 
                "width": "10px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
                    return full.total_jun_5;
                }
            },{          
                "aTargets": [ 56 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_jul_5;
                }
            },{          
                "aTargets": [ 57 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_aug_5;
                }
            },{          
                "aTargets": [ 58 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_sep_5;
                }
            },{          
                "aTargets": [ 59 ], 
                "width": "10px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_oct_5;
                }
            },{          
                "aTargets": [ 60 ], 
                "width": "10px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
                    return full.total_nov_5;
                }
            },{          
                "aTargets": [ 61 ], 
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.total_dec_5;
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