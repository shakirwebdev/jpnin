@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<style type="text/css">
	.series-frame {
	  /*max-width: 600px;*/
	  display: flex;
	  justify-content: space-between;
	  align-items: center;
	  box-sizing: border-box;
	  border: 2px solid #113f50;
	  /*margin: 30px;*/
	  padding: 10px;
	}

</style>
<script type="text/javascript">    
    
	$(document).ready( function () {
        
    	//my custom script
		var senarai_permohonan_pembatalan_krt_config = {
			routes: {
				senarai_permohonan_pembatalan_krt_url: "/rt/sm8/kelulusan-pembatalan-krt"
			}
		};

        $("#kpk_state_id").on( 'change', function () {
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
			$('#kpk_daerah_id').find('option').remove();
			$('#kpk_daerah_id').prop("disabled", false);
			if (selectedIndex !== '0') {
				$.ajax({
					type: "GET",
					url: senarai_permohonan_pembatalan_krt_config.routes.senarai_permohonan_pembatalan_krt_url,
					data: {type: 'get_daerah', value: value},
					success: function (data) {
						$('#kpk_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#kpk_daerah_id')
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

        $("#kpk_daerah_id").on( 'change', function () {
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
			$('#kpk_krt_id').find('option').remove();
			$('#kpk_krt_id').prop("disabled", false);
			if (selectedIndex !== '0') {
				$.ajax({
					type: "GET",
					url: senarai_permohonan_pembatalan_krt_config.routes.senarai_permohonan_pembatalan_krt_url,
					data: {type: 'get_krt', value: value},
					success: function (data) {
						$('#kpk_krt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
						$.each(data,function(key, obj) 
						{
							$('#kpk_krt_id')
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

		$("#kpk_krt_id").on( 'change', function () {
            senari_permohonan_pembatalan_krt.search( $(this).val() ).draw();
        });

        var senari_permohonan_pembatalan_krt = $('#senari_permohonan_pembatalan_krt').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_permohonan_pembatalan_krt_config.routes.senarai_permohonan_pembatalan_krt_url},
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
                "width": "14%", 
                "mRender": function ( value, type, full )  {
                    return 'RT'+full.state_id+full.daerah_id+full.id;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
                    return full.tujuan_description;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "17%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.tarikh_permohonan;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                    return full.status_description;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.status == '6') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kelulusan Permohonan Pembatalan KRT" id="edit-jpnin" onclick="kelulusan_permohonan_pembatalan_krt(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
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

    function kelulusan_permohonan_pembatalan_krt(id){
        window.location.href = "{{ route('rt-sm8.kelulusan_pembatalan_krt_1','') }}"+"/"+id;
    }

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop