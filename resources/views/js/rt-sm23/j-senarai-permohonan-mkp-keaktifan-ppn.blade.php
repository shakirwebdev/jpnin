@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var sokongan_permohonan_mkp_keaktifan_ppn_config = {
			routes: {
				sokongan_permohonan_mkp_keaktifan_ppn_url: "/rt/sm23/senarai-permohonan-mkp-keaktifan-ppn"
			}
		}; 

        $("#spmkpn_daerah_id").on( 'change', function () {
			senarai_permohonan_keaktifan_mkp.column('1:visible').search( $(this).val() ).draw();
		});  
        
    	var senarai_permohonan_keaktifan_mkp = $('#senarai_permohonan_keaktifan_mkp').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: 'l<"pull-right">Brtip',
            buttons: [
              'copy', 'excel', 'pdf', 'print'
            ],
			ajax: {url: sokongan_permohonan_mkp_keaktifan_ppn_config.routes.sokongan_permohonan_mkp_keaktifan_ppn_url},
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
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.no_rujukan_mkp;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.daerah_description;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.mkp_pemohon_nama;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.mkp_pemohon_ic;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.mkp_pemohon_no_phone;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.mkp_pemohon_email;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.status_description;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.status == '4') {
                        button_a = '<button type="button" class="btn btn-icon" title="Sahkan Permohonan Keaktifan Mediator Komuniti" onclick="sahkan_permohonan_keaktifan_mkp_ppd(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a;
                    }else if (full.status == '6') {
                        button_a = '<button type="button" class="btn btn-icon" title="Sahkan Permohonan Keaktifan Mediator Komuniti" onclick="sahkan_permohonan_keaktifan_mkp_ppd(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a;
                    }else {
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

	function sahkan_permohonan_keaktifan_mkp_ppd(id){
		window.location.href = "{{ route('rt-sm23.sahkan_keaktifan_mkp_ppn','') }}"+"/"+id;
	}

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop