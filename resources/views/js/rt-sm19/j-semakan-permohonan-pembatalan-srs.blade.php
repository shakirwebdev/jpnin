@include('js.modal.j-modal-add-penarikan-diri')
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	//my custom script
    var srs_config = {
        routes: {
            krt_action_url: "/rt/sm19/semakan-permohonan-pembatalan-srs"
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
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini" id="edit-jpnin" data-id="" onclick="semakan_pembatalan_srs_ppd();"><font color="red"><i class="fe fe-edit-3"></i></font></button>';
                    return button_a;
                    }
                },
	        ]
	    });
        
    });

    function semakan_pembatalan_srs_ppd(){
        window.location.href = '{{route('rt-sm19.semakan_borang_pembatalan_srs_ppd')}}';
    }

    var dataSet = [ 
		["1", "SRS Taman Peladang Jaya", "SRS/00001", "2010", "2020", "KRT Taman Peladang Jaya", "Khairul Mustakin Bin Mustaffa Kamal", "Memohon"]
	];

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop