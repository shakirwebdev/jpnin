@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    

    $(document).ready( function () {

        var senarai_ahli_krt_config = {
			routes: {
				senarai_senarai_ahli_krt_url: "/rt/sm4/pengesahan-ahli-krt-utama-admin"
			}
		};

        $("#pakua_negeri_id").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#pakua_daerah_id').find('option').remove();
            $('#pakua_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: senarai_ahli_krt_config.routes.senarai_senarai_ahli_krt_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#pakua_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#pakua_daerah_id')
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

        $("#pakua_daerah_id").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#pakua_krt_id').find('option').remove();
            $('#pakua_krt_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: senarai_ahli_krt_config.routes.senarai_senarai_ahli_krt_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#pakua_krt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#pakua_krt_id')
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

		var senarai_pengesahan_ahli_krt_table = $('#senarai_pengesahan_ahli_krt_table').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_ahli_krt_config.routes.senarai_senarai_ahli_krt_url},
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
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.krt_negeri;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.krt_daerah;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.krt_nama;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.ajk_nama;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_ic;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "38%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_alamat;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_jawatan_desc;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_status_form_description;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.ajk_status_form == '4') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini pendaftaran ahli KRT" onclick="pengesahan_pendaftaran_ajk_krt(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
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

    function pengesahan_pendaftaran_ajk_krt(id){
		window.location.href = "{{ route('rt-sm4.pengesahan_borang_pendaftaran_eIDRT','') }}"+"/"+id;
	}

	

    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop