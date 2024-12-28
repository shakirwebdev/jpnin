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
        
    	$('#senarai_bentuk_tindakan_table').DataTable( {
    		processing: true,
        	"language": {
	            "paginate": {
	                "previous": "Sebelumnya",
	                "next": "Seterusnya",
	                searchPanes: {
		                emptyPanes: 'There are no panes to display. :/'
		            }
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
	        data: dataTindakan,
		    columns: [
		    	{bSortable: false, sClass: 'text-center'},
	            {bSortable: false},
	            {data : null, bSortable: false, sClass: 'text-center',
                    mRender: function (value, type, full) {
                        button_a = '<label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" disabled><span class="custom-control-label"></span></label>';
                    return button_a;
                    }
                },
	        ]
	    });

        $('#senarai_pihak_terlibat_table').DataTable( {
    		processing: true,
        	"language": {
	            "paginate": {
	                "previous": "Sebelumnya",
	                "next": "Seterusnya",
	                searchPanes: {
		                emptyPanes: 'There are no panes to display. :/'
		            }
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
	        data: dataPihak,
		    columns: [
		    	{bSortable: false, sClass: 'text-center'},
	            {bSortable: false},
	            {data : null, bSortable: false, sClass: 'text-center',
                    mRender: function (value, type, full) {
                        button_a = '<label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1" disabled><span class="custom-control-label"></span></label>';
                    return button_a;
                    }
                },
	        ]
	    });

		/* Button */
        $('#btn_back').click(function(){
			window.location.href = "{{ route('rt-sm21.pengesahan_permohonan_insiden_admin_2') }}";
		});

		$('#btn_next').click(function(){
			window.location.href = "{{ route('rt-sm21.pengesahan_permohonan_insiden_admin_4') }}";
		});

	});

	var dataTindakan = [ 
        ["1", "Perjumpaan"],
        ["2", "Mediasi"],
        ["3", "Kawalan Polis"],
        ["4", "Tangkapan Polis"],
        ["5", "Mahkamah"]
    ];

    var dataPihak = [ 
        ["1", "JPNIN Ibu Pejabat"],
        ["2", "JPNIN Negeri"],
        ["3", "JPNIN Daerah"],
        ["4", "ADUN"],
        ["5", "Ahli Parlimen"],
        ["6", "Pihak Berkuasa Tempatan"],
        ["7", "Pejabat Tanah dan Daerah"],
        ["8", "PDRM"],
        ["9", "Jawatankuasa RT"],
        ["10", "Jawatankuasa RT"],
        ["11", "Penggerak Perpaduan"],
        ["12", "Persatuan Penduduk"]
    ];
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop