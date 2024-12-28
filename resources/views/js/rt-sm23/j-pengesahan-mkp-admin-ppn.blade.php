@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var pengesahan_permohonan_mkp_config = {
			routes: {
				pengesahan_permohonan_mkp_url: "/rt/sm23/pengesahan-mkp-admin-ppn"
			}
		};   
        
    	$('#senarai_permohonan_mkp').DataTable( {
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
	            {bSortable: false},
	            {bSortable: false},
	            {bSortable: false},
	            {bSortable: false},
                {bSortable: false},
                {bSortable: false, sClass: 'text-center'},
                {data : null, bSortable: false, sClass: 'text-center',
                    mRender: function (value, type, full) {
                        button_a = '<button type="button" class="btn btn-icon" title="Pengesahan Pendaftaran MKP" id="edit-jpnin" data-id="" onclick="pengesahan_pendaftaran_mkp();"><font color="red"><i class="fe fe-edit-3"></i></font></button>';
                    return button_a;
                    }
                },
	        ]
	        
	    });
        
    });

    function pengesahan_pendaftaran_mkp(){
        window.location.href = '{{route('rt-sm23.pengesahan_mkp_admin_ppn_1')}}';
    }

    var dataSet = [ 
		["1", "Perlis", "Perlis", "Mohamad Shauki Bin Sahardi", "930508095161", "0124470470", "mohamadshauki93@gmail.com", "Dihantar Untuk Pengesahan"]
	];

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop