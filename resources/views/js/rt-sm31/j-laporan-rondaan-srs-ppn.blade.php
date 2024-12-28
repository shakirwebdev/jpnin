@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<style>
	
}
</style>
<script type="text/javascript"> 

	$(document).ready( function () {
        
		//my custom script
		var laporan_rondaan_srs_config = {
			routes: {
				laporan_rondaan_srs_url: "{{ route('rt-sm31.laporan_rondaan_srs_ppn') }}",
            }
		}; 

        var currentYear = (new Date).getFullYear();
        var url = {url: laporan_rondaan_srs_config.routes.laporan_rondaan_srs_url}
        
        $("#lksrspn_year").on( 'change', function () {
			var value = $(this).find('option:selected').val();
            var newurl = "{{ route('rt-sm31.laporan_rondaan_srs_hqsrs_filter','') }}"+"/"+value
            $('#senarai_rondaan_srs_table').DataTable().ajax.url(newurl).load();

		});

        $("#lksrspn_daerah_id").on( 'change', function () {
			senarai_rondaan_srs_table.column('1:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lksrspn_krt_id').find('option').remove();
            $('#lksrspn_krt_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_rondaan_srs_config.routes.laporan_rondaan_srs_url,
                    data: {type: 'get_krt', value: value},
                    success: function (data) {
                        $('#lksrspn_krt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lksrspn_krt_id')
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

        $("#lksrspn_krt_id").on( 'change', function () {
			senarai_rondaan_srs_table.column('2:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lksrspn_srs_id').find('option').remove();
            $('#lksrspn_srs_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_rondaan_srs_config.routes.laporan_rondaan_srs_url,
                    data: {type: 'get_srs', value: value},
                    success: function (data) {
                        $('#lksrspn_srs_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lksrspn_srs_id')
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

		$("#lksrspn_srs_id").on( 'change', function () {
			senarai_rondaan_srs_table.column('3:visible').search( $(this).val() ).draw();
		});

        var senarai_rondaan_srs_table = $('#senarai_rondaan_srs_table').DataTable( {
			processing: true,
			serverSide: true,
			ajax: url,
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
                var info = senarai_rondaan_srs_table.page.info();
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
					return full.nama_krt;
				}
			},{          
				"aTargets": [ 4 ], 
				"width": "150px", 
				"mRender": function ( value, type, full )  {
					return full.nama_srs;
				}
			},{          
				"aTargets": [ 5 ], 
				"width": "50px", 
                sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_rondaan_jan;
				}
			},{          
				"aTargets": [ 6 ], 
				"width": "50px", 
                sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_rondaan_feb;
				}
			},{          
				"aTargets": [ 7 ], 
				"width": "50px",
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_rondaan_mar;
				}
			},{          
				"aTargets": [ 8 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_rondaan_apr;
				}
			},{          
				"aTargets": [ 9 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_rondaan_mei;
				}
			},{          
				"aTargets": [ 10 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_rondaan_jun;
				}
			},{          
				"aTargets": [ 11 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_rondaan_jul;
				}
			},{          
				"aTargets": [ 12 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_rondaan_aug;
				}
			},{          
				"aTargets": [ 13 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_rondaan_sep;
				}
			},{          
				"aTargets": [ 14 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_rondaan_oct;
				}
			},{          
				"aTargets": [ 15 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_rondaan_nov;
				}
			},{          
				"aTargets": [ 16 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_rondaan_dec;
				}
			},{          
				"aTargets": [ 17 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_ahli_peronda;
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