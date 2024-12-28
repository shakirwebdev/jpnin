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

		$('#senari_PSK').DataTable( {
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
	        data: dataSetSkuadUnit,
		    columns: [
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false},
	            {bSortable: false},
	            {bSortable: false},
	            {bSortable: false},
	            {bSortable: false},
	            {bSortable: false},
	            {bSortable: false},
	            {data : null, bSortable: false, sClass: 'text-center',
                    mRender: function (value, type, full) {
                    	button_a = '<button type="button" class="btn btn-icon" title="Kemaskini" id="edit-jpnin" data-id="" onclick="semakan_profile_psk();"><font color="red"><i class="fe fe-edit-3"></i></font></button>';
                		// button_b = '<button type="button" class="btn btn-icon" title="Surat Akuan Terima" id="" data-id="" data-type="confirm"><i class="fa fa-print"></i></button>';
                	return button_a;
                    }
                },
	        ]
	    });
        
    });

    function semakan_profile_psk(){
        window.location.href = '{{route('rt-sm10.menyemak_profile_psk')}}';
    }

	var dataSetSkuadUnit = [ 
		["1", "Perlis", "Kangar","Taman Peladang Jaya", "Teres Kos Rendah", "Jenayah, Dadah", "Melayu, Cina", "Direkod Oleh PPD"]
		
	];

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop