@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_ajk_krt_config = {
			routes: {
				laporan_ajk_krt_url: "/rt/sm30/laporan-ajk-krt-setiausaha"
			}
		}; 

        $("#lakppd_kaum_id").on( 'change', function () {
			laporan_ajk_krt.column('12:visible').search( $(this).val() ).draw();
		});

        $("#lakppd_pendidikan_id").on( 'change', function () {
			laporan_ajk_krt.column('14:visible').search( $(this).val() ).draw();
		});

        $("#lakppd_jawatan_id").on( 'change', function () {
			laporan_ajk_krt.column('16:visible').search( $(this).val() ).draw();
		});
		
		$("#lakppd_penggal_id").on( 'change', function () {
			var aa=$("#lakppd_penggal_id option:selected" ).text().substr(0, 4);
			laporan_ajk_krt.columns(5).search(aa).draw();
		});

        var laporan_ajk_krt = $('#laporan_ajk_krt').DataTable( {
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
            ajax: {url: laporan_ajk_krt_config.routes.laporan_ajk_krt_url},
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
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.penggal_mula+'/'+full.penggal_tamat;
                }
            },{ 
                "aTargets": [ 6 ], 
                "width": "100px", 
                "mRender": function ( value, type, full )  {
					return full.krt_nama;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "100px", 
                "mRender": function ( value, type, full )  {
					return full.ajk_nama;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.ajk_ic;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "150px", 
                "mRender": function ( value, type, full )  {
					return full.ajk_alamat;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "40px", 
                "mRender": function ( value, type, full )  {
					return full.ajk_jantina;
                }
            },{          
                "aTargets": [ 11 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.ajk_kaum;
                }
            },{          
                "aTargets": [ 12 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.ajk_agama;
                }
            },{          
                "aTargets": [ 13 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.ajk_pendidikan;
                }
            },{          
                "aTargets": [ 14 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.ajk_profession;
                }
            },{          
                "aTargets": [ 15 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.ajk_jawatan;
                }
            },{          
                "aTargets": [ 16 ], 
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