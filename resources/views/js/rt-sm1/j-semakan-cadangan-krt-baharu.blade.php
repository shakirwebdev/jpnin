@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    

    $(document).ready( function () {

        //my custom script
        var krt_config = {
            routes: {
                semakan_cadangan_krt_url: "/rt/sm1/semakan-cadangan-krt-baharu"
            }
        };

        var senarai_cadangan_krt = $('#senarai_cadangan_krt').DataTable( {
    		processing: true,
            serverSide: true,
            ajax: {url: krt_config.routes.semakan_cadangan_krt_url},
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
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                    return full.daerah_description;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                    return 'RT'+full.state_id+full.daerah_id+full.id;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                   return full.krt_name;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "28%", 
                "mRender": function ( value, type, full )  {
                   return full.krt_note;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                   return full.created_at;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                   return full.status_description;
                }
            },{
                "aTargets": [ 7 ], 
                "width": "6%", 
                "sClass": "text-center", 
                "mRender": function ( value, type, full )  {
                    if (full.status == '1') {
                        button_a = '<button type="button" class="btn btn-icon" title="Edit" id="edit-jpnin" onclick="semakan_cadangan_krt_baharu(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
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

    function semakan_cadangan_krt_baharu(id){
        window.location.href = "{{ route('rt-sm1.semak_borang_cadangan_krt_baharu','') }}"+"/"+id;
    }

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop