@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    $(document).ready( function () {
		
		//my custom script
		var senarai_minit_mesyuarat_config = {
			routes: {
				senarai_minit_mesyuarat_url: "/rt/sm5/paparan-minit-mesyuarat-rt-ppd"
			}
		};

		$("#pmpd_krt_id").on( 'change', function () {
            senarai_minit_mesyuarat_table.search( $(this).val() ).draw();
        });
		
		var senarai_minit_mesyuarat_table = $('#senarai_minit_mesyuarat_table').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_minit_mesyuarat_config.routes.senarai_minit_mesyuarat_url},
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
			"bSort": false,
            rowCallback: function(nRow, aData, index) {
                var info = senarai_minit_mesyuarat_table.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
        	responsive: true,
			"aoColumnDefs":[{          
                "aTargets": [ 0 ], 
                "width": "6%", 
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                    return  meta.row+1;
                }          
			},{          
                "aTargets": [ 1 ], 
                "width": "29%", 
                "mRender": function ( value, type, full )  {
                    return full.krt_nama;
                }
            },{           
                "aTargets": [ 2 ], 
                "width": "29%", 
                "mRender": function ( value, type, full )  {
                    return full.mesyuarat_title;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.mesyuarat_tarikh;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "29%", 
                "mRender": function ( value, type, full )  {
					return full.mesyuarat_tempat;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.status_description;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.mesyuarat_status == '1') {
                        button_a = '<button type="button" class="btn btn-icon" title="Cetak Minit Mesyuarat JawatanKuasa" target="_blank" onclick="print_minit_mesyuarat(\'' + full.id + '\');"><i class="fa fa-print"></i></button>';
						return button_a;
                    } else {
                        button_b = '';
                        return button_b;
                    }
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });

	});

	function print_minit_mesyuarat(id){
        window.location.href = "{{route('pdf.minit_mesyuarat','')}}"+"/"+id;
	}

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop