@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var senarai_mkp_dilantik_upmk_config = {
			routes: {
				senarai_mkp_dilantik_upmk_url: "/rt/sm23/senarai-mkp-dilantik-upmk"
			}
		};  

        $("#smdu_state_id").on( 'change', function () {
			senarai_permohonan_mkp.column('1:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#smdu_daerah_id').find('option').remove();
            $('#smdu_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: senarai_mkp_dilantik_upmk_config.routes.senarai_mkp_dilantik_upmk_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#smdu_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#smdu_daerah_id')
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

        $("#smdu_daerah_id").on( 'change', function () {
			senarai_permohonan_mkp.column('2:visible').search( $(this).val() ).draw();
		});   
        
    	var senarai_permohonan_mkp = $('#senarai_permohonan_mkp').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: 'l<"pull-right">Brtip',
            buttons: [
              'copy', 'excel', 'pdf', 'print'
            ],
			ajax: {url: senarai_mkp_dilantik_upmk_config.routes.senarai_mkp_dilantik_upmk_url},
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
                "width": "12%", 
                "mRender": function ( value, type, full )  {
                    return full.state_description;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "12%", 
                "mRender": function ( value, type, full )  {
                    return full.daerah_description;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "13%", 
                "mRender": function ( value, type, full )  {
                    return full.mkp_pemohon_nama;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "13%", 
                "mRender": function ( value, type, full )  {
                    return full.mkp_pemohon_ic;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "13%", 
                "mRender": function ( value, type, full )  {
					return full.mkp_pemohon_no_phone;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "13%", 
                "mRender": function ( value, type, full )  {
					return full.mkp_pemohon_email;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.status_description;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "13%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.status == '1') {
                        button_a = '<button type="button" class="btn btn-icon" title="Paparan Mediator Komuniti" onclick="parparan_mkp_upmk(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
                        button_b = '<button type="button" class="btn btn-icon" title="Cetak Surat Pelantikan Mediator Komuniti" onclick="cetak_pelantikan_mediator(\'' + full.id + '\');"><font color="#113f50"><i class="fa fa-print"></i></font></button>';
                        button_c = '<button type="button" class="btn btn-icon" title="Cetak Kad Mediator Komuniti" onclick="cetak_kad_mediator(\'' + full.id + '\');"><font color="#113f50"><i class="fa fa-print"></i></font></button>';
					    return button_a +'|'+ button_b +'|'+ button_c;
                    } else {
                        button_d = '';
                        return button_d;
                    }
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });
        
    });

	function parparan_mkp_upmk(id){
		window.location.href = "{{ route('rt-sm23.profile_mkp_upmk','') }}"+"/"+id;
	}

    function cetak_pelantikan_mediator(id){
        /* window.location.href = "{{ route('pdf.surat_pelantikan_mediator','') }}"+"/"+id; */
		window.open("{{ route('pdf.surat_pelantikan_mediator','') }}"+"/"+id, "_blank")
    }
    
    function cetak_kad_mediator(id){
        /* window.location.href = "{{ route('pdf.kad_imediator','') }}"+"/"+id; */
		window.open("{{ route('pdf.kad_imediator','') }}"+"/"+id, "_blank")
    }

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop