@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {

		//my custom script
		var senarai_kanta_komuniti_config = {
			routes: {
				senarai_kanta_komuniti_url: "/rt/sm10/senarai-kanta-komuniti-ppd"
			}
		};

        $("#pkkhq_state_id").on( 'change', function () {
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
			$('#pkkhq_daerah_id').find('option').remove();
			$('#pkkhq_daerah_id').prop("disabled", false);
			if (selectedIndex !== '0') {
				$.ajax({
					type: "GET",
					url: senarai_kanta_komuniti_config.routes.senarai_kanta_komuniti_url,
					data: {type: 'get_daerah', value: value},
					success: function (data) {
						$('#pkkhq_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#pkkhq_daerah_id')
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
        
		var senarai_permohonan_kanta_komuniti = $('#senarai_permohonan_kanta_komuniti').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_kanta_komuniti_config.routes.senarai_kanta_komuniti_url},
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
                "width": "14%", 
                "mRender": function ( value, type, full )  {
                    return full.state_description;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
                    return full.daerah_description;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
					return full.kanta_nama;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "26%", 
                "mRender": function ( value, type, full )  {
					return full.kanta_alamat;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
					return full.status_description;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.status == '1') {
                        button_a = '<button type="button" class="btn btn-icon" title="Paparan Kanta Komuniti" onclick="paparan_kanta_komuniti(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
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

	function paparan_kanta_komuniti(id){
		window.location.href = "{{ route('rt-sm10.senarai_kanta_komuniti_ppd_1','') }}"+"/"+id;
	}

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop