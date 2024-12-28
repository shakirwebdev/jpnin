@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_ajk_krt_hqrt_config = {
			routes: {
				laporan_ajk_krt_hqrt_url: "/rt/sm30/laporan-ajk-krt-hqrt"
			}
		}; 
        
        

        $("#lakhq_state_id").on( 'change', function () {
			laporan_ajk_krt_hqrt.search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lakhq_daerah_id').find('option').remove();
            $('#lakhq_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_ajk_krt_hqrt_config.routes.laporan_ajk_krt_hqrt_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#lakhq_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lakhq_daerah_id')
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

        $("#lakhq_state_id").on( 'change', function () {
			laporan_ajk_krt_hqrt.search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lakhq_parlimen_id').find('option').remove();
            $('#lakhq_parlimen_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_ajk_krt_hqrt_config.routes.laporan_ajk_krt_hqrt_url,
                    data: {type: 'get_parlimen', value: value},
                    success: function (data) {
                        $('#lakhq_parlimen_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lakhq_parlimen_id')
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

        $("#lakhq_parlimen_id").on( 'change', function () {
			laporan_ajk_krt_hqrt.search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lakhq_dun_id').find('option').remove();
            $('#lakhq_dun_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_ajk_krt_hqrt_config.routes.laporan_ajk_krt_hqrt_url,
                    data: {type: 'get_dun', value: value},
                    success: function (data) {
                        $('#lakhq_dun_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lakhq_dun_id')
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

        $("#lakhq_dun_id").on( 'change', function () {
			laporan_ajk_krt_hqrt.search( $(this).val() ).draw();
		});

        $("#lakhq_daerah_id").on( 'change', function () {
			laporan_ajk_krt_hqrt.search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lakhq_krt_id').find('option').remove();
            $('#lakhq_krt_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_ajk_krt_hqrt_config.routes.laporan_ajk_krt_hqrt_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#lakhq_krt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lakhq_krt_id')
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

        $("#lakhq_krt_id").on( 'change', function () {
			laporan_ajk_krt_hqrt.search( $(this).val() ).draw();
		});

        $("#lakhq_kaum_id").on( 'change', function () {
			laporan_ajk_krt_hqrt.search( $(this).val() ).draw();
		});

        $("#lakhq_pendidikan_id").on( 'change', function () {
			laporan_ajk_krt_hqrt.search( $(this).val() ).draw();
		});

        $("#lakhq_jawatan_id").on( 'change', function () {
			laporan_ajk_krt_hqrt.search( $(this).val() ).draw();
		});

        var laporan_ajk_krt_hqrt = $('#laporan_ajk_krt_hqrt').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: '<"top"B><"pull-right"l>rtip',
            buttons: [
                {
                    extend: 'csvHtml5'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Laporan Ahli Jawatankuasa Rukun Tetangga',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            ajax: {url: laporan_ajk_krt_hqrt_config.routes.laporan_ajk_krt_hqrt_url},
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
					return full.ajk_nama;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.ajk_ic;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "150px", 
                "mRender": function ( value, type, full )  {
					return full.ajk_alamat;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "40px", 
                "mRender": function ( value, type, full )  {
					return full.ajk_jantina;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.ajk_kaum;
                }
            },{          
                "aTargets": [ 11 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.ajk_agama;
                }
            },{          
                "aTargets": [ 12 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.ajk_pendidikan;
                }
            },{          
                "aTargets": [ 13 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.ajk_profession;
                }
            },{          
                "aTargets": [ 14 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.ajk_jawatan;
                }
            },{          
                "aTargets": [ 15 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.ajk_phone;
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