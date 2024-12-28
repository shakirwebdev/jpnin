@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_srs_config = {
			routes: {
				laporan_srs_url: "/rt/sm31/laporan-pembantalan-srs-ppn"
			}
		};  

        $("#lpspn_daerah_id").on( 'change', function () {
			senarai_pembatalan_srs_table.column('2:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lpspn_krt_id').find('option').remove();
            $('#lpspn_krt_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_srs_config.routes.laporan_srs_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#lpspn_krt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lpspn_krt_id')
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

		$("#lpspn_krt_id").on( 'change', function () {
			senarai_pembatalan_srs_table.column('3:visible').search( $(this).val() ).draw();
		});
        
    	var senarai_pembatalan_srs_table = $('#senarai_pembatalan_srs_table').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: '<"top"B><"pull-right"l>rtip',
            buttons: [
                {
                    extend: 'csvHtml5'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Laporan Pembatalan SRS',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
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
                "width": "100px", 
                "mRender": function ( value, type, full )  {
					return full.krt_nama;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "100px", 
                "mRender": function ( value, type, full )  {
					return full.srs_nama;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "30px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.no_rujukan_srs;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "30px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.jumlah_peronda;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "30px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.tarikh_ditubuhkan_srs;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "30px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.tarikh_pembatalan_srs;
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