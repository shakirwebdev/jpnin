@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
    $(document).ready( function () {
        
    	//my custom script
        var senarai_perancangan_rondaan_config = {
            routes: {
                senarai_perancangan_rondaan_url: "/rt/sm15/laporan-perancangan-rondaan-ppn"
            }
        };

        $("#lprpn_daerah_id").on( 'change', function () {
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
			$('#lprpn_krt_id').find('option').remove();
			$('#lprpn_krt_id').prop("disabled", false);
			if (selectedIndex !== '0') {
				$.ajax({
					type: "GET",
					url: senarai_perancangan_rondaan_config.routes.senarai_perancangan_rondaan_url,
					data: {type: 'get_krt', value: value},
					success: function (data) {
						$('#lprpn_krt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#lprpn_krt_id')
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

		$("#lprpn_krt_id").on( 'change', function () {
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
			$('#lprpn_srs_id').find('option').remove();
			$('#lprpn_srs_id').prop("disabled", false);
			if (selectedIndex !== '0') {
				$.ajax({
					type: "GET",
					url: senarai_perancangan_rondaan_config.routes.senarai_perancangan_rondaan_url,
					data: {type: 'get_srs', value: value},
					success: function (data) {
						$('#lprpn_srs_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#lprpn_srs_id')
							.append($('<option>')
							.text(obj.srs_name)
							.attr('value', obj.srs_name));
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}
		});

        $("#lprpn_srs_id").on( 'change', function () {
            senarai_perancangan_rondaan.search( $(this).val() ).draw();
        });

        var senarai_perancangan_rondaan = $('#senarai_perancangan_rondaan').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_perancangan_rondaan_config.routes.senarai_perancangan_rondaan_url},
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
                    return full.daerah;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.krt_nama;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.srs_nama;
                }
            },{          
                "aTargets": [ 4 ], 
                sClass: 'text-center',
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                    return full.tahun_perancangan;
                }
            },{          
                "aTargets": [ 5 ], 
                sClass: 'text-center',
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                    return full.bulan_perancangan;
                }
            },{          
                "aTargets": [ 6 ], 
                sClass: 'text-center',
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.week_1;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "10%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.week_2;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "10%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.week_3;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "10%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.week_4;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "10%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.total_perancangan;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });
        
    });

    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop