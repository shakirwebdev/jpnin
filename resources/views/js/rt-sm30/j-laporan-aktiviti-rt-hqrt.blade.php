@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script type="text/javascript"> 

	$(document).ready( function () {

		//my custom script
		var laporan_aktiviti_config = {
			routes: {
				laporan_aktiviti_url: "/rt/sm30/laporan-aktiviti-rt-hqrt"
			}
		}; 

		$("#larhq_state_id").on( 'change', function () {
			laporan_aktiviti.column('0:visible').search( $(this).val() ).draw();
			var value = $(this).find('option:selected').val();
			var selectedIndex = $(this).find('option:selected').index();
            $('#larhq_daerah_id').find('option').remove();
            $('#larhq_daerah_id').prop("disabled", false);
            if (selectedIndex !== '0') {
                $.ajax({
                    type: "GET",
                    url: laporan_aktiviti_config.routes.laporan_aktiviti_url,
                    data: {type: 'get_daerah', value: value},
                    success: function (data) {
                        $('#larhq_daerah_id').append($('<option>').text('-- Sila Pilih --').attr('value', ''));
                        $.each(data,function(key, obj) 
                        {
                            $('#larhq_daerah_id')
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

		$("#larhq_daerah_id").on( 'change', function () {
			laporan_aktiviti.column('1:visible').search( $(this).val() ).draw();
		});

		$("#larhq_agenda_id").on( 'change', function () {
			laporan_aktiviti.column('6:visible').search( $(this).val() ).draw();
		});

		$("#larhq_bidang_id").on( 'change', function () {
			laporan_aktiviti.column('7:visible').search( $(this).val() ).draw();
		});

		$("#larhq_k_aktiviti_id").on( 'change', function () {
			laporan_aktiviti.column('8:visible').search( $(this).val() ).draw();
		});

		$("#larhq_j_aktiviti_id").on( 'change', function () {
			laporan_aktiviti.column('9:visible').search( $(this).val() ).draw();
		});

		var laporan_aktiviti = $('#laporan_aktiviti').DataTable( {
    		processing: true,
        	serverSide: true,
            dom: 'rtip',
            ajax: {
					url: laporan_aktiviti_config.routes.laporan_aktiviti_url,
					error:function(x,e) {
						if (x.status==0) {
							alert('You are offline!!\n Please Check Your Network.');
						} else if(x.status==404) {
							alert('Requested URL not found.');
						} else if(x.status==500) {
							alert('Internel Server Error.');
						} else if(e=='parsererror') {
							alert('Error.\nParsing JSON Request failed.');
						} else if(e=='timeout'){
							alert('Request Time out.');
						} else {
							alert('Unknow Error.\n'+x.responseText);
						}
					},
				  },
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
			pageLength: 10,
			"aoColumnDefs":[{          
                "aTargets": [ 0 ], 
                "width": "6px", 
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                    return  meta.row+1;
                }
            },{          
                "aTargets": [ 1 ], 
                "width": "80px", 
                "mRender": function ( value, type, full )  {
                    return full.state;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "80px", 
                "mRender": function ( value, type, full )  {
                    return full.daerah;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "150px", 
                "mRender": function ( value, type, full )  {
                    return full.krt_name;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "60px", 
                "mRender": function ( value, type, full )  {
					return full.penganjur;
                }
			},{          
                "aTargets": [ 5 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.tarikh_aktiviti;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.tajuk_aktiviti;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.perasmi_aktiviti;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.agenda_kerja;
                }
			},{          
                "aTargets": [ 9 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					if(full.program_id == "74" || full.program_id == "85" || full.program_id == "92" ||full.program_id == "106" )
						return "";
					else
						return full.program;
                }
            },{          
                "aTargets": [ 10 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.bidang_kerja;
                }
            },{          
                "aTargets": [ 11 ], 
                "width": "70px", 
                "mRender": function ( value, type, full )  {
					return full.kategori_aktiviti;
                }
            },{          
                "aTargets": [ 12 ], 
                "width": "50px", 
                "mRender": function ( value, type, full )  {
					return full.jenis_aktiviti;
                }
			},{          
                "aTargets": [ 13 ], 
                "width": "50px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.jumlah_lelaki;
                }
			},{          
                "aTargets": [ 14 ], 
                "width": "50px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.jumlah_perempuan;
                }
			},{          
                "aTargets": [ 15 ], 
                "width": "50px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.jumlah_umur1;
                }
			},{          
                "aTargets": [ 16 ], 
                "width": "50px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.jumlah_umur2;
                }
			},{          
                "aTargets": [ 17 ], 
                "width": "50px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.jumlah_umur3;
                }
			},{          
                "aTargets": [ 18 ], 
                "width": "50px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.jumlah_umur4;
                }
			},{          
                "aTargets": [ 19 ], 
                "width": "50px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.jumlah_umur5;
                }
			},{          
                "aTargets": [ 20 ], 
                "width": "50px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.jumlah_umur6;
                }
			},{          
                "aTargets": [ 21 ], 
                "width": "50px", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
					return full.jumlah_umur7;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    }); 
        
		$('#btn_excel').on( 'click', function () {
			//alert($('#larhq_state_id').val() + "-"+ $('#larhq_daerah_id').val() + "-"+ $('#larhq_agenda_id').val() + "-"+ $('#larhq_bidang_id').val() + "-"+ $('#larhq_k_aktiviti_id').val() + "-"+ $('#larhq_j_aktiviti_id').val());
			$var_negeri = $('#larhq_state_id').val();
			$var_daerah = $('#larhq_daerah_id').val();
			if($var_daerah == '')
			{
				$var_daerah=null;
			}
			$var_agenda = $('#larhq_agenda_id').val();
			$var_bidang = $('#larhq_bidang_id').val();
			$var_kategori = $('#larhq_k_aktiviti_id').val();
			$var_jenis = $('#larhq_j_aktiviti_id').val();
			$base_url = window.location.origin;
			$url = $base_url+"/rt/sm30/get_excel_file2/negeri/"+$var_negeri+"/daerah/"+$var_daerah+"/agenda/"+$var_agenda+"/bidang/"+$var_bidang+"/kategori/"+$var_kategori+"/jenis/"+$var_jenis;
			window.location.href = $url;
		});
		
		$('#btn_pdf').on( 'click', function () {
			$var_negeri = $('#larhq_state_id').val();
			$var_daerah = $('#larhq_daerah_id').val();
			$var_agenda = $('#larhq_agenda_id').val();
			$var_bidang = $('#larhq_bidang_id').val();
			$var_kategori = $('#larhq_k_aktiviti_id').val();
			$var_jenis = $('#larhq_j_aktiviti_id').val();
			$base_url = window.location.origin;
			$url = $base_url+"/pdf/laporan_aktiviti_rt_pdf/negeri/"+$var_negeri+"/daerah/"+$var_daerah+"/agenda/"+$var_agenda+"/bidang/"+$var_bidang+"/kategori/"+$var_kategori+"/jenis/"+$var_jenis;
			window.location.href = $url;
		});
		
    });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop