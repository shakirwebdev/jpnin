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

        $('#senarai_statistik_mkp_table').DataTable( {
    		processing: true,
            "pageLength": 20,
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
	        data: data_mkp,
		    columns: [
		    	{bSortable: false},
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false, sClass: 'text-center'},
	        ]
	    });
        
    	$('#senarai_statistik_jantina_table').DataTable( {
    		processing: true,
            "pageLength": 20,
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
	        data: data_jantina,
		    columns: [
		    	{bSortable: false},
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false, sClass: 'text-center'},
	        ]
	    });

		$('#senarai_statistik_kaum_table').DataTable( {
    		processing: true,
            "pageLength": 20,
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
	        data: data_kaum,
		    columns: [
		    	{bSortable: false},
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false, sClass: 'text-center'},
                {bSortable: false, sClass: 'text-center'},
                {bSortable: false, sClass: 'text-center'},
                {bSortable: false, sClass: 'text-center'},
                {bSortable: false, sClass: 'text-center'},
            ]
	    });

		$('#senarai_statistik_pendidikan_table').DataTable( {
    		processing: true,
            "pageLength": 20,
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
	        data: data_pendidikan,
		    columns: [
		    	{bSortable: false},
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false, sClass: 'text-center'},
                {bSortable: false, sClass: 'text-center'},
                {bSortable: false, sClass: 'text-center'},
                {bSortable: false, sClass: 'text-center'},
                {bSortable: false, sClass: 'text-center'},
                {bSortable: false, sClass: 'text-center'},
            ]
	    });	

	});

    var data_mkp = [ 
		["Perlis", "0", "13", "13"],
        ["Pulau Pinang", "1", "52", "53"],
        ["Kedah", "3", "15", "18"],
        ["Kelantan", "2", "12", "14"],
        ["Terengganu", "1", "13", "14"],
        ["Pahang", "8", "9", "17"],
        ["Perak", "6", "19", "25"],
        ["Melaka", "0", "8", "8"],
        ["Negeri Sembilan", "10", "23", "33"],
        ["Selangor", "10", "67", "77"],
        ["WP Kuala Lumpur", "2", "22", "24"],
        ["WP Putrajaya", "1", "7", "8"],
        ["Johor", "0", "10", "10"],
        ["Sarawak", "0", "9", "9"],
        ["Sabah", "21", "53", "74"],
        ["WP Labuan", "0", "3", "3"]
	];

    var data_jantina = [ 
		["Perlis", "9", "4", "13"],
        ["Pulau Pinang", "42", "11", "53"],
        ["Kedah", "16", "2", "18"],
        ["Kelantan", "13", "1", "14"],
        ["Terengganu", "13", "1", "14"],
        ["Pahang", "13", "3", "17"],
        ["Perak", "20", "5", "25"],
        ["Melaka", "7", "1", "8"],
        ["Negeri Sembilan", "26", "7", "33"],
        ["Selangor", "63", "14", "77"],
        ["WP Kuala Lumpur", "19", "5", "24"],
        ["WP Putrajaya", "7", "1", "8"],
        ["Johor", "8", "2", "10"],
        ["Sarawak", "8", "1", "9"],
        ["Sabah", "54", "20", "74"],
        ["WP Labuan", "1", "2", "3"]
	];

    var data_kaum = [ 
		["Perlis", "0", "0", "0", "0", "0", "0", "0"],
        ["Pulau Pinang", "0", "0", "0", "0", "0", "0", "0"],
        ["Kedah", "0", "0", "0", "0", "0", "0", "0"],
        ["Kelantan", "0", "0", "0", "0", "0", "0", "0"],
        ["Terengganu", "0", "0", "0", "0", "0", "0", "0"],
        ["Pahang", "0", "0", "0", "0", "0", "0", "0"],
        ["Perak", "0", "0", "0", "0", "0", "0", "0"],
        ["Melaka", "0", "0", "0", "0", "0", "0", "0"],
        ["Negeri Sembilan", "0", "0", "0", "0", "0", "0", "0"],
        ["Selangor", "0", "0", "0", "0", "0", "0", "0"],
        ["WP Kuala Lumpur", "0", "0", "0", "0", "0", "0", "0"],
        ["WP Putrajaya", "0", "0", "0", "0", "0", "0", "0"],
        ["Johor", "0", "0", "0", "0", "0", "0", "0"],
        ["Sarawak", "0", "0", "0", "0", "0", "0", "0"],
        ["Sabah", "0", "0", "0", "0", "0", "0", "0"],
        ["WP Labuan", "0", "0", "0", "0", "0", "0", "0"]
	];

    var data_pendidikan = [ 
		["Perlis", "0", "0", "0", "0", "0", "0", "0", "0"],
        ["Pulau Pinang", "0", "0", "0", "0", "0", "0", "0", "0"],
        ["Kedah", "0", "0", "0", "0", "0", "0", "0", "0"],
        ["Kelantan", "0", "0", "0", "0", "0", "0", "0", "0"],
        ["Terengganu", "0", "0", "0", "0", "0", "0", "0", "0"],
        ["Pahang", "0", "0", "0", "0", "0", "0", "0", "0"],
        ["Perak", "0", "0", "0", "0", "0", "0", "0", "0"],
        ["Melaka", "0", "0", "0", "0", "0", "0", "0", "0"],
        ["Negeri Sembilan", "0", "0", "0", "0", "0", "0", "0", "0"],
        ["Selangor", "0", "0", "0", "0", "0", "0", "0", "0"],
        ["WP Kuala Lumpur", "0", "0", "0", "0", "0", "0", "0", "0"],
        ["WP Putrajaya", "0", "0", "0", "0", "0", "0", "0", "0"],
        ["Johor", "0", "0", "0", "0", "0", "0", "0", "0"],
        ["Sarawak", "0", "0", "0", "0", "0", "0", "0", "0"],
        ["Sabah", "0", "0", "0", "0", "0", "0", "0", "0"],
        ["WP Labuan", "0", "0", "0", "0", "0", "0", "0", "0"]
	];
	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop