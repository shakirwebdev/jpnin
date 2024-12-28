@section('page-script')
@include('js.modal.j-modal-view_ts-ikes')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var tindakan_susulan_ikes_p_config = {
			routes: {
				tindakan_susulan_ikes_p_url: "/rt/sm21/senarai-ts-ikes-p"
			}
		};  

        $("#stip_state_id").on( 'change', function () {
			senarai_permohonan_pelaporan_kes.column('1:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#stip_daerah_id').find('option').remove();
            $('#stip_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: tindakan_susulan_ikes_p_config.routes.tindakan_susulan_ikes_p_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#stip_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#stip_daerah_id')
                            .append($('<option>')
                            .text(obj.daerah_description)
                            .attr('value', obj.daerah_description));
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                }); 
            }
        });

        $("#stip_daerah_id").on( 'change', function () {
			senarai_permohonan_pelaporan_kes.column('2:visible').search( $(this).val() ).draw();
		}); 
		
		var senarai_permohonan_pelaporan_kes = $('#senarai_permohonan_pelaporan_kes').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: 'l<"pull-right">Brtip',
            buttons: [
              'copy', 'excel', 'pdf', 'print'
            ],
			ajax: {url: tindakan_susulan_ikes_p_config.routes.tindakan_susulan_ikes_p_url},
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
                    button_a = '<button type="button" class="btn btn-icon" title="Paparan Pelaporan i-Kes" onclick="paparan_ikes(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                    button_b = '<button type="button" class="btn btn-icon" title="Tindakan Susulan Pelaporan i-Kes" onclick="load_view_ts_ikes(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
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
        window.location.href = "{{ route('rt-sm21.paparan_pelaporan_ikes_ts_p','') }}"+"/"+id;
    }

    

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop