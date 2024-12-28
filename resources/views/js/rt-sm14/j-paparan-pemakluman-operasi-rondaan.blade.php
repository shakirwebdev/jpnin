
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    //my custom script
    var krt_config = {
        routes: {
            krt_action_url: "/rt/sm14/pemakluman-operasi-rondaan"
        }
    };

    $(document).ready( function () {
        
    	$('#senari_pemakluman_operasi_rondaan').DataTable( {
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
	            {data : null, bSortable: false, sClass: 'text-center',
                    mRender: function (value, type, full) {
                        // button_a = '<button type="button" class="btn btn-icon" title="Edit" id="edit-jpnin" data-id="'+full.user_id+'"><i class="fe fe-edit-3 text-danger"></i></button>';
                    	button_b = '<button type="button" class="btn btn-icon" title="Semak Borang Pendaftaran" id="edit-jpnin" data-id="" onclick="surat_pemakluman_operasi_rondaan();"><i class="fa fa-print"></i></button>';
                        // button_c = '<button type="button" class="btn btn-icon js-sweetalert" title="Delete" id="delete-jpnin" data-id="'+full.user_id+'" data-type="confirm"><i class="fa fa-remove"></i></button>';
                	return button_b;
                    }
                },
	        ]
	    });
        
    });

    function surat_pemakluman_operasi_rondaan(){
        window.location.href = '{{route('rt-sm14.surat_pemakluman_operasi_rondaan')}}';
    }

    var dataSet = [ 
		["1", "KRT Taman Peladang Jaya", "SRS Taman Peladang Jaya", "10/01/2021", "10/01/2021", "06/01/2021", "Mohamad Shauki Bin Sahardi"]
	];

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop