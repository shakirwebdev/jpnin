@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
    $(document).ready( function () {
        
    	//my custom script
		var senarai_aktivitin_config = {
			routes: {
				senarai_aktiviti_url: "/rt/sm6/jana-laporan-perancangan-aktiviti-ppn"
			}
		};

        $("#jlpap_daerah_id").on( 'change', function () {
            var value = $(this).find('option:selected').val();
            var selectedIndex = $(this).find('option:selected').index();
            $('#jlpap_krt_id').find('option').remove();
            $('#jlpap_krt_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: senarai_aktivitin_config.routes.senarai_aktiviti_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#jlpap_krt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#jlpap_krt_id')
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

        $("#jlpap_krt_id").on( 'change', function () {
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
                    return full.daerah;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.krt_nama;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.aktiviti_tajuk;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
					return full.aktiviti_agenda;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.aktiviti_bidang;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
					return full.aktiviti_tarikh_rancang;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.aktiviti_tarikh;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.status_description;
                }
            },{          
                "aTargets": [ 9 ], 
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
		window.location.href = "{{ route('rt-sm6.jana_laporan_perancangan_aktiviti_ppn_1','') }}"+"/"+id;
	}

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop