@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	$(document).ready( function () {
        
    	//my custom script
		var senarai_permohonan_pembatalan_srs_config = {
			routes: {
				senarai_permohonan_pembatalan_srs_url: "/rt/sm19/kelulusan-pembatalan-srs-hq"
			}
		};

        $("#kpshq_state_id").on( 'change', function () {
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
			$('#kpshq_daerah_id').find('option').remove();
			$('#kpshq_daerah_id').prop("disabled", false);
			if (selectedIndex !== '0') {
				$.ajax({
					type: "GET",
					url: senarai_permohonan_pembatalan_srs_config.routes.senarai_permohonan_pembatalan_srs_url,
					data: {type: 'get_daerah', value: value},
					success: function (data) {
						$('#kpshq_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#kpshq_daerah_id')
							.append($('<option>')
							.text(obj.daerah_description)
							.attr('value', obj.daerah_id));
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}
		});

        $("#kpshq_daerah_id").on( 'change', function () {
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
			$('#kpshq_krt_profile_id').find('option').remove();
			$('#kpshq_krt_profile_id').prop("disabled", false);
			if (selectedIndex !== '0') {
				$.ajax({
					type: "GET",
					url: senarai_permohonan_pembatalan_srs_config.routes.senarai_permohonan_pembatalan_srs_url,
					data: {type: 'get_krt', value: value},
					success: function (data) {
						$('#kpshq_krt_profile_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#kpshq_krt_profile_id')
							.append($('<option>')
							.text(obj.krt_nama)
							.attr('value', obj.id));
						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 
			}
		});

        $("#kpshq_krt_profile_id").on( 'change', function () {
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
			$('#kpshq_srs_profile_id').find('option').remove();
			$('#kpshq_srs_profile_id').prop("disabled", false);
			if (selectedIndex !== '0') {
				$.ajax({
					type: "GET",
					url: senarai_permohonan_pembatalan_srs_config.routes.senarai_permohonan_pembatalan_srs_url,
					data: {type: 'get_srs', value: value},
					success: function (data) {
						$('#kpshq_srs_profile_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#kpshq_srs_profile_id')
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

		$("#kpshq_srs_profile_id").on( 'change', function () {
            senarai_permohonan_penarikan_diri.search( $(this).val() ).draw();
        });

        var senarai_permohonan_penarikan_diri = $('#senarai_permohonan_penarikan_diri').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_permohonan_pembatalan_srs_config.routes.senarai_permohonan_pembatalan_srs_url},
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
                var info = senarai_permohonan_penarikan_diri.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
			"aoColumnDefs":[{          
                "aTargets": [ 0 ], 
                "width": "6%", 
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                    return  meta.row+1;
                }
            },{          
                "aTargets": [ 1 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                    return full.state;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                    return full.daerah;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                    return full.nama_krt;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                    return full.nama_srs;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "10%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.tahun_ditubuhkan_srs;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                    return full.dimohon_oleh;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                    return full.status;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.pembatalan_status == '6') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Permohonan Penubuhan SRS" id="edit-jpnin" onclick="kemaskini_permohonan_pembatalan_srs(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
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

    function kemaskini_permohonan_pembatalan_srs(id){
        window.location.href = "{{ route('rt-sm19.kelulusan_pembatalan_srs_hq_1','') }}"+"/"+id;
    }

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop