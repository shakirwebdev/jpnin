@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    

	//my custom script
	var senarai_permohonan_srs_config = {
		routes: {
			senarai_permohonan_srs_url: "/rt/sm12/kelulusan-permohonan-penubuhan-srs"
		}
	};	
    
	$(document).ready( function () {

        $("#kpps_negeri_id").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#kpps_daerah_id').find('option').remove();
            $('#kpps_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: senarai_permohonan_srs_config.routes.senarai_permohonan_srs_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#kpps_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#kpps_daerah_id')
                            .append($('<option>')
                            .text(obj.daerah_description)
                            .attr('value', obj.daerah_id));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

        $("#kpps_daerah_id").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#kpps_krt_id').find('option').remove();
            $('#kpps_krt_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: senarai_permohonan_srs_config.routes.senarai_permohonan_srs_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#kpps_krt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#kpps_krt_id')
                            .append($('<option>')
                            .text(obj.krt_nama)
                            .attr('value', obj.id));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });
        
    	var senarai_permohonan_penubuhan_srs = $('#senarai_permohonan_penubuhan_srs').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_permohonan_srs_config.routes.senarai_permohonan_srs_url},
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
            },{          
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
                    button_a = '<button type="button" class="btn btn-icon" title="Semak Permohonan Penubuhan SRS" id="edit-jpnin" onclick="kelulusan_permohonan_srs(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					return button_a;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });

	});

	function kelulusan_permohonan_srs(id){
        window.location.href = "{{ route('rt-sm12.kelulusan_permohonan_penubuhan_srs_hq','') }}"+"/"+id;
    }

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop