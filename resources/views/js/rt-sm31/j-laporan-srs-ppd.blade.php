@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<style>
	
}
</style>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_srs_config = {
			routes: {
				laporan_srs_url: "/rt/sm31/laporan-srs-ppd"
			}
		};  

        $("#lsppd_parlimen_id").on( 'change', function () {
			senarai_srs_table.search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lsppd_dun_id').find('option').remove();
            $('#lsppd_dun_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_srs_config.routes.laporan_srs_url,
                    data: {type: 'get_dun', value: value},
                    success: function (data) {
                        $('#lsppd_dun_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lsppd_dun_id')
                            .append($('<option>')
                            .text(obj.dun_description)
                            .attr('value', obj.dun_description));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

		$("#lsppd_dun_id").on( 'change', function () {
			senarai_srs_table.search( $(this).val() ).draw();
		});

		$("#lsppd_krt_id").on( 'change', function () {
			senarai_srs_table.search( $(this).val() ).draw();
		});
        
    	var senarai_srs_table = $('#senarai_srs_table').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: 'l<"pull-right">Brtip',
            ajax: {url: laporan_srs_config.routes.laporan_srs_url},
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
                "width": "50px", 
                "mRender": function ( value, type, full )  {
                    return full.state;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
                    return full.daerah;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
                    return full.parlimen;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.dun;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "100px", 
                "mRender": function ( value, type, full )  {
					return full.krt_nama;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "100px", 
                "mRender": function ( value, type, full )  {
					return full.srs_nama;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "30px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.no_rujukan_srs;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "30px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.tarikh_tubuh;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "30px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.bil_pronda;
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