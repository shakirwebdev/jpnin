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
        
    	$('#senarai_peronda_table').DataTable( {
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
	        data: dataSenaraiPeronda,
		    columns: [
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false},
	            {bSortable: false, sClass: 'text-center'},
	        ]
	    });

	    $('#peronda_sukarela_table').DataTable( {
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
        	data: dataSenaraiPerondaSukarela,
		    columns: [
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false},
	            {bSortable: false},
	            {bSortable: false},
	            {bSortable: false},
	        ]
	    });

	});

	var dataSenaraiPeronda = [ 
		["1", "Mohamad Shauki Bin Sahardi", "ABC123"],
		["2", "Nurkhalis Syafiq Bin Mohd Zain", "DEF456"],
		["3", "Khairul Mustakim Bin Mustaffa Kamal", "GHI789"],
		["4", "Azhar Bin Mohd Nor", "AHG912"],
		["5", "Khairul Muklis Bin Mustaffa Kamal", "AGU982"],
		["6", "Ayub Bin Mohamad Aiman", "AFF982"]
	];

	var dataSenaraiPerondaSukarela = [ 
		["1", "Mohamad Shauki Bin Sahardi", "930508095161", "Lelaki", "No 10 Lorong 5 Taman Peladang Jaya 02000 Kuala Perlis"],
		["2", "Nurkhalis Syafiq Bin Mohd Zain", "900508095161", "Lelaki", "No 6 Lorong 4 Taman Peladang Jaya 02000 Kuala Perlis"],
		["3", "Khairul Mustakim Bin Mustaffa Kamal", "890508095161", "Lelaki", "No 7 Lorong 4 Taman Peladang Jaya 02000 Kuala Perlis"],
		["4", "Azhar Bin Mohd Nor", "880508095161", "Lelaki", "No 9 Lorong 4 Taman Peladang Jaya 02000 Kuala Perlis"],
		["5", "Khairul Muklis Bin Mustaffa Kamal", "970508095161", "Lelaki", "No 7 Lorong 4 Taman Peladang Jaya 02000 Kuala Perlis"],
		["6", "Ayub Bin Mohamad Aiman", "800508095161", "Lelaki", "No 1, Taman Peladang Jaya 02000 Kuala Perlis"]
	];

	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop