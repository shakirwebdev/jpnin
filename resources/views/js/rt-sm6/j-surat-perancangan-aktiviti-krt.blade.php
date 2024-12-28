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
            rowCallback: function(nRow, aData, index) {
                var info = perancangan_aktiviti_table.page.info();
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

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop