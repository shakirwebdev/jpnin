@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<style type="text/css">
	.series-frame {
	  /*max-width: 600px;*/
	  display: flex;
	  justify-content: space-between;
	  align-items: center;
	  box-sizing: border-box;
	  border: 2px solid #113f50;
	  /*margin: 30px;*/
	  padding: 10px;
	}
</style>
<script type="text/javascript">    
    
	$(document).ready( function () {

		$('#pendidikan_table').DataTable( {
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
        	dom: 'rtip',
        	"bFilter": true,
        	responsive: true,
	        data: dataSetPendidikan,
		    columns: [
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false},
	            {data : null, bSortable: false, sClass: 'text-center',
                    mRender: function (value, type, full) {
                    	button_a = '<label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1"><span class="custom-control-label">&nbsp;</span></label>';
                	return button_a;
                    }
                },
	        ]
	    });

	    
	});

	var dataSetPendidikan = [ 
		["1","Doctor Falsafah (PHD)"],
		["2","Sarjana"],
		["3","Sarjana Muda"],
		["4","Diploma"],
		["5","STPM dan Setaraf"],
		["6","SPM / SPVM & Setaraf"],
		["7","PMR / SRP & Setaraf"],
		["8","Sekolah Rendah"],
		["9","Lain - Lain"]
	];

	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop