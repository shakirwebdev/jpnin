@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
    $(document).ready( function () {
        
    	//my custom script
		var senarai_aktivitin_config = {
			routes: {
				senarai_aktiviti_url: "/rt/sm6/jana-laporan-perancangan-aktiviti-hq"
			}
		};

        $("#jlpah_state_id").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#jlpah_daerah_id').find('option').remove();
            $('#jlpah_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: senarai_aktivitin_config.routes.senarai_aktiviti_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#jlpah_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#jlpah_daerah_id')
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

        $("#jlpah_daerah_id").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#jlpah_krt_id').find('option').remove();
            $('#jlpah_krt_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: senarai_aktivitin_config.routes.senarai_aktiviti_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#jlpah_krt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#jlpah_krt_id')
                            .append($('<option>')
                            .text(obj.krt_nama)
                            .attr('value', obj.krt_nama));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

        $("#jlpah_krt_id").on( 'change', function () {
            senarai_aktiviti.search( $(this).val() ).draw();
        });

        var senarai_aktiviti = $('#senarai_aktiviti').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_aktivitin_config.routes.senarai_aktiviti_url},
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
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.negeri;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.daerah;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.krt_nama;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.aktiviti_tajuk;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
					return full.aktiviti_agenda;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.aktiviti_bidang;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
					return full.aktiviti_tarikh_rancang;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.aktiviti_tarikh;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.status_description;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.aktiviti_status == '1') {
                        button_a = '<button type="button" class="btn btn-icon" title="Pengesahan perancangan aktiviti RT" onclick="laporan_perancangan_aktiviti(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
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

    function laporan_perancangan_aktiviti(id){
		window.location.href = "{{ route('rt-sm6.jana_laporan_perancangan_aktiviti_hq_1','') }}"+"/"+id;
	}

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop