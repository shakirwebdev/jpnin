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
        
    	$('#jana_surat_terima_permohonan_srs').DataTable( {
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
	        data: dataSenaraiPermohonanSRS,
		    columns: [
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false},
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false, sClass: 'text-center'},
	            {data : null, bSortable: false, sClass: 'text-center',
                    mRender: function (value, type, full) {
                    	button_a = '<button type="button" class="btn btn-icon" title="Kemaskini" id="edit-jpnin" data-id="" onclick="jana_surat_penubuhan_srs();"><font color="red"><i class="fe fe-edit-3"></i></font></button>';
                    	button_b = '<button type="button" class="btn btn-icon" title="Surat Akuan Terima" id="" data-id="" data-type="confirm" onclick="print_jana_surat_penubuhan_srs();"><i class="fa fa-print"></i></button>';
                	return button_a + button_b;
                    }
                },
	        ]
	    });

	});

	function jana_surat_penubuhan_srs(){
        window.location.href = '{{route('rt-sm12.surat_terima_penubuhan_srs_ppd_1')}}';
    }

    function print_jana_surat_penubuhan_srs(){
        window.location.href = '{{route('rt-sm12.surat_terima_penubuhan_srs_ppd')}}';
    }

	var dataSenaraiPermohonanSRS = [ 
		["1", "SRS3012012", "KRT Taman Peladang Jaya", "SRS Taman Peladang Jaya", "30/12/2020", "26"]
	];

	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop