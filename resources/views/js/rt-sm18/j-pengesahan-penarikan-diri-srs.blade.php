@include('js.modal.j-modal-pengesahan-penarikan-diri')
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	//my custom script
    var srs_config = {
        routes: {
            krt_action_url: "/rt/sm18/permohonan-penarikan-diri-srs"
        }
    };   
    
	$(document).ready( function () {
        
    	$('#senarai_penarikan_diri').DataTable( {
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
	        data: dataSet,
		    columns: [
		    	{bSortable: false, sClass: 'text-center'},
	            {bSortable: false},
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false, sClass: 'text-center'},
                {bSortable: false, sClass: 'text-center'},
                {bSortable: false, sClass: 'text-center'},
	            {data : null, bSortable: false, sClass: 'text-center',
                    mRender: function (value, type, full) {
                        button_a = '<button type="button" class="btn btn-icon" title="Edit" id="edit-jpnin" data-id="" onclick="load_sah_pengesahan_penarikan_diri();"><i class="fe fe-edit-3 text-danger"></i></button>';
                    return button_a;
                    }
                },
	        ]
	    });
        
    });

    var dataSet = [ 
		["1", "SRS Taman Peladang Jaya", "Mohamad Shauki Bin Sahardi", "930508095161", "SRSTPJ00001", "06/01/2021", "Khairul Mustakin Bin Mustaffa Kamal", "Memohon"]
	];

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop