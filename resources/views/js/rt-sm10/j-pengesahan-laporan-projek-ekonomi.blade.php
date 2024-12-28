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
        
    	$('#peserta_table').DataTable( {
    		processing: true,
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
        	dom: 'rtip',
        	"bFilter": true,
        	responsive: true,
	        data: dataSetPeserta,
		    columns: [
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false},
	            {bSortable: false},
	        ]
	    });

    });

    var dataSetPeserta = [ 
		["1", "Mohamad Shauki Bin Sahardi", "930508095161"],
		["2", "Khairul Mustakim Bin Mustaffa Kamal", "930508095262"],
		["3", "Nurkhalis Syafiq Bin Md Zain", "830508065262"],
		["4", "Amzar bin Yussoff", "800508065262"],
		["5", "Nurizaty Binti Zulkipli", "900508065262"],
		["6", "Mohamad Fairuz Bin Rahman", "820508065262"],
		["7", "Shahadan Bin Man", "720508065262"],
		["8", "Aizat Bin Abdullah", "720508065262"]
	];

	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop