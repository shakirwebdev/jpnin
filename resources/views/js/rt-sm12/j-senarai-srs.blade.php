@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<style type="text/css">
	.series-frame {
	  /*max-width: 600px;*/
	  display: flex;
	  justify-content: space-between;
	  align-items: center;
	  box-sizing: border-box;
	  border: 2px solid #113f50;
	  /*margin: 30px;*/
	  padding: 10px;
	}

</style>
<script type="text/javascript">    
    
	$(document).ready( function () {

		//my custom script
		var senarai_srs_config = {
			routes: {
				senarai_srs_url: "/rt/sm12/senarai-srs"
			}
		};

		var senarai_srs = $('#senarai_srs').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_srs_config.routes.senarai_srs_url},
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
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                    return 'SRS'+full.krt_state_id+full.krt_daerah_id+full.id;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.krt_name;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.srs_name;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "10%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.srs_peronda_total;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.dihantar_date;
                }
            },
            {          
                "aTargets": [ 6 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.status_description;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.srs_status == '1') {
                        button_a = '<button type="button" class="btn btn-icon" title="Paparan Profil SRS" id="edit-jpnin" onclick="paparan_profil_srs(\'' + full.id + '\');"><i class="fa fa-eye"></i></button>';
					    return button_a;
                    }else if (full.srs_status == '3') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Permohonan Penubuhan SRS" id="edit-jpnin" onclick="kemaskini_permohonan_srs(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a;
                    } else if (full.srs_status == '6') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Permohonan Penubuhan SRS" id="edit-jpnin" onclick="kemaskini_permohonan_srs(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
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

	function kemaskini_permohonan_srs(id){
        window.location.href = "{{ route('rt-sm12.permohonan_penubuhan_srs','') }}"+"/"+id;
    }

	function paparan_profil_srs(id){
        window.location.href = "{{ route('rt-sm12.profile_srs_p_1','') }}"+"/"+id;
    }

	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop