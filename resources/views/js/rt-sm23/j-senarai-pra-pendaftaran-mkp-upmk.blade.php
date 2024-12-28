@include('js.modal.j-modal-edit-pendaftaran-mkp')
@include('js.modal.j-modal-add-pendaftaran-mkp')
@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var senarai_pra_pendaftaran_mkp_config = {
			routes: {
				senarai_pra_pendaftaran_mkp_url: "/rt/sm23/senarai-pra-pendaftaran-mkp-upmk"
			}
		};  

        $("#sppmu_state_id").on( 'change', function () {
			senarai_pra_pendaftaran_mkp.column('1:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#sppmu_daerah_id').find('option').remove();
            $('#sppmu_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: senarai_pra_pendaftaran_mkp_config.routes.senarai_pra_pendaftaran_mkp_url,
                    data: {type: 'get_daerahs', value: value},
                    success: function (data) {
                        $('#sppmu_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#sppmu_daerah_id')
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

        $("#sppmu_daerah_id").on( 'change', function () {
			senarai_pra_pendaftaran_mkp.column('2:visible').search( $(this).val() ).draw();
		});   
        
    	var senarai_pra_pendaftaran_mkp = $('#senarai_pra_pendaftaran_mkp').DataTable({
            processing: true,
            serverSide: true,
            ajax: {url: senarai_pra_pendaftaran_mkp_config.routes.senarai_pra_pendaftaran_mkp_url},
            "language": {
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Seterusnya",
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
            responsive: true,
            "aoColumnDefs":[{			
                "aTargets": [ 0 ], 
                sClass: 'text-center',
                "width": "6%", 
                "mRender": function (data, type, full, meta)  {
                        return  meta.row+1;
                }
            },{			
                "aTargets": [ 1 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                    return full.state_description
                }
            },{			
                "aTargets": [ 2 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
                    return full.daerah_description
                }
            },{			
                "aTargets": [ 3 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.user_fullname
                }
            },{			
                "aTargets": [ 4 ], 
                "width": "12%", 
                "mRender": function ( value, type, full )  {
                    return full.no_ic
                }
            },{			
                "aTargets": [ 5 ], 
                "width": "12%", 
                "mRender": function ( value, type, full )  {
                    return full.no_phone
                }
            },{			
                "aTargets": [ 6 ], 
                "width": "10%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.created_at;
                }
            },{			
                "aTargets": [ 7 ], 
                "width": "8%", 
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.status == '1') {
                        return 'Dilantik Oleh KP';
                    } else if (full.status == '3') {
                        return 'Dimohon Oleh MKP';
                    } else if (full.status == '4') {
                        return 'Sokongan Oleh PPD';
                    } else if (full.status == '5') {
                        return 'MKP Perlu Kemaskini';
                    } else if (full.status == '6') {
                        return 'Sokongan Oleh PPMK';
                    } else if (full.status == '7') {
                        return 'MKP Perlu Kemaskini';
                    } else if (full.status == '8') {
                        return 'Pengesahan Oleh PPN';
                    } else if (full.status == '9') {
                        return 'MKP Perlu Kemaskini';
                    } else if (full.status == '10') {
                        return 'Disemak Oleh UPMK ';
                    } else if (full.status == '11') {
                        return 'MKP Perlu Kemaskini';
                    } else if (full.status == '12') {
                        return 'Diluluskan Oleh PP';
                    } else if (full.status == '13') {
                        return 'MKP Perlu Kemaskini';
                    } else if (full.status == '14') {
                        return 'MKP Perlu Kemaskini';
                    } else if (full.status == '15') {
                        return 'Dalam Process Pelanjutan';
                    } else {
                        return 'Belum Selesai';
                    }                
                }
            }
        ]
        });
        
    });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
@stop