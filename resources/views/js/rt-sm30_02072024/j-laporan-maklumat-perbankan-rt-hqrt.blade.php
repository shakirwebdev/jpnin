@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	$(document).ready( function () {

		$('#laporan_binaan_tumpang_rt').DataTable( {
    		processing: true,
			// serverSide: true,
        	"language": {
	            "paginate": {
	                "previous": "Sebelumnya",
	                "next": "Seterusnya",
	            },
	            "sSearch": "Carian",
	            "sLengthMenu": "Paparan _MENU_ rekod",
	            "lengthMenu": "Paparan _MENU_ rekod setiap laman",
	            "zeroRecords": "Tiada rekod ditemui",
	            "info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
	            "infoEmpty": "",
	            "infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
        	},
			"AutoWidth" : false,
			scrollX:        true,
			scrollCollapse: true,
        	dom: 'rtip',
        	"bFilter": true,
        	responsive: true,
			data: dataSet,
			"columnDefs": [
				{ "width": "10px", "targets": 0 , sClass: 'text-center'},
                { "width": "150px", "targets": 1 },
                { "width": "150px", "targets": 2 },
                { "width": "200px", "targets": 3 },
				{ "width": "100px", "targets": 4 , sClass: 'text-center'},
				{ "width": "100px", "targets": 5 , sClass: 'text-center'},
                { "width": "50px", "targets": 6 , sClass: 'text-center'},
                { "width": "50px", "targets": 7 , sClass: 'text-center'},
				{ "width": "50px", "targets": 8 , sClass: 'text-center'}
            ]
	    });
        
    });

	var dataSet = [ 
		["1", "Perlis", "Perlis", "KRT Taman Peladang Jaya", "1000264812362", "Mybank" , "10000", "2000", "12000", ],
        ["2", "Perlis", "Perlis", "KRT Taman Peladang Jaya", "1000264812362" , "Mybank" , "12000", "2000", "14000",  ]
	];

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop