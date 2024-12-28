@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">    
    
	$(document).ready( function () {

		//my custom script
		var senarai_permohonan_ajk_cawangan_config = {
			routes: {
				senarai_permohonan_ajk_cawangan_url: "/rt/sm9/senarai-ajk-cawangan-rt"
			}
		};

        $("#sacrt_cawangan_id").on( 'change', function () {
            senarai_ajk_cawangan_table.search( $(this).val() ).draw();
        });

		var senarai_ajk_cawangan_table = $('#senarai_ajk_cawangan_table').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_permohonan_ajk_cawangan_config.routes.senarai_permohonan_ajk_cawangan_url},
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
                var info = senarai_ajk_cawangan_table.page.info();
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
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.jenis_cawangan;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.ajk_nama;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_ic;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.age;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_phone;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_email;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.status;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    button_a = '<button type="button" class="btn btn-icon" title="Paparan ahli cawangan RT" onclick="view_ajk_cawangan_rt(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });

	});

    function view_ajk_cawangan_rt(id){
		window.location.href = "{{ route('rt-sm9.view_ajk_cawangan_rt','') }}"+"/"+id;
	}

	
	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop