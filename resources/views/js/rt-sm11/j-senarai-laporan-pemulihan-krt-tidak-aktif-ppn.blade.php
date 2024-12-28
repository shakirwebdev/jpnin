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

		$('#senarai_laporan_aktif_koperasi_krt').DataTable( {
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
	            {bSortable: false , sClass: 'text-center'},
	            {bSortable: false},
	            {bSortable: false},
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false},
	            {bSortable: false},
	            {bSortable: false},
	            {data : null, bSortable: false, sClass: 'text-center',
                    mRender: function (value, type, full) {
                    	button_a = '<button type="button" class="btn btn-icon" title="Kemaskini" id="edit-jpnin" data-id="" onclick="pengesahan_krt_tidak_aktif();"><font color="red"><i class="fe fe-edit-3"></i></font></button>';
                	return button_a;
                    }
                },
	        ]
	    });
        
    });

    function pengesahan_krt_tidak_aktif(){
        window.location.href = '{{route('rt-sm11.pengesahan_krt_tidak_aktif_ppn')}}';
    }

	var dataSetSkuadUnit = [ 
		["1", "KRT Taman Peladang Jaya", "5", "AJK Dilantik Tidak Lagi Berminat", "Suku Tahun Pertama", "10", "Dalam Tempoh Pemulihan", "Aktifkan Semula","Aktifkan Semula"]
		
	];

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop