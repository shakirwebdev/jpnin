@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<style>
	
}
</style>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_penduduk_rt_kaum_config = {
			routes: {
				laporan_penduduk_rt_kaum_url: "/rt/sm30/laporan-penduduk-rt-kaum-hqrt"
			}
		};   
        
    	$('#bilangan_penduduk_mengikut_kaum').DataTable( {
    		processing: true,
			"autoWidth": false,
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
        	dom: 'rtip',
        	"bFilter": true,
        	responsive: true,
			data: dataSet,
			"columnDefs": [
				{ "width": "10px", "targets": 0 , sClass: 'text-center'},
                { "width": "70px", "targets": 1 },
                { "width": "70px", "targets": 2 },
                { "width": "100px", "targets": 3 },
				{ "width": "40px", "targets": 4 , sClass: 'text-center'},
				{ "width": "40px", "targets": 5 , sClass: 'text-center'},
				{ "width": "40px", "targets": 6 , sClass: 'text-center'},
				{ "width": "40px", "targets": 7 , sClass: 'text-center'},
				{ "width": "40px", "targets": 8 , sClass: 'text-center'},
				{ "width": "40px", "targets": 9 , sClass: 'text-center'},
				{ "width": "40px", "targets": 10 , sClass: 'text-center'},
			]
	    });
        
    });

	var dataSet = [ 
		["1", "Perlis", "Perlis", "KRT Taman Peladang Jaya", "150", "60", "30", "0", "0", "0", "240"],
        ["2", "Perlis", "Perlis", "KRT Taman Semarak", "180", "20", "0", "0", "0", "0", "200"]
	];

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop