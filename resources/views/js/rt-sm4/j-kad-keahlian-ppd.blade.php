@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {
        
    	//my custom script
		var senarai_ajk_krt_ppd_config = {
			routes: {
				senarai_ajk_krt_ppd_url: "/rt/sm4/kad-keahlian-ppd"
			}
		};

        var a = "JLN DATO' DOLLAH"
        

        $("#kkpd_krt_id").on( 'change', function () {
            var format = /[&<>"'!]/;
            var a = (format.test($(this).val()));
           
            if (a == true) {
                senarai_ajk_krt_table.column('1:visible').search(htmlEntities($(this).val()), true, false).draw();
            }else if(a == false){
                senarai_ajk_krt_table.column('1:visible').search($(this).val()).draw();
            }
        });
       

        // $("#kkpd_krt_id").on("keyup", function() {
        //     senarai_ajk_krt_table.column('1:visible').search( $("<div/>").html($(this).val()).text()).draw();
        // });

        // $("#kkpd_krt_id").change( function() { 
        //     $('#senarai_ajk_krt_table').dataTable().fnFilter(
        //         '\\b' +  htmlEntities($("#kkpd_krt_id").val()) + '\\b',
        //         1,
        //         true,
        //         false
        //     );
        // });  

        
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
                "type": "html", 
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                    return  meta.row+1;
                }
            },{          
                "aTargets": [ 1 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.krt_nama; 
                    // var a = full.krt_nama;
                    // return $("<div/>").html(full.krt_nama).text(); 
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
                    return full.ajk_nama;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_ic;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "14%", 
                "mRender": function ( value, type, full )  {
					return full.no_ahli;
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
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.ajk_status == 'Aktif') {
                        button_a = '<button type="button" class="btn btn-icon" title="Cetak Surat Pelantikan AJK" onclick="print_kad_keahlian_ajk(\'' + full.id + '\');"><i class="fa fa-print"></i></button>';
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

	function print_kad_keahlian_ajk(id){
		window.location.href = "{{route('pdf.kad_keahlian','')}}"+"/"+id;
	}

    function htmlEntities(str) {
        return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;')
        .replace(/!/g, '&#33;')
        .replace(/!/g, '&#33;');
    }

    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop