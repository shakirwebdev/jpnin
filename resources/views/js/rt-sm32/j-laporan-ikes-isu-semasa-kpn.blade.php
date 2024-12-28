@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_ikes_isu_semasa_config = {
			routes: {
				laporan_ikes_isu_semasa_url: "/rt/sm32/laporan-ikes-isu-semasa-kpn"
			}
		}; 
		
		$("#lisp_state_id").on( 'change', function () {
			laporan_isu_semasa_ikes.column('1:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lisp_daerah_id').find('option').remove();
            $('#lisp_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_ikes_isu_semasa_config.routes.laporan_ikes_isu_semasa_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#lisp_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lisp_daerah_id')
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

		$("#lisp_daerah_id").on( 'change', function () {
			laporan_isu_semasa_ikes.column('2:visible').search( $(this).val() ).draw();
		});

		$("#lisp_state_id").on( 'change', function () {
			laporan_isu_semasa_ikes.column('1:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lisp_parlimen_id').find('option').remove();
            $('#lisp_parlimen_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
					url: laporan_ikes_isu_semasa_config.routes.laporan_ikes_isu_semasa_url,
                    data: {type: 'get_parlimen', value: value},
                    success: function (data) {
                        $('#lisp_parlimen_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lisp_parlimen_id')
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

		$("#lisp_parlimen_id").on( 'change', function () {
			laporan_isu_semasa_ikes.column('3:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lisp_dun_id').find('option').remove();
            $('#lisp_dun_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_ikes_isu_semasa_config.routes.laporan_ikes_isu_semasa_url,
                    data: {type: 'get_dun', value: value},
                    success: function (data) {
                        $('#lisp_dun_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lisp_dun_id')
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

		$("#lisp_dun_id").on( 'change', function () {
            laporan_isu_semasa_ikes.column('4:visible').search( $(this).val() ).draw();
		});
        
    	var laporan_isu_semasa_ikes = $('#laporan_isu_semasa_ikes').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: '<"top"B><"pull-right"l>rtip',
            buttons: [
                {
                    extend: 'csvHtml5'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Laporan isu -isu semasa i-Kes',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            ajax: {url: laporan_ikes_isu_semasa_config.routes.laporan_ikes_isu_semasa_url},
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
                var info = laporan_isu_semasa_ikes.page.info();
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
					return full.kawasan;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "30px", 
                "mRender": function ( value, type, full )  {
					return full.lokasi;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "30px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.kluster;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "30px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.sub_kluster;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "30px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.jenis_arahan;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "30px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.tarikh_arahan;
                }
            },{          
                "aTargets": [ 11 ], 
                "width": "200px",
				"mRender": function ( value, type, full )  {
					return full.keterangan_tindakan;
                }
            },{          
                "aTargets": [ 12 ], 
                "width": "30px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.tarikh_tindakan;
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