@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
    $(document).ready( function () {
        
    	//my custom script
        var senarai_pelaksanaan_rondaan_config = {
            routes: {
                senarai_pelaksanaan_rondaan_url: "/rt/sm16/penyediaan-pelaksanaan-rondaan-srs"
            }
        };

        var senarai_pelaksanaan_rondaan = $('#senarai_pelaksanaan_rondaan').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_pelaksanaan_rondaan_config.routes.senarai_pelaksanaan_rondaan_url},
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
                    return full.pelaksanaan_rondaan_tarikh;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "17%", 
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
                "width": "17%", 
                "mRender": function ( value, type, full )  {
					return full.pelaksanaan_rondaan_kes;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
					return full.status;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.pelaksanaan_rondaan_status == '2') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Penyediaan Pelaksanaan Rondaan" onclick="kemaskini_pelaksanaan_rondaan_srs(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a;
                    }else if (full.pelaksanaan_rondaan_status == '4') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Penyediaan Pelaksanaan Rondaan" onclick="kemaskini_pelaksanaan_rondaan_srs(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
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

    function kemaskini_pelaksanaan_rondaan_srs(id){
		window.location.href = "{{ route('rt-sm16.penyediaan_pelaksanaan_rondaan_srs_1','') }}"+"/"+id;
	}

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop