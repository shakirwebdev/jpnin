@section('page-script')
@include('js.modal.j-modal-add-ts-ikes-ppn')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
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
		var tindakan_susulan_ikes_ppn_config = {
			routes: {
				tindakan_susulan_ikes_ppn_url: "/rt/sm21/senarai-ts-ikes-ppn"
			}
		};  

		$("#stipn_daerah_id").on( 'change', function () {
			senarai_permohonan_pelaporan_kes.column('1:visible').search( $(this).val() ).draw();
		});
		
		var senarai_permohonan_pelaporan_kes = $('#senarai_permohonan_pelaporan_kes').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: 'l<"pull-right">Brtip',
            buttons: [
              'copy', 'excel', 'pdf', 'print'
            ],
			ajax: {url: tindakan_susulan_ikes_ppn_config.routes.tindakan_susulan_ikes_ppn_url},
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
                "width": "13%", 
                "mRender": function ( value, type, full )  {
                    return full.state_description;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "13%", 
                "mRender": function ( value, type, full )  {
                    return full.daerah_description;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "13%", 
                "mRender": function ( value, type, full )  {
                    return full.peringkat_description;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "13%", 
                "mRender": function ( value, type, full )  {
                    return full.kategori_description;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					return full.kluster_description;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "18%", 
                "mRender": function ( value, type, full )  {
					return full.long_description;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    button_a = '<button type="button" class="btn btn-icon" title="Paparan Pelaporan i-Kes" onclick="paparan_ikes(\'' + full.spk_kes_id + '\');"><i class="fa fa-search"></i></button>';
                    button_b = '<button type="button" class="btn btn-icon" title="Arahan Tindakan Pelaporan i-Kes" onclick="load_add_ts_ikes_ppn(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					return button_a + '|' + button_b;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });
        
    });

	function paparan_ikes(id){
        window.location.href = "{{ route('rt-sm21.paparan_pelaporan_ikes_ts_ppn','') }}"+"/"+id;
    }

    /* tindakan susulan */
        var add_tindakan_susulan_ppn_config = {
            routes: {
                add_tindakan_susulan_ppn_url: "{{ route('rt-sm21.post_add_ts_ikes_ppn') }}",
            }
        };

        $(document).on('submit', '#form_matipn', function(event){
			var info = $('.error_form_matipn');
			event.preventDefault();

			$('#btn_save').html("<i class=\"fa fa-circle-o-notch fa-spin mr-10\"></i>Sila tunggu..");
			$('#btn_save').prop('disabled', true);

			var data = $("#form_matipn").serialize();
			btn_text = '<i class="fe fe-plus mr-2"></i>Tambah';
			url = "{{ route('rt-sm21.post_add_ts_ikes_ppn') }}";
			type = "POST";

			$.ajax({
				url: url,
				type: type,
				data: data,
			}).done(function(response) {            
				info.hide().find('ul').empty();
				if(response.errors){
					$.each(response.errors, function(index, error){
						info.find('ul').append('<li>'+error+'</li>');
					});
					$('#btn_save').html(btn_text);                
					$('#btn_save').prop('disabled', false);
					info.slideDown();
				} else {
					swal("Tindakan Susulan PPN ditambah!", "Rekod ditambah di dalam pangkalan data", "success");
					$('#form_matipn').trigger("reset");
					$('#btn_save').html(btn_text);
					$('#btn_save').prop('disabled', false);
					$('#senarai_ts_ikes').DataTable().ajax.reload();
				}
			});
		});
    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop