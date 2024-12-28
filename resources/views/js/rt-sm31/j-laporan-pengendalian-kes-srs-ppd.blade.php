@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<style>
	
}
</style>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_pengendalian_kes_config = {
			routes: {
				laporan_pengendalian_kes_url: "/rt/sm31/laporan-pengendalian-kes-srs-ppd"
			}
		};  

		var url = {url: laporan_pengendalian_kes_config.routes.laporan_pengendalian_kes_url}

		$("#lpksrspn_year_id").on( 'change', function () {
			var value = $(this).find('option:selected').val();
            var newurl = "{{ route('rt-sm31.laporan_pengendalian_kes_srs_ppn_filter','') }}"+"/"+value
            $('#pengendalian_kes_srs_table').DataTable().ajax.url(newurl).load();

		});

		$("#lpksrspn_krt_id").on( 'change', function () {
			pengendalian_kes_srs_table.column('2:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#lpksrspn_srs_id').find('option').remove();
            $('#lpksrspn_srs_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_pengendalian_kes_config.routes.laporan_pengendalian_kes_url,
                    data: {type: 'get_srs', value: value},
                    success: function (data) {
                        $('#lpksrspn_srs_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#lpksrspn_srs_id')
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

		$("#lpksrspn_srs_id").on( 'change', function () {
			pengendalian_kes_srs_table.column('3:visible').search( $(this).val() ).draw();
		});

        var pengendalian_kes_srs_table = $('#pengendalian_kes_srs_table').DataTable( {
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
                var info = pengendalian_kes_srs_table.page.info();
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
					return full.nama_krt;
				}
			},{          
				"aTargets": [ 3 ], 
				"width": "150px", 
				"mRender": function ( value, type, full )  {
					return full.nama_srs;
				}
			},{          
				"aTargets": [ 4 ], 
				"width": "50px", 
                sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.kategori_kes;
				}
			},{          
				"aTargets": [ 5 ], 
				"width": "50px", 
                sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.jenis_kes;
				}
			},{          
				"aTargets": [ 6 ], 
				"width": "50px",
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.jumlah_terlibat;
				}
			},{          
				"aTargets": [ 7 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_ml;
				}
			},{          
				"aTargets": [ 8 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_mp;
				}
			},{          
				"aTargets": [ 9 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_cl;
				}
			},{          
				"aTargets": [ 10 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_cp;
				}
			},{          
				"aTargets": [ 11 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_il;
				}
			},{          
				"aTargets": [ 12 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_ip;
				}
			},{          
				"aTargets": [ 13 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_sbl;
				}
			},{          
				"aTargets": [ 14 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_sbp;
				}
			},{          
				"aTargets": [ 15 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_swl;
				}
			},{          
				"aTargets": [ 16 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_swp;
				}
			},{          
				"aTargets": [ 17 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_age1;
				}
			},{          
				"aTargets": [ 18 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_age2;
				}
			},{          
				"aTargets": [ 19 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_age3;
				}
			},{          
				"aTargets": [ 20 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_age4;
				}
			},{          
				"aTargets": [ 21 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.total_age5;
				}
			},{          
				"aTargets": [ 22 ], 
				"width": "50px", 
				sClass: 'text-center',
				"mRender": function ( value, type, full )  {
					return full.kes_dirujuk;
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