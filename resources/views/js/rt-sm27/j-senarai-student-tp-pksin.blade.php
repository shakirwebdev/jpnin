@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var senarai_student_tp_pksin_config = {
			routes: {
				senarai_student_tp_pksin_url: "/rt/sm27/senarai-student-tp-pksin"
			}
		};  

        $("#sstp_state_id").on( 'change', function () {
			list_mohon_masuk_tabika.search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#sstp_daerah_id').find('option').remove();
            $('#sstp_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: senarai_student_tp_pksin_config.routes.senarai_student_tp_pksin_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#sstp_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#sstp_daerah_id')
                            .append($('<option>')
                            .text(obj.daerah_description)
                            .attr('value', obj.daerah_description));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

        $("#sstp_daerah_id").on( 'change', function () {
			list_mohon_masuk_tabika.search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#sstp_tabika_id').find('option').remove();
            $('#sstp_tabika_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: senarai_student_tp_pksin_config.routes.senarai_student_tp_pksin_url,
                    data: {type: 'get_tabika', value: value},
                    success: function (data) {
                        $('#sstp_tabika_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#sstp_tabika_id')
                            .append($('<option>')
                            .text(obj.tbk_nama)
                            .attr('value', obj.tbk_nama));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

        $("#sstp_tabika_id").on( 'change', function () {
			list_mohon_masuk_tabika.search( $(this).val() ).draw();
		});
        
    	var list_mohon_masuk_tabika = $('#list_mohon_masuk_tabika').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: 'l<"pull-right">Brtip',
            ajax: {url: senarai_student_tp_pksin_config.routes.senarai_student_tp_pksin_url},
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
					return full.student_status;
                }
            },{          
                "aTargets": [ 10 ], 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    button_a = '<button type="button" class="btn btn-icon" title="Paparan Profile Pelajar Tabika Perpaduan" onclick="paparan_student_tp_pksin(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
					return button_a;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    }); 
        
    });

    function paparan_student_tp_pksin(id){
		window.location.href = "{{ route('rt-sm27.student_tp_pksin','') }}"+"/"+id;
	}

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop