@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var senarai_student_tp_ppd_config = {
			routes: {
				senarai_student_tp_ppd_url: "/rt/sm27/senarai-student-tp-g"
			}
		};  

        var list_mohon_masuk_tabika = $('#list_mohon_masuk_tabika').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: 'l<"pull-right">Brtip',
            ajax: {url: senarai_student_tp_ppd_config.routes.senarai_student_tp_ppd_url},
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
                "width": "10px", 
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                    return  meta.row+1;
                }
            },{          
                "aTargets": [ 1 ], 
                "width": "180px", 
                "mRender": function ( value, type, full )  {
                    return full.no_permohonan;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "200px", 
                "mRender": function ( value, type, full )  {
                    return full.state;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "200px", 
                "mRender": function ( value, type, full )  {
                    return full.daerah;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "200px", 
                "mRender": function ( value, type, full )  {
					return full.tbk_nama;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "200px", 
                "mRender": function ( value, type, full )  {
					return full.student_nama;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "200px", 
                "mRender": function ( value, type, full )  {
					return full.student_mykid;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "150px", 
                "mRender": function ( value, type, full )  {
					return full.student_jantina;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "350px", 
                "mRender": function ( value, type, full )  {
					return full.student_alamat;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "110px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					if (full.status == 1 ) {
                        status_desc = '<span>Permohonan Berjaya</span>';
                        return status_desc;
                    } else if (full.status == 4 ) {
                        status_desc = '<span>Perlu Kemaskini</span>';
                        return status_desc;
                    } else if (full.status == 5 ) {
                        status_desc = '<span>Dalam Semakan PPD</span>';
                        return status_desc;
                    } else if (full.status == 7 ) {
                        status_desc = '<span>Permohonan Tidak Berjaya</span>';
                        return status_desc;
                    } else if (full.status == 8 ) {
                        status_desc = '<span>Dalam Semakan PPD</span>';
                        return status_desc;
                    } else {
                        
                    }
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "110px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.student_status;
                }
            },{          
                "aTargets": [ 10 ], 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.status == 1) {
                        button_a = '<button type="button" class="btn btn-icon" title="Paparan Profile Pelajar Tabika Perpaduan" onclick="paparan_student_tp_g(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
					    button_b = '<button type="button" class="btn btn-icon" title="Paparan Permohonan"  data-id="" onclick="jana_surat_pemakluman_berjaya(\'' + full.id + '\');"><i class="fa fa-print"></i></button>';
                        return button_a + '|' + button_b;
                    }else if (full.status == 7) {
                        button_a = '<button type="button" class="btn btn-icon" title="Paparan Profile Pelajar Tabika Perpaduan" onclick="paparan_student_tp_g(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
					    button_b = '<button type="button" class="btn btn-icon" title="Paparan Permohonan"  data-id="" onclick="jana_surat_pemakluman_xberjaya(\'' + full.id + '\');"><i class="fa fa-print"></i></button>';
                        return button_a + '|' + button_b;
                    } else {
                        button_a = '<button type="button" class="btn btn-icon" title="Paparan Profile Pelajar Tabika Perpaduan" onclick="paparan_student_tp_g(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
					    return button_a;
                    }
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    }); 
        
    });

    function paparan_student_tp_g(id){
		window.location.href = "{{ route('rt-sm27.student_tp_g','') }}"+"/"+id;
	}

    function jana_surat_pemakluman_berjaya(id){
        window.location.href = "{{route('pdf.surat_pemakluman_tabika','')}}"+"/"+id;
    }

    function jana_surat_pemakluman_xberjaya(id){
        window.location.href = "{{route('pdf.surat_pemakluman_tabika_xberjaya','')}}"+"/"+id;
    }


</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop