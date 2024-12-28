@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_aktiviti_config = {
			routes: {
				laporan_aktiviti_url: "/rt/sm30/laporan-aktiviti-rt-kp"
			}
		}; 

		$("#larhq_state_id").on( 'change', function () {
			laporan_aktiviti.column('0:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#larhq_daerah_id').find('option').remove();
            $('#larhq_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_aktiviti_config.routes.laporan_aktiviti_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#larhq_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#larhq_daerah_id')
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

		$("#larhq_daerah_id").on( 'change', function () {
			laporan_aktiviti.column('1:visible').search( $(this).val() ).draw();
		});

		$("#larhq_agenda_id").on( 'change', function () {
			laporan_aktiviti.column('6:visible').search( $(this).val() ).draw();
		});

		$("#larhq_bidang_id").on( 'change', function () {
			laporan_aktiviti.column('7:visible').search( $(this).val() ).draw();
		});

		$("#larhq_k_aktiviti_id").on( 'change', function () {
			laporan_aktiviti.column('8:visible').search( $(this).val() ).draw();
		});

		$("#larhq_j_aktiviti_id").on( 'change', function () {
			laporan_aktiviti.column('9:visible').search( $(this).val() ).draw();
		});

		var laporan_aktiviti = $('#laporan_aktiviti').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: '<"top"B><"pull-right"l>rtip',
            buttons: [
                {
                    extend: 'csvHtml5'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Laporan Aktiviti RT',
                    orientation: 'landscape',
                    pageSize: 'LETTER',
					customize:  function (doc) {
                    doc.layout = 'lightHorizotalLines;'
                    doc.pageMargins = [20, 20, 20, 20];
                    doc.defaultStyle.fontSize = 11;
                    doc.styles.tableHeader.fontSize = 11;
                    doc.styles.title.fontSize = 14;
 
                    // How do I set column widths to [100,150,150,100,100,'*']  ?
 
            }
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            ajax: {url: laporan_aktiviti_config.routes.laporan_aktiviti_url},
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
                    return full.krt_name;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.penganjur;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.tajuk_aktiviti;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.perasmi_aktiviti;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.agenda_kerja;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.bidang_kerja;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.kategori_aktiviti;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.jenis_aktiviti;
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