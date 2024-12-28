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
        
    	$('#list_mohon_masuk_tabika').DataTable( {
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
                { "width": "70px", "targets": 1},
                { "width": "70px", "targets": 2},
                { "width": "70px", "targets": 3},
				{ "width": "150px", "targets": 4},
				{ "width": "70px", "targets": 5},
				{ "width": "70px", "targets": 6},
                { "width": "150px", "targets": 7},
				{ "width": "50px", "targets": 8, sClass: 'text-center'},
				{ "width": "10px", "targets": 9, sClass: 'text-center', 
					mRender: function (value, type, full) {
                        button_a = '<button type="button" class="btn btn-icon" title="Paparan Permohonan"  data-id="" onclick="jana_surat_pemakluman();"><i class="fa fa-print"></i></button>';
                    return button_a;
                    }
				},
			]
	    });
        
    });

	function jana_surat_pemakluman(){
        window.location.href = '{{route('pdf.surat_pemakluman_tabika')}}';
    }

	var dataSet = [ 
		["1", "TP0909011", "Perlis", "Perlis", "Nur Aina Binti Saharudin", "140508095161" , "Perempuan" , "No,10 Lorong 5 Taman Peladang Jaya, 02000 Kuala Perlis, Perlis" , "Diluluskan Oleh PPD"]
	];

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop