@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
    $(document).ready( function () {
        
    	//my custom script
        var senarai_perancangan_rondaan_config = {
            routes: {
                senarai_perancangan_rondaan_url: "/rt/sm15/jana-jadual-rondaan-k"
            }
        };

        var senari_perancangan_rondaan = $('#senari_perancangan_rondaan').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_perancangan_rondaan_config.routes.senarai_perancangan_rondaan_url},
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
                    return full.nama_krt;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.nama_srs;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.perancangan_rondaan_tarikh;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
                    return full.direkod_date;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
					return full.user_fullname;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "10%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.status;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.srs__perancangan_rondaan == '1') {
                        button_a = '<button type="button" class="btn btn-icon" title="Cetak Penyediaan Perancangan Rondaan" onclick="print_perancangan_rondaan_srs(\'' + full.id + '\');"><i class="fa fa-print"></i></button>';
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

    function print_perancangan_rondaan_srs(id){
		window.location.href = "{{ route('pdf.perancangan_rondaan_srs','') }}"+"/"+id;
	}

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop