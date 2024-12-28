@include('js.modal.j-modal-add-penarikan-diri')
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	//my custom script
    var srs_config = {
        routes: {
            krt_action_url: "/rt/sm19/permohonan-pembatalan-srs"
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
                        button_a = '<button type="button" class="btn btn-icon" title="Edit" id="edit-jpnin" data-id="'+full.user_id+'"><i class="fe fe-edit-3 text-danger"></i></button>';
                    	// button_b = '<button type="button" class="btn btn-icon" title="Semak Borang Pendaftaran" id="edit-jpnin" data-id="" onclick="surat_pemakluman_operasi_rondaan();"><i class="fa fa-print"></i></button>';
                        // button_c = '<button type="button" class="btn btn-icon js-sweetalert" title="Delete" id="delete-jpnin" data-id="'+full.user_id+'" data-type="confirm"><i class="fa fa-remove"></i></button>';
                	return button_a;
                    }
                },
	        ]
	    });
        
    });

    var dataSet = [ 
		["1", "SRS Taman Peladang Jaya", "SRS/00001", "2010", "2020", "KRT Taman Peladang Jaya", "Khairul Mustakin Bin Mustaffa Kamal", "Memohon"]
	];

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop