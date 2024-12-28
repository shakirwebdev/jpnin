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
        
    	$('#list_bil_murid').DataTable( {
    		processing: true,
			// serverSide: true,
            "pageLength": 50,
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
                { "width": "150px", "targets": 1},
                { "width": "70px", "targets": 2 , sClass: 'text-center'},
                { "width": "70px", "targets": 3 , sClass: 'text-center'},
				{ "width": "70px", "targets": 4 , sClass: 'text-center'},
                { "width": "70px", "targets": 5 , sClass: 'text-center'},
                { "width": "70px", "targets": 6 , sClass: 'text-center'},
                { "width": "70px", "targets": 7 , sClass: 'text-center'},
                { "width": "10px", "targets": 8 , sClass: 'text-center'}
			]
	    });
        
    });

	var dataSet = [ 
		["1", "Perlis", "230", "30", "20", "0", "0", "40", "120"],
        ["2", "Pulau Pinang", "100", "90", "70", "0", "0", "0", "260"],
        ["3", "Kedah", "170", "0", "70", "0", "0", "0", "240"],
        ["4", "Kelantan", "100", "100", "100", "0", "0", "0", "300"],
        ["5", "Terangganu", "90", "15", "15", "0", "0", "0", "120"],
        ["6", "Pahang", "200", "50", "20", "0", "0", "0", "270"],
        ["7", "Perak", "400", "100", "200", "0", "0", "0", "700"],
        ["8", "Melaka", "100", "100", "150", "0", "0", "0", "350"],
        ["9", "N.Sembilan", "270", "30", "50", "0", "0", "0", "350"],
        ["10", "Selangor", "700", "300", "200", "0", "0", "50", "1250"],
        ["11", "WP Kuala Lumpur", "70", "50", "60", "0", "0", "0", "180"],
        ["12", "WP Putrajaya", "100", "0", "0", "0", "0", "0", "100"],
        ["13", "Johor", "230", "200", "0", "0", "0", "0", "430"],
        ["14", "Sarawak", "400", "200", "100", "100", "50", "0", "850"],
        ["15", "Sabah", "400", "200", "0", "0", "0", "0", "600"],
        ["16", "WP Labuan", "400", "200", "0", "0", "0", "0", "600"],
	];

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop