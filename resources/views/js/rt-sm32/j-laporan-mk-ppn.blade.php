@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_mk_config = {
			routes: {
				laporan_mk_url: "/rt/sm32/laporan-mk-ppn"
			}
		}; 

        $("#lm_state_id").on( 'change', function () {
			laporan_mk.column('0:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lm_daerah_id').find('option').remove();
            $('#lm_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_mk_config.routes.laporan_mk_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#lm_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lm_daerah_id')
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

        $("#lm_daerah_id").on( 'change', function () {
			laporan_mk.column('1:visible').search( $(this).val() ).draw();
		});

        var laporan_mk = $('#laporan_mk').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: '<"top"B><"pull-right"l>rtip',
            buttons: [
                {
                    extend: 'csvHtml5',
					exportOptions: {
						columns: "thead th:not(.noExport)",
						rows: function (indx, rowData, domElement) {
							return $(domElement).css("display") != "none";
						}
					}
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            iDisplayLength: -1,
            ajax: {url: laporan_mk_config.routes.laporan_mk_url},
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
            rowCallback: function(nRow, aData, index) {
                var info = laporan_mk.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
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
                    return full.mk_state;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "100px",
                sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
                    return full.mk_daerah;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "100px", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.mk_parlimen;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "100px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.mk_dun;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "100px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.mk_pbt;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "100px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.mk_mukim;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "150px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.mk_name;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "150px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.mk_ic;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "100px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.mk_kaum;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "50px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.mk_age;
                }
            },{          
                "aTargets": [ 11 ], 
                "width": "100px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.mk_pendidikan;
                }
            },{          
                "aTargets": [ 12 ], 
                "width": "100px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.mk_email;
                }
            },{          
                "aTargets": [ 13 ], 
                "width": "100px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.mk_phone;
                }
            },{          
                "aTargets": [ 14 ], 
                "width": "100px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.mkp_pemohon_khusus;
                }
            },{          
                "aTargets": [ 15 ], 
                "width": "200px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.mk_alamat_p;
                }
            },{          
                "aTargets": [ 16 ], 
                "width": "200px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.mk_alamat;
                }
            },{          
                "aTargets": [ 17 ], 
                "width": "100px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.mk_kategori;
                }
            },{          
                "aTargets": [ 18 ], 
                "width": "100px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.mk_tahap;
                }
            },{          
                "aTargets": [ 19 ], 
                "width": "100px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.mk_tarikh_lantik;
                }
            },{          
                "aTargets": [ 20 ], 
                "width": "100px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.status_pelanjutan;
                }
            },{          
                "aTargets": [ 21 ], 
                "width": "100px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.mk_krt_name;
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