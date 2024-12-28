@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<style>
	
}
</style>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_bil_mesyuarat_config = {
			routes: {
				laporan_bil_mesyuarat_url: "/rt/sm30/laporan-mesyuarat-krt-ppn"
			}
		};  
        
        $("#lmkpn_daerah_id").on( 'change', function () {
			senarai_bil_mesyuarat.column('2:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lmkpn_krt_id').find('option').remove();
            $('#lmkpn_krt_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_bil_mesyuarat_config.routes.laporan_bil_mesyuarat_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#lmkpn_krt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lmkpn_krt_id')
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

        $("#lmkpn_krt_id").on( 'change', function () {
			senarai_bil_mesyuarat.column('3:visible').search( $(this).val() ).draw();
			
        });
        
    	var senarai_bil_mesyuarat = $('#senarai_bil_mesyuarat').DataTable( {
			processing: true,
			serverSide: true,
			ajax: {url: laporan_bil_mesyuarat_config.routes.laporan_bil_mesyuarat_url},
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
                var info = senarai_bil_mesyuarat.page.info();
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
				"width": "150px", 
				"mRender": function ( value, type, full )  {
					return full.daerah_description;
				}
			},{          
				"aTargets": [ 2 ], 
				"width": "150px", 
				"mRender": function ( value, type, full )  {
					return full.krt_nama;
				}
			},{          
				"aTargets": [ 3 ], 
				"width": "20px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total;
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