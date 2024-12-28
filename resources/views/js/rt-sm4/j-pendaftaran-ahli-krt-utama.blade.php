@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    

    $(document).ready( function () {
	

		//my custom script
		var senarai_ahli_krt_config = {
			routes: {
				senarai_senarai_ahli_krt_url: "/rt/sm4/pendaftaran-ahli-krt-utama"
			}
		};

		$('#krt_id').val("{{$user_profile->krt_id}}");
        
    	var senarai_ahli_krt_table = $('#senarai_ahli_krt_table').DataTable( {
    		processing: true,
        	serverSide: true,
            buttons: [
              'copy', 'excel', 'pdf', 'print'
            ],
			ajax: {url: senarai_ahli_krt_config.routes.senarai_senarai_ahli_krt_url},
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
                var info = senarai_ahli_krt_table.page.info();
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
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.penggal_mula+"/"+full.penggal_tamat;
                }
            },{       
                "aTargets": [ 2 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.ajk_nama;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
                    return full.ajk_ic;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "34%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_alamat;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_phone;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.status_description;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.ajk_status_form == '3') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini pendaftaran ahli KRT" onclick="kemaskini_pendaftaran_ajk_krt(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
						button_b = '<button type="button" class="btn btn-icon" title="Buang AJK KRT" id="delete_ajk" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
					    return button_a+button_b;
                    }else if (full.ajk_status_form == '6') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini pendaftaran ahli KRT" onclick="kemaskini_pendaftaran_ajk_krt(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    button_b = '<button type="button" class="btn btn-icon" title="Buang AJK KRT" id="delete_ajk" data-id="'+full.id+'" data-type="confirm"><i class="fa fa-trash-o text-danger"></i></button>';
					    return button_a+button_b;
                    } else {
                        button_b = '';
                        return button_b;
                    }
                }
            }],
            "order": [[ 1, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });
		
		$('#srch_penggal').on("change",function(e) {
			var val=$('#srch_penggal option:selected').text();
			var val4 = val.substring(0, 4);
			senarai_ahli_krt_table.column('1').search(val4).draw();
        });
        
		url_delete_ajk 		= "{{ route('rt-sm4.delete_ajk','') }}";
		
		$('body').on('click', '#delete_ajk', function () {
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
						url: url_delete_ajk +"/" + delete_id,
						success: function (data) {
							$('#senarai_ahli_krt_table').DataTable().ajax.reload();
							swal("Sudah dipadam!", "Rekod ajk telah dipadam dari pangkalan data", "success");
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

	function kemaskini_pendaftaran_ajk_krt(id){
		window.location.href = "{{ route('rt-sm4.borang_pendaftaran_eIDRT','') }}"+"/"+id;
	}

    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop