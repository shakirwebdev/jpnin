@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {

		//my custom script
		var pengesahan_senarai_isu_lokasi_kanta_komuniti_config = {
			routes: {
				pengesahan_senarai_isu_lokasi_kanta_komuniti_url: "/rt/sm10/pengesahan-isu-lokasi-kanta-komuniti"
			}
		};

        $("#pilkk_daerah_id").on( 'change', function () {
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
			$('#pilkk_krt_id').find('option').remove();
			$('#pilkk_krt_id').prop("disabled", false);
			if (selectedIndex !== '0') {
				$.ajax({
					type: "GET",
					url: pengesahan_senarai_isu_lokasi_kanta_komuniti_config.routes.pengesahan_senarai_isu_lokasi_kanta_komuniti_url,
					data: {type: 'get_krt', value: value},
					success: function (data) {
						$('#pilkk_krt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#pilkk_krt_id')
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

        $("#pilkk_krt_id").on( 'change', function () {
            senarai_isu_lokasi_kanta_komuniti.search( $(this).val() ).draw();
        });
        
		var senarai_isu_lokasi_kanta_komuniti = $('#senarai_isu_lokasi_kanta_komuniti').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: pengesahan_senarai_isu_lokasi_kanta_komuniti_config.routes.pengesahan_senarai_isu_lokasi_kanta_komuniti_url},
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
                "width": "18%", 
                "mRender": function ( value, type, full )  {
                    return full.daerah_description;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "18%", 
                "mRender": function ( value, type, full )  {
                    return full.krt_nama;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "18%", 
                "mRender": function ( value, type, full )  {
                    return full.isu_lokasi_kanta_komuniti;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
                    return full.isu_kluster;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "14%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.isu_bil_terlibat;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "14%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.isu_agensi_terlibat;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "14%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.status_description;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.status_desc;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.status == '6') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Permohonan Koperasi" onclick="semak_isu_lokasi_kk(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
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

	function semak_isu_lokasi_kk(id){
		window.location.href = "{{ route('rt-sm10.pengesahan_isu_lokasi_kanta_komuniti_1','') }}"+"/"+id;
	}

	

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop