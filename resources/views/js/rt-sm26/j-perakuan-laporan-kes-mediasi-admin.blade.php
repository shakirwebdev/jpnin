@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var permohonan_laporan_mediasi_config = {
			routes: {
				permohonan_laporan_mediasi_url: "/rt/sm26/perakuan-laporan-kes-mediasi-admin"
			}
		};   
        
    	$('#senarai_permohonan_kes_mediasi').DataTable( {
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
                {bSortable: false},
                {data : null, bSortable: false, sClass: 'text-center',
                    mRender: function (value, type, full) {
                        button_a = '<button type="button" class="btn btn-icon" title="Perakuan Permohonan Laporan Kes"  data-id="" onclick="akuan_laporan_kes();"><i class="fa fa-edit"></i></button>';
                    return button_a;
                    }
                },
	        ]
	    });
        
    });

    function akuan_laporan_kes(){
        window.location.href = '{{route('rt-sm26.perakuan_laporan_kes_mediasi_admin_1')}}';
    }

    var dataSet = [ 
		["1", "Perlis", "Perlis", "Kepenggunaan", "1/1/2021", "Mohamad Shauki Bin Sahardi", "930508095161", "Dihantar Untuk Perakuan PPD"]
	];

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop