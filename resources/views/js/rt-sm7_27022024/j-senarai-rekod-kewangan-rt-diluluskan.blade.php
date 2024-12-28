@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

    $(document).ready( function () {
        
    	//my custom script
		var senarai_rekod_kewangan_rt_config = {
			routes: {
				senarai_rekod_kewangan_rt_url: "/rt/sm7/senarai-rekod-kewangan-rt-diluluskan"
			}
		};

		var senarai_kewangan_rt_table = $('#senarai_kewangan_rt_table').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_rekod_kewangan_rt_config.routes.senarai_rekod_kewangan_rt_url},
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
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.kewangan_butiran;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.tarikh_t_b;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
					return full.kewangan_cek_baucer;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
					return full.tarikh_c_b;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
					return full.kewangan_jenis;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
					return full.status_kewangan_description;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.kewangan_jenis_kewangan == '1') {
                        button_a = '<button type="button" class="btn btn-icon" title="Cetak Penerimaan" onclick="print_resit_penerimaan(\'' + full.id + '\');"><i class="fa fa-print"></i></button>';
						return button_a;
                    }else if (full.kewangan_jenis_kewangan == '2') {
                        button_b = '<button type="button" class="btn btn-icon" title="Cetak Pengeluaran" onclick="print_baucer_pembayaran(\'' + full.id + '\');"><i class="fa fa-print"></i></button>';
					    return button_b;
                    }  else {
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

	function print_resit_penerimaan(id){
        window.location.href = "{{route('pdf.kewangan_resit_penerimaan','')}}"+"/"+id;
	}

	function print_baucer_pembayaran(id){
        window.location.href = "{{route('pdf.kewangan_baucer_pembayaran','')}}"+"/"+id;
	}
	
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop