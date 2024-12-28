@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var permohonan_pelaporan_insiden_config = {
			routes: {
				permohonan_pelaporan_insiden_url: "/rt/sm22/memperakui-muhibbah-admin"
			}
		};   
        
    	$('#senarai_permohonan_pelaporan_insiden').DataTable( {
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
                {bSortable: false, sClass: 'text-center'},
                {data : null, bSortable: false, sClass: 'text-center',
                    mRender: function (value, type, full) {
                        button_a = '<button type="button" class="btn btn-icon" title="Memperakui Permohonan Insiden" id="edit-jpnin" data-id="" onclick="memperakui_permohonan_insiden();"><font color="red"><i class="fe fe-edit-3"></i></font></button>';
                    return button_a;
                    }
                },
	        ]
	    });
        
    });

    function memperakui_permohonan_insiden(){
        window.location.href = '{{route('rt-sm22.memperakui_muhibbah_admin_1')}}';
    }

    var dataSet = [ 
		["1", "Perlis", "Perlis", "Kuala Perlis", "Perjumpaan Rusuhan", "Mohamad Shauki Bin Sahardi", "Dihantar Untuk Diakui"]
	];

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop