@include('js.modal.j-modal-add-surat-perancangan-aktiviti-hq')
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">    
    $(document).ready( function () {
        
    	//my custom script
		var senarai_surat_perancangan_aktiviti_config = {
			routes: {
				senarai_surat_perancangan_aktiviti_url: "/rt/sm6/surat-perancangan-aktiviti-hq"
			}
		};

		var perancangan_aktiviti_table = $('#perancangan_aktiviti_table').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_surat_perancangan_aktiviti_config.routes.senarai_surat_perancangan_aktiviti_url},
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
                "width": "19%", 
                "mRender": function ( value, type, full )  {
					return full.surat_tahun;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "21%", 
                "mRender": function ( value, type, full )  {
					return full.surat_tarikh;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.created_at;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "17%", 
                "mRender": function ( value, type, full )  {
					return full.create_by;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    button_a = '<button type="button" class="btn btn-icon" title="Cetak Surat Perancangan Aktiviti KRT Negeri" onclick="cetak_surat(\'' + full.id + '\');"><i class="fa fa-print"></i></button>';
					return button_a;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });
        
    });

    function cetak_surat(id){
       window.location.href = "{{route('pdf.aktiviti_surat_perancangan_aktiviti_hq','')}}"+"/"+id;
    }

    /* Click Button Tambah */

    //my custom script
		var add_surat_perancangan_aktiviti_hq_config = {
			routes: {
				add_surat_perancangan_aktiviti_hq_url: "{{ route('rt-sm6.add_surat_perancangan_aktiviti_hq') }}",
			}
		};

        $(document).on('submit', '#form_maspa', function(event){    
			event.preventDefault();
			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save').prop('disabled', true);
			var data = $("#form_maspa").serialize();
			var action = $('#add_surat_perancangan_aktiviti_hq').val();
			var btn_text;
			if (action == 'add') {
				url = add_surat_perancangan_aktiviti_hq_config.routes.add_surat_perancangan_aktiviti_hq_url;
				type = "POST";
				btn_text = '<i class="fe fe-plus mr-2"></i> Tambah';
			}

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {        
				$('[name=maspa_surat_tahun]').removeClass("is-invalid");
                $('[name=maspa_surat_tarikh]').removeClass("is-invalid");
				
				if(response.errors){
					$.each(response.errors, function(index, error){
						if(index == 'maspa_surat_tahun') {
							$('[name=maspa_surat_tahun]').addClass("is-invalid");
							$('.error_maspa_surat_tahun').html(error);
						}

                        if(index == 'maspa_surat_tarikh') {
							$('[name=maspa_surat_tarikh]').addClass("is-invalid");
							$('.error_maspa_surat_tarikh').html(error);
						}

					});
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);            
				} else {
					$('#modal_add_surat_perancangan_aktiviti_hq').modal('hide');
					$('#perancangan_aktiviti_table').DataTable().ajax.reload();
				}
			});
		});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop