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
        
    	$('#senarai_ahli_sejiwa_table').DataTable( {
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
        	data: dataSetSkuadUnit,
		    columns: [
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false},
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false, sClass: 'text-center'},
	        ]
	    });

	    $('#jenis_perkhidmatan_table').DataTable( {
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
        	data: dataSetAgensi,
		    columns: [
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false},
	            {bSortable: false},
	            {bSortable: false},
	        ]
	    });

	    $('#senarai_aktivti_table').DataTable( {
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
        });

	});

	var dataSetSkuadUnit = [ 
		["1", "Mohamad Shauki Bin Sahardi", "930508095161", "MADA", "MELAYU", "Teknologi Maklumat"],
		["2", "Khairul Mustakim Bin Mustaffa Kamal", "900508095161", "KUIS", "MELAYU", "Tenaga Pengajar"],
		["3", "Nurizaty Binti Zulkipli ", "930508095262", "MADA", "MELAYU", "Kerani"],
		["4", "Nur Khalis Shafiq Bin Md Zain", "700508095262", "MADA", "MELAYU", "Pentadbir Sistem"],
		["5", "Nawad Qasamah", "680508095262", "MADA", "MELAYU", "Pentadbir Sistem"],
		["6", "Zahid Sanad", "680508095262", "MADA", "MELAYU", "Pentadbir Sistem"],
		["7", "Nasir Irsa", "680508095262", "MADA", "MELAYU", "Pentadbir Sistem"],
		["8", "Sulaiman Huwaidi", "680508095262", "MADA", "MELAYU", "Pentadbir Sistem"],
		["9", "Radi Rasyid", "680508095262", "MADA", "MELAYU", "Pentadbir Sistem"],
		["10", "Naura Miftah", "680508095262", "MADA", "MELAYU", "Pentadbir Sistem"]
		
	];

	var dataSetAgensi = [ 
		["1", "Masalah Rumah Tangga", "Menyediakan Khidmat Kaunseling", "Jabatan Agama Islam Negeri Perlis"],
		["2", "Penindasan Kepada Kaum Wanita", "Menyediakan Khidmat Kaunseling", "Kementerian Pembangunan Wanita"],
		
	];

	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop