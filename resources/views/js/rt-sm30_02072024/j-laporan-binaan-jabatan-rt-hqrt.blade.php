@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<style>
	
	
</style>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_penduduk_rt_kaum_config = {
			routes: {
				laporan_penduduk_rt_kaum_url: "/rt/sm30/laporan-penduduk-rt-kaum-hqrt"
			}
		};   
        
    	$('#laporan_binaan_jabatan_rt').DataTable( {
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
				{ "width": "200px", "targets": 4},
				{ "width": "350px", "targets": 5},
				{ "width": "40px", "targets": 6, sClass: 'text-center'},
                { "width": "40px", "targets": 7, sClass: 'text-center'},
				{ "width": "70px", "targets": 8, sClass: 'text-center'},
				{ "width": "70px", "targets": 9 },
				{ "width": "150px", "targets": 10 }
			]
	    });
        
    });

	var dataSet = [ 
		["1", "Perlis", "Perlis", "KRT Taman Peladang Jaya", "Kompleks Perpaduan", "No,3 Taman Peladang Jaya 02000 Kuala Perlis, Perlis" , "123" , "123" , "132", "RT,SRS,Tabika,Taska", "Tanah Kerajaan Persekutuan"],
        ["2", "Perlis", "Perlis", "KRT Taman Peladang Jaya", "Pusat Aktiviti Perpaduan" , "No,3 Taman Peladang Jaya 02000 Kuala Perlis, Perlis" , "30000" , "12345", "132", "RT,SRS,Tabika,Taska", "Tanah Kerajaan Persekutuan"]
	];

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop