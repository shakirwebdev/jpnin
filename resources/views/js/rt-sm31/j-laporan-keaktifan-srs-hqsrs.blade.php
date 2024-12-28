@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<style>
	
}
</style>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_peronda_keaktifan_srs_config = {
			routes: {
				laporan_peronda_keaktifan_srs_url: "/rt/sm31/laporan-keaktifan-srs-hqsrs"
			}
		}; 

		var senarai_keaktifan_srs_table = $('#senarai_keaktifan_srs_table').DataTable( {
			processing: true,
			serverSide: true,
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
			responsive: true
		});

        
    });

	

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop