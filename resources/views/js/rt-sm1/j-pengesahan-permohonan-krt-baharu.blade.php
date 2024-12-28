@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    

    $(document).ready( function () {

        //my custom script
        var krt_config = {
            routes: {
                pengesahan_cadangan_krt_url: "/rt/sm1/pengesahan-permohonan-krt-baharu"
            }
        };

        $("#ppkb_ppn_daerah_id").on( 'change', function () {
            senarai_permohonan_krt.search( $(this).val() ).draw();
        });
        
    	var senarai_permohonan_krt = $('#senarai_permohonan_krt').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: krt_config.routes.pengesahan_cadangan_krt_url},
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
                "width": "13%", 
                "mRender": function ( value, type, full )  {
                    return full.krt_daerah;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "13%", 
                "mRender": function ( value, type, full )  {
                    return 'KRT'+full.state_id+full.daerah_id+full.id;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                   return full.krt_nama;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                   return full.krt_alamat;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                   return full.created_at;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "8%",
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                   return full.status_description;
                }
            },{
                "aTargets": [ 7 ], 
                "width": "6%", 
                "sClass": "text-center", 
                "mRender": function ( value, type, full )  {
                    button_a = '<button type="button" class="btn btn-icon" title="Semak Permohonan Penubuhan KRT Baharu" onclick="semakan_krt_ppn(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
                        return button_a;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });

    });

    function semakan_krt_ppn(id){
        window.location.href = "{{ route('rt-sm1.pengesahan_permohonan_krt_ppn','') }}"+"/"+id;
    }
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop