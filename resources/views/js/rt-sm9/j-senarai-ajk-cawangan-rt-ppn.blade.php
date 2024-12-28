@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">    
    
	$(document).ready( function () {

		//my custom script
		var senarai_permohonan_ajk_cawangan_config = {
			routes: {
				senarai_permohonan_ajk_cawangan_url: "/rt/sm9/senarai-ajk-cawangan-rt-ppn"
			}
		};

        $("#sacrt_ppn_daerah_id").on( 'change', function () {
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
			$('#sacrt_ppn_krt_id').find('option').remove();
			$('#sacrt_ppn_krt_id').prop("disabled", false);
			if (selectedIndex !== '0') {
				$.ajax({
					type: "GET",
					url: senarai_permohonan_ajk_cawangan_config.routes.senarai_permohonan_ajk_cawangan_url,
					data: {type: 'get_krt', value: value},
					success: function (data) {
						$('#sacrt_ppn_krt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#sacrt_ppn_krt_id')
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

        $("#sacrt_ppn_krt_id").on( 'change', function () {
            senarai_ajk_cawangan_table.search( $(this).val() ).draw();
        });

        $("#sacrt_ppd_cawangan_id").on( 'change', function () {
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
                    return full.krt_daerah;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.krt_nama;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.jenis_cawangan;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.ajk_nama;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_ic;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.age;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_phone;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.status;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.ajk_status == '1') {
                        button_a = '<button type="button" class="btn btn-icon" title="Paparan ahli cawangan RT" onclick="view_ajk_cawangan_rt_ppn(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
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

    function view_ajk_cawangan_rt_ppn(id){
		window.location.href = "{{ route('rt-sm9.view_ajk_cawangan_rt_ppd','') }}"+"/"+id;
	}

	
	
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop