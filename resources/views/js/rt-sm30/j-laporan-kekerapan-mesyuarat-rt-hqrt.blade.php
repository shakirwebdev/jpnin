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
				{ "width": "50px", "targets": 4 , sClass: 'text-center'},
				{ "width": "100px", "targets": 5 , sClass: 'text-center'},
                { "width": "200px", "targets": 6 },
                { "width": "300px", "targets": 7 },
				{ "width": "150px", "targets": 8 },
                { "width": "50px", "targets": 9 , sClass: 'text-center'}
				
			]
	    });
        
    });

	var dataSet = [ 
		["1", "Perlis", "Perlis", "KRT Taman Peladang Jaya", "1", "10/10/2019" , "Penubuhan KRT", "No,3 Taman Peladang Jaya 02000 Kuala Perlis, Perlis", "Mohamad Shauki Bin Sahardi","50" ],
        ["2", "Perlis", "Perlis", "KRT Taman Peladang Jaya", "2" , "15/10/2019" , "Pelantikan AJK KRT", "No,3 Taman Peladang Jaya 02000 Kuala Perlis, Perlis", "Mohamad Shauki Bin Sahardi", "73" ]
	];

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop