@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">

    $(document).ready( function () {

        //my custom script
		url_delete_minit_mesyuarat 		= "{{ route('rt-sm5.delete_minit','') }}";
		var senarai_minit_mesyuarat_config = {
			routes: {
				senarai_minit_mesyuarat_url: "/rt/sm5/senarai-minit-mesyuarat-rt"
			}
		};

    	var senarai_minit_mesyuarat_table = $('#senarai_minit_mesyuarat_table').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_minit_mesyuarat_config.routes.senarai_minit_mesyuarat_url},
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
            rowCallback: function(nRow, aData, index) {
                var info = senarai_minit_mesyuarat_table.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
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
                "width": "29%", 
                "mRender": function ( value, type, full )  {
                    return full.mesyuarat_title;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.mesyuarat_tarikh;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "29%", 
                "mRender": function ( value, type, full )  {
					return full.mesyuarat_tempat;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.status_description;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.mesyuarat_status == '2') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Minit Mesyuarat" onclick="kemaskini_minit_mesyuarat_rt(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
						button_b = '<button type="button" class="btn btn-icon" title="Buang Minit Maklumat" id="delete_minit_mesyuarat" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
					    return button_a + button_b;
                    } else if (full.mesyuarat_status == '4') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini Minit Mesyuarat" onclick="kemaskini_minit_mesyuarat_rt(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
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
		
		$('body').on('click', '#delete_minit_mesyuarat', function () {
			var delete_id = $(this).data("id");
			swal({
				title: "Anda pasti?",
				text: "Anda akan memadam rekod ini dari pangkalan data!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#dc3545",
				confirmButtonText: "Ya, sila padam!",
				cancelButtonText: "Tidak",
				closeOnConfirm: false,
				closeOnCancel: false
			}, function (isConfirm) {
				if (isConfirm) {
					$.ajax({
						type: "GET",
						url: url_delete_minit_mesyuarat +"/" + delete_id,
						success: function (data) {
							$('#senarai_minit_mesyuarat_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod minit mesyuarat telah dipadam dari pangkalan data", "success");
						},
						error: function (data) {
							console.log('Error:', data);
						}
					});
				} else {
					swal("Tidak", "Proses pemadaman tidak berlaku", "error");
				}
			});
		});

	});

    function kemaskini_minit_mesyuarat_rt(id){
		window.location.href = "{{ route('rt-sm5.penyediaan_minit_mesyuarat_rt','') }}"+"/"+id;
	}
    
</script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop