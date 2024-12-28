@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
    $(document).ready( function () {
        
    	//my custom script
		var senarai_ajk_kepentingan_config = {
			routes: {
				senarai_ajk_kepentingan_url: "/rt/sm4/pengesahan-cadangan-ajk-kepentingan-krt-ppd"
			}
		};

        var senarai_ajk_kepentingan_table = $('#senarai_ajk_kepentingan_table').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_ajk_kepentingan_config.routes.senarai_ajk_kepentingan_url},
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
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.krt_nama;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.ajk_luar_nama;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.ajk_luar_ic;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "33%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_luar_alamat;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.status;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.ajk_luar_status == '1') {
                        button_a = '<button type="button" class="btn btn-icon" title="Pengesahan Cadangan Ajk Berkepentingan" onclick="pengesahan_ajk_berkepentingan(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a;
                    } else  {
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

    function pengesahan_ajk_berkepentingan(id){
		window.location.href = "{{ route('rt-sm4.pengesahan_borang_pendaftaran_rt_b1','') }}"+"/"+id;
	}

    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop