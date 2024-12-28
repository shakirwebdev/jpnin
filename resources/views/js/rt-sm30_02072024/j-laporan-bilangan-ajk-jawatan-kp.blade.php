@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<style>
	
}
</style>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_bilangan_ajk_jawatan_kp_config = {
			routes: {
				laporan_bilangan_ajk_jawatan_kp_url: "/rt/sm30/laporan-bilangan-ajk-jawatan-kp",
				get_total_ajk_jawatan_pengerusi_kp_url: "{{ route('rt-sm30.get_total_ajk_jawatan_pengerusi_kp') }}",
				get_total_ajk_jawatan_tpengerusi_kp_url: "{{ route('rt-sm30.get_total_ajk_jawatan_tpengerusi_kp') }}",
				get_total_ajk_jawatan_setiausaha_kp_url: "{{ route('rt-sm30.get_total_ajk_jawatan_setiausaha_kp') }}",
				get_total_ajk_jawatan_bendahari_kp_url: "{{ route('rt-sm30.get_total_ajk_jawatan_bendahari_kp') }}",
				get_total_ajk_jawatan_psetiausaha_kp_url: "{{ route('rt-sm30.get_total_ajk_jawatan_psetiausaha_kp') }}",
				get_total_ajk_jawatan_ajk_kp_url: "{{ route('rt-sm30.get_total_ajk_jawatan_ajk_kp') }}",
			}
		};  

		$("#lbajkp_state_id").on( 'change', function () {
			bilangan_ajk_krt_pengerusi.search( $(this).val() ).draw();
			bilangan_ajk_krt_tpengerusi.search( $(this).val() ).draw();
			bilangan_ajk_krt_setiausaha.search( $(this).val() ).draw();
			bilangan_ajk_krt_bendahari.search( $(this).val() ).draw();
			bilangan_ajk_krt_psetiausaha.search( $(this).val() ).draw();
			bilangan_ajk_krt_ajk.search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lbajkp_daerah_id').find('option').remove();
            $('#lbajkp_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_bilangan_ajk_jawatan_kp_config.routes.laporan_bilangan_ajk_jawatan_kp_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#lbajkp_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lbajkp_daerah_id')
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

		$("#lbajkp_daerah_id").on( 'change', function () {
			bilangan_ajk_krt_pengerusi.search( $(this).val() ).draw();
			bilangan_ajk_krt_tpengerusi.search( $(this).val() ).draw();
			bilangan_ajk_krt_setiausaha.search( $(this).val() ).draw();
			bilangan_ajk_krt_bendahari.search( $(this).val() ).draw();
			bilangan_ajk_krt_psetiausaha.search( $(this).val() ).draw();
			bilangan_ajk_krt_ajk.search( $(this).val() ).draw();
		});

		$("#lbajkp_state_id").on( 'change', function () {
			bilangan_ajk_krt_pengerusi.search( $(this).val() ).draw();
			bilangan_ajk_krt_tpengerusi.search( $(this).val() ).draw();
			bilangan_ajk_krt_setiausaha.search( $(this).val() ).draw();
			bilangan_ajk_krt_bendahari.search( $(this).val() ).draw();
			bilangan_ajk_krt_psetiausaha.search( $(this).val() ).draw();
			bilangan_ajk_krt_ajk.search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lbajkp_parlimen_id').find('option').remove();
            $('#lbajkp_parlimen_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_bilangan_ajk_jawatan_kp_config.routes.laporan_bilangan_ajk_jawatan_kp_url,
                    data: {type: 'get_parlimen', value: value},
                    success: function (data) {
                        $('#lbajkp_parlimen_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lbajkp_parlimen_id')
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

		$("#lbajkp_parlimen_id").on( 'change', function () {
			bilangan_ajk_krt_pengerusi.search( $(this).val() ).draw();
			bilangan_ajk_krt_tpengerusi.search( $(this).val() ).draw();
			bilangan_ajk_krt_setiausaha.search( $(this).val() ).draw();
			bilangan_ajk_krt_bendahari.search( $(this).val() ).draw();
			bilangan_ajk_krt_psetiausaha.search( $(this).val() ).draw();
			bilangan_ajk_krt_ajk.search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lbajkp_dun_id').find('option').remove();
            $('#lbajkp_dun_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_bilangan_ajk_jawatan_kp_config.routes.laporan_bilangan_ajk_jawatan_kp_url,
                    data: {type: 'get_dun', value: value},
                    success: function (data) {
                        $('#lbajkp_dun_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lbajkp_dun_id')
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

		$("#lbajkp_dun_id").on( 'change', function () {
			bilangan_ajk_krt_pengerusi.search( $(this).val() ).draw();
			bilangan_ajk_krt_tpengerusi.search( $(this).val() ).draw();
			bilangan_ajk_krt_setiausaha.search( $(this).val() ).draw();
			bilangan_ajk_krt_bendahari.search( $(this).val() ).draw();
			bilangan_ajk_krt_psetiausaha.search( $(this).val() ).draw();
			bilangan_ajk_krt_ajk.search( $(this).val() ).draw();
		});
        
    	var bilangan_ajk_krt_pengerusi = $('#bilangan_ajk_krt_pengerusi').DataTable( {
			processing: true,
			serverSide: true,
			ajax: laporan_bilangan_ajk_jawatan_kp_config.routes.get_total_ajk_jawatan_pengerusi_kp_url,
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
			"aoColumnDefs":[{          
				"aTargets": [ 0 ], 
				"width": "6%", 
				sClass: 'text-center',
				"mRender": function (data, type, full, meta)  {
					return  meta.row+1;
				}
			},{          
				"aTargets": [ 1 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.state;
				}
			},{          
				"aTargets": [ 2 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.daerah;
				}
			},{          
				"aTargets": [ 3 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.parlimen;
				}
			},{          
				"aTargets": [ 4 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.dun;
				}
			},{          
				"aTargets": [ 5 ], 
				"width": "20%", 
				"mRender": function ( value, type, full )  {
					return full.krt_nama;
				}
			},{          
				"aTargets": [ 6 ], 
				"width": "28%", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.jawatan;
				}
			},{          
				"aTargets": [ 7 ], 
				"width": "28%", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_jawatan;
				}
			}],
			"order": [[ 0, 'asc' ]],
			initComplete: function () {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});

		var bilangan_ajk_krt_tpengerusi = $('#bilangan_ajk_krt_tpengerusi').DataTable( {
			processing: true,
			serverSide: true,
			ajax: laporan_bilangan_ajk_jawatan_kp_config.routes.get_total_ajk_jawatan_tpengerusi_kp_url,
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
			"aoColumnDefs":[{          
				"aTargets": [ 0 ], 
				"width": "6%", 
				sClass: 'text-center',
				"mRender": function (data, type, full, meta)  {
					return  meta.row+1;
				}
			},{          
				"aTargets": [ 1 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.state;
				}
			},{          
				"aTargets": [ 2 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.daerah;
				}
			},{          
				"aTargets": [ 3 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.parlimen;
				}
			},{          
				"aTargets": [ 4 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.dun;
				}
			},{          
				"aTargets": [ 5 ], 
				"width": "20%", 
				"mRender": function ( value, type, full )  {
					return full.krt_nama;
				}
			},{          
				"aTargets": [ 6 ], 
				"width": "28%", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.jawatan;
				}
			},{          
				"aTargets": [ 7 ], 
				"width": "28%", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_jawatan;
				}
			}],
			"order": [[ 0, 'asc' ]],
			initComplete: function () {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});

		var bilangan_ajk_krt_setiausaha = $('#bilangan_ajk_krt_setiausaha').DataTable( {
			processing: true,
			serverSide: true,
			ajax: laporan_bilangan_ajk_jawatan_kp_config.routes.get_total_ajk_jawatan_setiausaha_kp_url,
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
			"aoColumnDefs":[{          
				"aTargets": [ 0 ], 
				"width": "6%", 
				sClass: 'text-center',
				"mRender": function (data, type, full, meta)  {
					return  meta.row+1;
				}
			},{          
				"aTargets": [ 1 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.state;
				}
			},{          
				"aTargets": [ 2 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.daerah;
				}
			},{          
				"aTargets": [ 3 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.parlimen;
				}
			},{          
				"aTargets": [ 4 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.dun;
				}
			},{          
				"aTargets": [ 5 ], 
				"width": "20%", 
				"mRender": function ( value, type, full )  {
					return full.krt_nama;
				}
			},{          
				"aTargets": [ 6 ], 
				"width": "28%", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.jawatan;
				}
			},{          
				"aTargets": [ 7 ], 
				"width": "28%", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_jawatan;
				}
			}],
			"order": [[ 0, 'asc' ]],
			initComplete: function () {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});

		var bilangan_ajk_krt_bendahari = $('#bilangan_ajk_krt_bendahari').DataTable( {
			processing: true,
			serverSide: true,
			ajax: laporan_bilangan_ajk_jawatan_kp_config.routes.get_total_ajk_jawatan_bendahari_kp_url,
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
			"aoColumnDefs":[{          
				"aTargets": [ 0 ], 
				"width": "6%", 
				sClass: 'text-center',
				"mRender": function (data, type, full, meta)  {
					return  meta.row+1;
				}
			},{          
				"aTargets": [ 1 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.state;
				}
			},{          
				"aTargets": [ 2 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.daerah;
				}
			},{          
				"aTargets": [ 3 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.parlimen;
				}
			},{          
				"aTargets": [ 4 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.dun;
				}
			},{          
				"aTargets": [ 5 ], 
				"width": "20%", 
				"mRender": function ( value, type, full )  {
					return full.krt_nama;
				}
			},{          
				"aTargets": [ 6 ], 
				"width": "28%", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.jawatan;
				}
			},{          
				"aTargets": [ 7 ], 
				"width": "28%", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_jawatan;
				}
			}],
			"order": [[ 0, 'asc' ]],
			initComplete: function () {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});

		var bilangan_ajk_krt_psetiausaha = $('#bilangan_ajk_krt_psetiausaha').DataTable( {
			processing: true,
			serverSide: true,
			ajax: laporan_bilangan_ajk_jawatan_kp_config.routes.get_total_ajk_jawatan_psetiausaha_kp_url,
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
			"aoColumnDefs":[{          
				"aTargets": [ 0 ], 
				"width": "6%", 
				sClass: 'text-center',
				"mRender": function (data, type, full, meta)  {
					return  meta.row+1;
				}
			},{          
				"aTargets": [ 1 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.state;
				}
			},{          
				"aTargets": [ 2 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.daerah;
				}
			},{          
				"aTargets": [ 3 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.parlimen;
				}
			},{          
				"aTargets": [ 4 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.dun;
				}
			},{          
				"aTargets": [ 5 ], 
				"width": "20%", 
				"mRender": function ( value, type, full )  {
					return full.krt_nama;
				}
			},{          
				"aTargets": [ 6 ], 
				"width": "28%", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.jawatan;
				}
			},{          
				"aTargets": [ 7 ], 
				"width": "28%", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_jawatan;
				}
			}],
			"order": [[ 0, 'asc' ]],
			initComplete: function () {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});

		var bilangan_ajk_krt_ajk = $('#bilangan_ajk_krt_ajk').DataTable( {
			processing: true,
			serverSide: true,
			ajax: laporan_bilangan_ajk_jawatan_kp_config.routes.get_total_ajk_jawatan_ajk_kp_url,
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
			"aoColumnDefs":[{          
				"aTargets": [ 0 ], 
				"width": "6%", 
				sClass: 'text-center',
				"mRender": function (data, type, full, meta)  {
					return  meta.row+1;
				}
			},{          
				"aTargets": [ 1 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.state;
				}
			},{          
				"aTargets": [ 2 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.daerah;
				}
			},{          
				"aTargets": [ 3 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.parlimen;
				}
			},{          
				"aTargets": [ 4 ], 
				"width": "15%", 
				"mRender": function ( value, type, full )  {
					return full.dun;
				}
			},{          
				"aTargets": [ 5 ], 
				"width": "20%", 
				"mRender": function ( value, type, full )  {
					return full.krt_nama;
				}
			},{          
				"aTargets": [ 6 ], 
				"width": "28%", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.jawatan;
				}
			},{          
				"aTargets": [ 7 ], 
				"width": "28%", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_jawatan;
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