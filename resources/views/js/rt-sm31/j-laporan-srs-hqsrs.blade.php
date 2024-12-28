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
				laporan_srs_url: "/rt/sm31/laporan-srs-hqsrs"
			}
		};  

		$("#lshq_state_id").on( 'change', function () {
			senarai_srs_table.column('1:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lshq_daerah_id').find('option').remove();
            $('#lshq_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_srs_config.routes.laporan_srs_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#lshq_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lshq_daerah_id')
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

		$("#lshq_state_id").on( 'change', function () {
			senarai_srs_table.column('1:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lshq_parlimen_id').find('option').remove();
            $('#lshq_parlimen_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_srs_config.routes.laporan_srs_url,
                    data: {type: 'get_parlimen', value: value},
                    success: function (data) {
                        $('#lshq_parlimen_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lshq_parlimen_id')
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

		$("#lshq_daerah_id").on( 'change', function () {
			senarai_srs_table.column('2:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lshq_krt_id').find('option').remove();
            $('#lshq_krt_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_srs_config.routes.laporan_srs_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#lshq_krt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lshq_krt_id')
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

		$("#lshq_parlimen_id").on( 'change', function () {
			senarai_srs_table.column('3:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lshq_dun_id').find('option').remove();
            $('#lshq_dun_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_srs_config.routes.laporan_srs_url,
                    data: {type: 'get_dun', value: value},
                    success: function (data) {
                        $('#lshq_dun_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lshq_dun_id')
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

		$("#lshq_dun_id").on( 'change', function () {
			senarai_srs_table.column('4:visible').search( $(this).val() ).draw();
		});

		$("#lshq_krt_id").on( 'change', function () {
			senarai_srs_table.column('5:visible').search( $(this).val() ).draw();
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
            rowCallback: function(nRow, aData, index) {
                var info = senarai_srs_table.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
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