@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_ikes_config = {
			routes: {
				laporan_ikes_url: "/rt/sm32/laporan-ikes-kpn"
			}
		};   

		$("#lip_state_id").on( 'change', function () {
			table_laporan_ikes.column('4:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lip_daerah_id').find('option').remove();
            $('#lip_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_ikes_config.routes.laporan_ikes_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#lip_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lip_daerah_id')
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

		$("#lip_state_id").on( 'change', function () {
			table_laporan_ikes.column('4:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lip_parlimen_id').find('option').remove();
            $('#lip_parlimen_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
					url: laporan_ikes_config.routes.laporan_ikes_url,
                    data: {type: 'get_parlimen', value: value},
                    success: function (data) {
                        $('#lip_parlimen_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lip_parlimen_id')
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

		$("#lip_daerah_id").on( 'change', function () {
			table_laporan_ikes.column('5:visible').search( $(this).val() ).draw();
		});

		$("#lip_parlimen_id").on( 'change', function () {
			table_laporan_ikes.column('7:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lip_dun_id').find('option').remove();
            $('#lip_dun_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_ikes_config.routes.laporan_ikes_url,
                    data: {type: 'get_dun', value: value},
                    success: function (data) {
                        $('#lip_dun_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lip_dun_id')
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

		$("#lip_dun_id").on( 'change', function () {
            table_laporan_ikes.column('6:visible').search( $(this).val() ).draw();
		});
        
    	var table_laporan_ikes = $('#table_laporan_ikes').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: '<"top"B><"pull-right"l>rtip',
            buttons: [
                {
                    extend: 'csvHtml5'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Laporan i-Kes',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            ajax: {url: laporan_ikes_config.routes.laporan_ikes_url},
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
                var info = table_laporan_ikes.page.info();
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
                    return full.tarikh_report;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
                    return full.minggu_report;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
                    return full.bulan_report;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.negeri;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "100px", 
                "mRender": function ( value, type, full )  {
					return full.daerah;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "100px", 
                "mRender": function ( value, type, full )  {
					return full.parlimen;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "30px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.dun;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "30px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.pbt;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "30px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.kawasan;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "30px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.kluster;
                }
            },{          
                "aTargets": [ 11 ], 
                "width": "30px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.sub_kluster;
                }
            },{          
                "aTargets": [ 12 ], 
                "width": "300px",
				"mRender": function ( value, type, full )  {
					return $("<div/>").html(full.keterangan_kes).text(); 
                }
            },{          
                "aTargets": [ 13 ], 
                "width": "30px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.kategori_kes;
                }
            },{          
                "aTargets": [ 14 ], 
                "width": "30px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.peringkat_kes;
                }
            },{          
                "aTargets": [ 15 ], 
                "width": "30px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.bil_terlibat;
                }
            },{          
                "aTargets": [ 16 ], 
                "width": "30px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.status_etnik;
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