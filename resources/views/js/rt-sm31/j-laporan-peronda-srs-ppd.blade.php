@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_peronda_srs_config = {
			routes: {
				laporan_peronda_srs_url: "/rt/sm31/laporan-peronda-srs-ppd"
			}
		};  

		$("#lppn_krt_id").on( 'change', function () {
			senarai_ahli_peronda_table.column('3:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lppn_srs_id').find('option').remove();
            $('#lppn_srs_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_peronda_srs_config.routes.laporan_peronda_srs_url,
                    data: {type: 'get_srs', value: value},
                    success: function (data) {
                        $('#lppn_srs_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lppn_srs_id')
                            .append($('<option>')
                            .text(obj.srs_name)
                            .attr('value', obj.srs_name));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

		$("#lppn_srs_id").on( 'change', function () {
			senarai_ahli_peronda_table.column('4:visible').search( $(this).val() ).draw();
		});

		var senarai_ahli_peronda_table = $('#senarai_ahli_peronda_table').DataTable( {
			processing: true,
			serverSide: true,
			ajax: {url: laporan_peronda_srs_config.routes.laporan_peronda_srs_url},
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
			dom: 'rtip',
			"bFilter": true,
			"bSort": false,
			responsive: true,
			rowCallback: function(nRow, aData, index) {
                var info = senarai_ahli_peronda_table.page.info();
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
				"width": "100px", 
				"mRender": function ( value, type, full )  {
					return full.daerah;
				}
			},{          
				"aTargets": [ 2 ], 
				"width": "150px", 
				"mRender": function ( value, type, full )  {
					return full.peronda_krt;
				}
			},{          
				"aTargets": [ 3 ], 
				"width": "150px", 
				"mRender": function ( value, type, full )  {
					return full.peronda_srs;
				}
			},{          
				"aTargets": [ 4 ], 
				"width": "150px", 
				"mRender": function ( value, type, full )  {
					return full.peronda_nama;
				}
			},{          
				"aTargets": [ 5 ], 
				"width": "50px", 
				"mRender": function ( value, type, full )  {
					return full.peronda_kad_no;
				}
			},{          
				"aTargets": [ 6 ], 
				"width": "50px", 
				"mRender": function ( value, type, full )  {
					return full.peronda_kaum;
				}
			},{          
				"aTargets": [ 7 ], 
				"width": "20px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.peronda_jantina;
				}
			},{          
				"aTargets": [ 8 ], 
				"width": "10px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.peronda_umur;
				}
			},{          
				"aTargets": [ 9 ], 
				"width": "200px", 
				"mRender": function ( value, type, full )  {
					return full.peronda_alamat;
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