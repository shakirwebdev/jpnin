@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<style>
	
}
</style>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_maklumat_asas_config = {
			routes: {
				laporan_maklumat_asas_url: "/rt/sm30/laporan-maklumat-asas-krt-kp"
			}
		}; 

		$("#lmakkp_state_id").on( 'change', function () {
			laporan_maklumat_asas_rt.search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lmakkp_daerah_id').find('option').remove();
            $('#lmakkp_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_maklumat_asas_config.routes.laporan_maklumat_asas_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#lmakkp_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lmakkp_daerah_id')
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

		$("#lmakkp_state_id").on( 'change', function () {
			laporan_maklumat_asas_rt.search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lmakkp_pbt_id').find('option').remove();
            $('#lmakkp_pbt_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_maklumat_asas_config.routes.laporan_maklumat_asas_url,
                    data: {type: 'get_pbt', value: value},
                    success: function (data) {
                        $('#lmakkp_pbt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lmakkp_pbt_id')
                            .append($('<option>')
                            .text(obj.pbt_description)
                            .attr('value', obj.pbt_description));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

		$("#lmakkp_state_id").on( 'change', function () {
			laporan_maklumat_asas_rt.search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lmakkp_parlimen_id').find('option').remove();
            $('#lmakkp_parlimen_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_maklumat_asas_config.routes.laporan_maklumat_asas_url,
                    data: {type: 'get_parlimen', value: value},
                    success: function (data) {
                        $('#lmakkp_parlimen_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lmakkp_parlimen_id')
                            .append($('<option>')
                            .text(obj.parlimen_description)
                            .attr('value', obj.parlimen_description));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

		$("#lmakkp_parlimen_id").on( 'change', function () {
			laporan_maklumat_asas_rt.search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lmakkp_dun_id').find('option').remove();
            $('#lmakkp_dun_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_maklumat_asas_config.routes.laporan_maklumat_asas_url,
                    data: {type: 'get_dun', value: value},
                    success: function (data) {
                        $('#lmakkp_dun_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lmakkp_dun_id')
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

		$("#lmakkp_daerah_id").on( 'change', function () {
			laporan_maklumat_asas_rt.search( $(this).val() ).draw();
		});

		$("#lmakkp_pbt_id").on( 'change', function () {
			laporan_maklumat_asas_rt.search( $(this).val() ).draw();
		});

		$("#lmakkp_dun_id").on( 'change', function () {
			laporan_maklumat_asas_rt.search( $(this).val() ).draw();
		});

		var laporan_maklumat_asas_rt = $('#laporan_maklumat_asas_rt').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: '<"top"B><"pull-right"l>rtip',
            buttons: [
                {
                    extend: 'csvHtml5'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Laporan Maklumat Asas RT',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            ajax: {url: laporan_maklumat_asas_config.routes.laporan_maklumat_asas_url},
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
                "width": "100px", 
                "mRender": function ( value, type, full )  {
                    return full.state;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "100px", 
                "mRender": function ( value, type, full )  {
                    return full.daerah;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "150px", 
                "mRender": function ( value, type, full )  {
                    return full.krt_nama;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "200px", 
                "mRender": function ( value, type, full )  {
					return full.krt_alamat;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.parlimen;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.dun;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.pbt;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.krt_ipd;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.krt_balai;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.krt_keluasan;
                }
            },{          
                "aTargets": [ 11 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.srs_nama;
                }
            },{          
                "aTargets": [ 12 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.krt_tabika;
                }
            },{          
                "aTargets": [ 13 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.krt_taska;
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