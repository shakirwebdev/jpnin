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
        
    	$('#jana_surat_pelantikan_anggota_table').DataTable( {
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
	            { title: "Bil", sClass: 'text-center'},
	            { title: "Nama" },
	            { title: "IC" },
	            { title: "Umur", sClass: 'text-center'},
	            { title: "Alamat" },
	            { title: "Jantina" },
	            { title: "Kaum" },
	            { title: "Pendidikan" },
	            { title: "Pekerjaan" },
	            { title: "Ideologi" },
	            { title: "Jawatan" },
	            {data : null, bSortable: false, sClass: 'text-center',
                    mRender: function (value, type, full) {
                    	button_a = '<button type="button" class="btn btn-icon" title="Edit" id="edit-jpnin" onclick=" JanaSuratPelantikanAnggota();"><i class="fa fa-print"></i></button>';
                	return button_a;
                    }
                },
	        ]
	    });
        
    });

    var dataSet = [ 
		["1", "Khairul Mustakim", "900508095464", "30", "A-lg-11 Cyberia Cresent 2 63000 Cyberjaya Selangor", "Lelaki", "Melayu", "Diploma", "Developer", "TIDAK CENDERUNG KEPADA MANA-MANA PARTI", "Penolong Setiausaha", "" ]
	];

	function JanaSuratPelantikanAnggota(){
        window.location.href = '{{route('rt-sm4.surat_pelantikan_anggota')}}';
    }
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop