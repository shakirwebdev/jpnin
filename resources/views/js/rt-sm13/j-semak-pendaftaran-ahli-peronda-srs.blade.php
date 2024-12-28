@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    //my custom script
    var krt_config = {
        routes: {
            krt_action_url: "/rt/sm4/pendaftaran-ahli-krt-utama"
        }
    };

    $(document).ready( function () {
        
    	$('#ahli_peronda_srs_table').DataTable( {
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
                    	button_a = '<button type="button" class="btn btn-icon" title="Semak Borang Pendaftaran" id="edit-jpnin" data-id="" onclick="semak_borang_ahli_peronda();"><font color="red"><i class="fe fe-edit-3"></i></font></button>';
                	return button_a;
                    }
                },
	        ]
	    });
        
    });

    function semak_borang_ahli_peronda(){
        window.location.href = '{{route('rt-sm13.semak_pendaftaran_ahli_peronda_srs_1')}}';
    }

    var dataSet = [ 
		["1", "Mohamad Shauki Bin Sahardi", "930508095161", "27", "A-lg-11 Cyberia Cresent 2 63000 Cyberjaya Selangor", "Melayu", "Diploma", "Developer", "TIDAK CENDERUNG KEPADA MANA-MANA PARTI", "Setiausaha", "Direkod oleh Ketua Peronda" ]
	];
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop