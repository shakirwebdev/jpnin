@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
   

    $(document).ready( function () {
		
        
         //my custom script
        var krt_config = {
            routes: {
                krt_action_url: "/rt/sm2/profile-krt-ppd"
            }
        };

        $("#pkpd_krt_profile_id").on( 'change', function () {
            senarai_permohonan_krt.search( $(this).val() ).draw();
        });

    	var senarai_permohonan_krt = $('#senarai_permohonan_krt').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: krt_config.routes.krt_action_url},
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
            rowCallback: function(nRow, aData, index) {
                var info = senarai_permohonan_krt.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
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
                    return 'KRT'+full.state_id+full.daerah_id+full.id;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                   return full.krt_nama;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                   return full.krt_alamat;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "20%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                   return full.created_at;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "20%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                   return full.diluluskan_date;
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
                    button_a = '<button type="button" class="btn btn-icon" title="Paparan Profil KRT" onclick="papran_profil_krt_ppd(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        return button_a;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });
        
    });

    function papran_profil_krt_ppd(id){
        window.location.href = "{{ route('rt-sm2.profile_krt_ppd_2','') }}"+"/"+id;
    }
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop