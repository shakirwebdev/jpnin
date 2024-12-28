@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {

		//my custom script
			var senarai_ahli_peronda_config = {
                routes: {
                    senarai_senarai_ahli_peronda_config_url: "/rt/sm13/kad-keahlian-srs"
                }
		    };
			var value = $("#apshq_daerah_id").find('option:selected').val();
			if(typeof(value) === "undefined")
			{
				var value = $("#apshq_state_id").find('option:selected').val();
                var selectedIndex = $("#apshq_state_id").find('option:selected').index();
                $('#apshq_daerah_id').find('option').remove();
                $('#apshq_daerah_id').prop("disabled", false);
				$('#apshq_state_id').prop("disabled", true);
                if (selectedIndex !== '0') {
                    $.ajax({
                        type: "GET",
                        url: senarai_ahli_peronda_config.routes.senarai_senarai_ahli_peronda_config_url,
                        data: {type: 'get_daerah', value: value},
                        success: function (data) {
                            $('#apshq_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                            $.each(data,function(key, obj) 
                            {
                                $('#apshq_daerah_id')
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
				
				$("#apshq_daerah_id").on( 'change', function () {
					var value = $("#apshq_daerah_id").find('option:selected').val();
					var selectedIndex = $("#apshq_daerah_id").find('option:selected').index();
					$('#apshq_krt_id').find('option').remove();
					$('#apshq_krt_id').prop("disabled", false);
					$('#apshq_state_id').prop("disabled", true);
					if (selectedIndex !== '0') {
						$.ajax({
							type: "GET",
							url: senarai_ahli_peronda_config.routes.senarai_senarai_ahli_peronda_config_url,
							data: {type: 'get_krt', value: value},
							success: function (data) {
								$('#apshq_krt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
								$.each(data,function(key, obj) 
								{
									$('#apshq_krt_id')
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
			}else
			{
                var value = $("#apshq_daerah_id").find('option:selected').val();
                var selectedIndex = $("#apshq_daerah_id").find('option:selected').index();
                $('#apshq_krt_id').find('option').remove();
                $('#apshq_krt_id').prop("disabled", false);
				$('#apshq_state_id').prop("disabled", true);
                if (selectedIndex !== '0') {
                    $.ajax({
                        type: "GET",
                        url: senarai_ahli_peronda_config.routes.senarai_senarai_ahli_peronda_config_url,
                        data: {type: 'get_krt', value: value},
                        success: function (data) {
                            $('#apshq_krt_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                            $.each(data,function(key, obj) 
                            {
                                $('#apshq_krt_id')
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
			}
            //});

            $("#apshq_krt_id").on( 'change', function () {
                senarai_ahli_peronda_srs_table.search( $(this).val() ).draw();
            });
        
            var senarai_ahli_peronda_srs_table = $('#senarai_ahli_peronda_srs_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: {url: senarai_ahli_peronda_config.routes.senarai_senarai_ahli_peronda_config_url},
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
                    var info = senarai_ahli_peronda_srs_table.page.info();
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
                    "width": "17%", 
                    "mRender": function ( value, type, full )  {
                        return full.nama_krt;
                    }
                },{          
                    "aTargets": [ 4 ], 
                    "width": "17%", 
                    "mRender": function ( value, type, full )  {
                        return full.nama_srs;
                    }
                },{          
                    "aTargets": [ 5 ], 
                    "width": "17%", 
                    "mRender": function ( value, type, full )  {
                        return full.ahli_peronda_nama;
                    }
                },{          
                    "aTargets": [ 6 ], 
                    "width": "10%", 
                    "mRender": function ( value, type, full )  {
                        return full.ahli_peronda_ic;
                    }
                },{          
                    "aTargets": [ 7 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.ahli_peronda_umur;
                    }
                },{          
                    "aTargets": [ 8 ], 
                    "width": "28%", 
                    "mRender": function ( value, type, full )  {
                        return full.ahli_peronda_alamat;
                    }
                },{          
                    "aTargets": [ 9 ], 
                    "width": "17%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.ahli_peronda_status;
                    }
                },{          
                    "aTargets": [ 10 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        if (full.status == '1') {
                            button_a = '<button type="button" class="btn btn-icon" title="Semak Pendaftaran Ahli Peronda SRS" onclick="print_kad_keahlian_srs(\'' + full.id + '\');"><i class="fa fa-print"></i></button>';
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

    function print_kad_keahlian_srs(id){
		window.location.href = "{{route('pdf.srs_kad_keahlian','')}}"+"/"+id;
	}
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop