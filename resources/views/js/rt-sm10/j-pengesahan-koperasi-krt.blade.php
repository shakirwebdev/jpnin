@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {

		//my custom script
		var senarai_permohonan_koperasi_config = {
			routes: {
				senarai_permohonan_koperasi_url: "/rt/sm10/pengesahan-koperasi-krt"
			}
		};

        $("#pkkpn_daerah_id").on( 'change', function () {
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
			$('#pkkpn_krt_id').find('option').remove();
			$('#pkkpn_krt_id').prop("disabled", false);
			if (selectedIndex !== '0') {
				$.ajax({
					type: "GET",
					url: senarai_permohonan_koperasi_config.routes.senarai_permohonan_koperasi_url,
					data: {type: 'get_krt', value: value},
					success: function (data) {
						$('#pkkpn_krt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#pkkpn_krt_id')
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

		$("#pkkpn_krt_id").on( 'change', function () {
            senarai_permohonan_koperasi.search( $(this).val() ).draw();
        });
        
		var senarai_permohonan_koperasi = $('#senarai_permohonan_koperasi').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_permohonan_koperasi_config.routes.senarai_permohonan_koperasi_url},
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
                    return full.krt_nama;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.koperasi_nama;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "10%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.koperasi_bilangan_ahli_lembaga;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "10%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.koperasi_jumlah_anggota;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "12%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.status_koperasi_keaktifan;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
					return full.status_permohonan;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.status == '6') {
                        button_a = '<button type="button" class="btn btn-icon" title="Pengesahan Permohonan Koperasi" onclick="pengesahan_permohonan_koperasi(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a;
                    } else {
                        button_b = '';
                        return button_b;
                    }
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });

    });

	function pengesahan_permohonan_koperasi(id){
		window.location.href = "{{ route('rt-sm10.pengesahan_koperasi_krt_1','') }}"+"/"+id;
	}

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop