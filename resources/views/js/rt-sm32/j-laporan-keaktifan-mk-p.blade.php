@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_keaktifan_mk_config = {
			routes: {
				laporan_keaktifan_mk_url: "/rt/sm32/laporan-keaktifan-mk-p"
			}
		}; 

        $("#lkm_state_id").on( 'change', function () {
			laporan_keaktifan_mk.column('0:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lkm_daerah_id').find('option').remove();
            $('#lkm_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_keaktifan_mk_config.routes.laporan_keaktifan_mk_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#lkm_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lkm_daerah_id')
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

        $("#lkm_daerah_id").on( 'change', function () {
			laporan_keaktifan_mk.column('1:visible').search( $(this).val() ).draw();
		});

        var laporan_keaktifan_mk = $('#laporan_keaktifan_mk').DataTable( {
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
            ajax: {url: laporan_keaktifan_mk_config.routes.laporan_keaktifan_mk_url},
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
                var info = laporan_keaktifan_mk.page.info();
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
					return full.mk_name;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "100px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.mk_ic;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "100px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.kes_selesai;
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "100px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.kes_xselesai;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "100px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_aktiviti;
                }
            },{          
                "aTargets": [ 11 ], 
                "width": "100px",
				sClass: 'text-center', 
                "mRender": function ( value, type, full )  {
					return full.total_latihan;
                }
            },{          
                "aTargets": [ 12 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    button_a = '<button type="button" class="btn btn-icon" title="Paparan Keaktifan Mediator Komuniti Individu" onclick="paparan_keaktifan_mkp_p(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
					return button_a
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });
    });

    function paparan_keaktifan_mkp_p(id){
		window.location.href = "{{ route('rt-sm32.keaktifan_mkp_individu_p','') }}"+"/"+id;
	}

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop