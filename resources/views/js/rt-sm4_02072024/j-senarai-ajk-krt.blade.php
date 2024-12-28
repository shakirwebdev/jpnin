@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    

    $(document).ready( function () {

		//my custom script
		var senarai_ajk_krt_config = {
			routes: {
				senarai_ajk_krt_url: "/rt/sm4/senarai-ajk-krt"
			}
		};

        var senarai_ajk_krt_table = $('#senarai_ajk_krt_table').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_ajk_krt_config.routes.senarai_ajk_krt_url},
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
                    return full.ajk_nama;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
                    return full.ajk_ic;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "34%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_alamat;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_jawatan;
                }
            },{          
                "aTargets": [ 5 ], 
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
                "aTargets": [ 6 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_status;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.ajk_status == 'Aktif') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini AJK KRT" onclick="kemaskini_ajk_krt(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
					    button_b = '<button type="button" class="btn btn-icon" title="Cetak Surat Pelantikan AJK" onclick="print_surat_pelantikan_ajk(\'' + full.id + '\');"><i class="fa fa-print"></i></button>';
                        return button_a + button_b;
                    } else {
                        button_c = '';
                        return button_c;
                    }
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });
        
    });

	function kemaskini_ajk_krt(id){
		window.location.href = "{{ route('rt-sm4.kemaskini_ajk_krt','') }}"+"/"+id;
	}

    function print_surat_pelantikan_ajk(id){
		window.location.href = "{{route('pdf.surat_pelantikan_ajk','')}}"+"/"+id;
	}

    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop