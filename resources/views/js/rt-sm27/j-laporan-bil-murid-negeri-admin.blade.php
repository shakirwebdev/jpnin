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
                { "width": "100px", "targets": 1},
                { "width": "100px", "targets": 2},
                { "width": "250px", "targets": 3},
				{ "width": "10px", "targets": 4, sClass: 'text-center'}
			]
	    });
        
    });

	var dataSet = [ 
		["1", "Perlis", "Perlis", "Tabika Perpaduan Kuala Perlis", "13"],
        ["2", "Perlis", "Perlis", "Tabika Perpaduan Frangi Pani", "14"],
        ["3", "Perlis", "Perlis", "Tabika Perpaduan Melati", "20"],
        ["4", "Perlis", "Perlis", "Tabika Perpaduan Callalily", "26"],
        ["4", "Perlis", "Perlis", "Tabika Perpaduan Angsana", "17"],
        ["5", "Perlis", "Perlis", "Tabika Perpaduan Bunga Raya", "23"],
        ["6", "Perlis", "Perlis", "Tabika Perpaduan Mawar", "30"],
        ["7", "Perlis", "Perlis", "Tabika Perpaduan Tulip", "20"],
        ["8", "Perlis", "Perlis", "Tabika Perpaduan Orkid", "19"],
        ["9", "Perlis", "Perlis", "Tabika Perpaduan Kekwa", "40"]
	];

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop