@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	$(document).ready( function () {
        
    	//my custom script
		var senarai_permohonan_pembatalan_srs_config = {
			routes: {
				senarai_permohonan_pembatalan_srs_url: "/rt/sm19/semakan-pembatalan-srs-ppd"
			}
		};

        $("#ppspd_krt_profile_id").on( 'change', function () {
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
			$('#ppspd_srs_profile_id').find('option').remove();
			$('#ppspd_srs_profile_id').prop("disabled", false);
			if (selectedIndex !== '0') {
				$.ajax({
					type: "GET",
					url: senarai_permohonan_pembatalan_srs_config.routes.senarai_permohonan_pembatalan_srs_url,
					data: {type: 'get_srs', value: value},
					success: function (data) {
						$('#ppspd_srs_profile_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#ppspd_srs_profile_id')
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

        $("#ppspd_srs_profile_id").on( 'change', function () {
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
			"aoColumnDefs":[{          
                "aTargets": [ 0 ], 
                "width": "6%", 
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                    return  meta.row+1;
                }
            },{          
                "aTargets": [ 1 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.nama_krt;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.nama_srs;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "17%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.tahun_ditubuhkan_srs;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.dimohon_oleh;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                    return full.status;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.pembatalan_status == '3') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Permohonan Penubuhan SRS" id="edit-jpnin" onclick="kemaskini_permohonan_pembatalan_srs(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    return button_a;
                    } else if (full.pembatalan_status == '7') {
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
        window.location.href = "{{ route('rt-sm19.semakan_pembatalan_srs_ppd_1','') }}"+"/"+id;
    }

    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop