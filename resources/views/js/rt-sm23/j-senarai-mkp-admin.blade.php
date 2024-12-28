@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var kelulusan_permohonan_mkp_config = {
			routes: {
				kelulusan_permohonan_mkp_url: "/rt/sm23/senarai-mkp-admin"
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
                        button_a = '<button type="button" class="btn btn-icon" title="Cetak Surat Pelantinkan Mediator" id="edit-jpnin" data-id="" onclick="cetak_pelantikan_mediator();"><font color="#113f50"><i class="fa fa-print"></i></font></button>';
                    return button_a;
                    }
                },
	        ]
	        
	    });
        
    });

    function cetak_pelantikan_mediator(){
        window.location.href = '{{route('pdf.surat_pelantikan_mediator')}}';
    }

    var dataSet = [ 
		["1", "Perlis", "Perlis", "Mohamad Shauki Bin Sahardi", "930508095161", "0124470470", "mohamadshauki93@gmail.com", "Diluluskan"]
	];

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop