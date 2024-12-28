@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {

		//my custom script
		var senarai_isu_lokasi_kanta_komuniti_config = {
			routes: {
				senarai_isu_lokasi_kanta_komuniti_url: "/rt/sm10/isu-lokasi-kanta-komuniti-krt"
			}
		};
        
		var senarai_isu_lokasi_kanta_komuniti = $('#senarai_isu_lokasi_kanta_komuniti').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_isu_lokasi_kanta_komuniti_config.routes.senarai_isu_lokasi_kanta_komuniti_url},
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
                var info = senarai_isu_lokasi_kanta_komuniti.page.info();
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
                "width": "18%", 
                "mRender": function ( value, type, full )  {
                    return full.isu_lokasi_kanta_komuniti;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
                    return full.isu_kluster;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "14%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.isu_bil_terlibat;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "14%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.isu_agensi_terlibat;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "14%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.status_description;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.status_desc;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.status == '3') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Permohonan Koperasi" onclick="kemaskini_isu_lokasi_kk(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a;
                    } else if (full.status == '5') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Permohonan Koperasi" onclick="kemaskini_isu_lokasi_kk(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a;
                    } else if (full.status == '7') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Permohonan Koperasi" onclick="kemaskini_isu_lokasi_kk(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
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

	function kemaskini_isu_lokasi_kk(id){
		window.location.href = "{{ route('rt-sm10.isu_lokasi_kanta_komuniti_krt_1','') }}"+"/"+id;
	}

	

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop