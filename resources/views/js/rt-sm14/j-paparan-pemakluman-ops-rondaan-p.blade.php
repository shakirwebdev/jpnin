@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">    
    
    $(document).ready( function () {
        
    	//my custom script
        var senarai_ops_rondaan_config = {
            routes: {
                senarai_ops_rondaan_config_url: "/rt/sm14/paparan-pemakluman-ops-rondaan-p"
            }
        };

		$("#pporpd_krt_id").on( 'change', function () {
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
			$('#pporpd_srs_id').find('option').remove();
			$('#pporpd_srs_id').prop("disabled", false);
			if (selectedIndex !== '0') {
				$.ajax({
					type: "GET",
					url: senarai_ops_rondaan_config.routes.senarai_ops_rondaan_config_url,
					data: {type: 'get_srs', value: value},
					success: function (data) {
						$('#pporpd_srs_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#pporpd_srs_id')
							.append($('<option>')
							.text(obj.srs_name)
							.attr('value', obj.id));
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}
		});

        var senarai_pemakluman_ops_rondaan = $('#senarai_pemakluman_ops_rondaan').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_ops_rondaan_config.routes.senarai_ops_rondaan_config_url},
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
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.nama_krt;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.nama_srs;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.ops_tarikh_mula_ronda;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.ops_tarikh_surat;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
					return full.direkod_date;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.user_fullname;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    button_a = '<button type="button" class="btn btn-icon" title="Paparan Pemakluman Operasi Rondaan" onclick="view_pemakluman_ops_rondaan(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
					return button_a;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });
		
        
    });

	function view_pemakluman_ops_rondaan(id){
		window.location.href = "{{ route('rt-sm14.surat_pemakluman_operasi_rondaan_p','') }}"+"/"+id;
	}

   
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop