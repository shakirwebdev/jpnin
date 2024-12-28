@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    

    $(document).ready( function () {

		//my custom script
		var senarai_ajk_krt_ppd_config = {
			routes: {
				senarai_ajk_krt_ppd_url: "/rt/sm4/senarai-ajk-krt-ppd"
			}
		};

        $("#sakp_krt_id").on( 'change', function () {
			var penggal = $('#srch_penggal option:selected').val();
			var format = /[&<>"'!]/;
			var a = (format.test($(this).val()));
			if(penggal === "")
			{
				if (a == true) {
					senarai_ajk_krt_table.column('1:visible').search(htmlEntities($(this).val()), true, false).draw();
				}else if(a == false){
					senarai_ajk_krt_table.column('1:visible').search($(this).val()).draw();
				}
			}else
			{
				var val=$('#srch_penggal option:selected').text();
				var val4 = val.substring(0, 4);
				if (a == true) {
					senarai_ajk_krt_table.column('1:visible').search(htmlEntities($(this).val()), true, false).column('2').search(val4).draw();
				}else if(a == false){
					senarai_ajk_krt_table.column('1:visible').search($(this).val()).column('2').search(val4).draw();
				}
			}
            //senarai_ajk_krt_table.search( $(this).val() ).draw();
        });
		
		$("#srch_penggal").on( 'change', function () {
            var val=$('#srch_penggal option:selected').text();
			var krt = $('#sakp_krt_id option:selected').val();
			var format = /[&<>"'!]/;
			var a = (format.test(krt));
			var val4 = val.substring(0, 4);
			if(krt === "")
			{
				senarai_ajk_krt_table.column('2').search(val4).draw();
			}else
			{
				if (a == true) {
					senarai_ajk_krt_table.column('1:visible').search(htmlEntities(krt), true, false).column('2').search(val4).draw();
				}else if(a == false){
					senarai_ajk_krt_table.column('1:visible').search(krt).column('2').search(val4).draw();
				}
			}
        });

        var senarai_ajk_krt_table = $('#senarai_ajk_krt_table').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_ajk_krt_ppd_config.routes.senarai_ajk_krt_ppd_url},
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
                var info = senarai_ajk_krt_table.page.info();
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
                    return full.krt_nama;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.penggal_mula;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
                    return full.ajk_nama;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_ic;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "30%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_alamat;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_jawatan;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "15%",
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.ajk_tarikh_mula+  '  -  '  +full.ajk_tarikh_akhir;
					// if (full.ajk_status_pelantikan <= '365') {
                    //     status_pelantikan = 'Tempoh Dalam Pelantikan';
                    //     return status_pelantikan;
                    // } else {
                    //     status_pelantikan = 'Tempoh Pelantikan Tamat';
                    //     return status_pelantikan;
                    // }
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "15%",
                sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    return full.ajk_status;
					// if (full.ajk_status_pelantikan <= '365') {
                    //     status_pelantikan = 'Tempoh Dalam Pelantikan';
                    //     return status_pelantikan;
                    // } else {
                    //     status_pelantikan = 'Tempoh Pelantikan Tamat';
                    //     return status_pelantikan;
                    // }
                }
            },{          
                "aTargets": [ 9 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.ajk_status == 'Aktif') {
                        button_a = '<button type="button" class="btn btn-icon" title="Cetak Surat Pelantikan AJK" onclick="print_surat_pelantikan_ajk(\'' + full.id + '\');"><i class="fa fa-print"></i></button>';
                        return button_a;
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
        
    });

	function print_surat_pelantikan_ajk(id){
		window.location.href = "{{route('pdf.surat_pelantikan_ajk','')}}"+"/"+id;
	}

    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop