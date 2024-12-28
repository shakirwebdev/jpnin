@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    

    $(document).ready( function () {
		
        var senarai_ahli_krt_config = {
			routes: {
				senarai_senarai_ahli_krt_url: "/rt/sm4/pengesahan-ahli-krt-utama"
			}
		};

        $("#pakupd_krt_id").on( 'change', function () {
			var penggal = $('#srch_penggal option:selected').val();
			var format = /[&<>"'!]/;
			var a = (format.test($(this).val()));
			if(penggal === "")
			{
				if (a == true) {
					senarai_pengesahan_ahli_krt_table.column('1:visible').search(htmlEntities($(this).val()), true, false).draw();
				}else if(a == false){
					senarai_pengesahan_ahli_krt_table.column('1:visible').search($(this).val()).draw();
				}
			}else
			{
				var val=$('#srch_penggal option:selected').text();
				var val4 = val.substring(0, 4);
				if (a == true) {
					senarai_pengesahan_ahli_krt_table.column('1:visible').search(htmlEntities($(this).val()), true, false).column('2').search(val4).draw();
				}else if(a == false){
					senarai_pengesahan_ahli_krt_table.column('1:visible').search($(this).val()).column('2').search(val4).draw();
				}
			}
        });
		
		$("#srch_penggal").on( 'change', function () {
            var val=$('#srch_penggal option:selected').text();
			var krt = $('#pakupd_krt_id option:selected').val();
			var format = /[&<>"'!]/;
			var a = (format.test(krt));
			var val4 = val.substring(0, 4);
			if(krt === "")
			{
				senarai_pengesahan_ahli_krt_table.column('2').search(val4).draw();
			}else
			{
				if (a == true) {
					senarai_pengesahan_ahli_krt_table.column('1:visible').search(htmlEntities(krt), true, false).column('2').search(val4).draw();
				}else if(a == false){
					senarai_pengesahan_ahli_krt_table.column('1:visible').search(krt).column('2').search(val4).draw();
				}
			}
        });

		var senarai_pengesahan_ahli_krt_table = $('#senarai_pengesahan_ahli_krt_table').DataTable( {
    		processing: true,
        	serverSide: true,
			ajax: {url: senarai_ahli_krt_config.routes.senarai_senarai_ahli_krt_url},
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
                var info = senarai_pengesahan_ahli_krt_table.page.info();
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
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.krt_nama;
                }
			},{          
                "aTargets": [ 2 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
					if(full.penggal_mula == null)
						return 'TIADA';
					else
                    	return full.penggal_mula+"/"+full.penggal_tamat;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "15%", 
                "mRender": function ( value, type, full )  {
                    return full.ajk_nama;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_ic;
                }
            },{          
                "aTargets": [ 5 ], 
                "width": "38%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_alamat;
                }
            },{          
                "aTargets": [ 6 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_jawatan_desc;
                }
            },{          
                "aTargets": [ 7 ], 
                "width": "10%", 
                "mRender": function ( value, type, full )  {
					return full.ajk_status_form_description;
                }
            },{          
                "aTargets": [ 8 ], 
                "width": "6%", 
				sClass: 'text-center',
                "mRender": function ( value, type, full )  {
                    if (full.ajk_status_form == '4') {
                        button_a = '<button type="button" class="btn btn-icon" title="Kemaskini pendaftaran ahli KRT" onclick="pengesahan_pendaftaran_ajk_krt(\'' + full.id + '\');"><i class="fa fa-edit"></i></button>';
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

    function pengesahan_pendaftaran_ajk_krt(id){
		window.location.href = "{{ route('rt-sm4.pengesahan_borang_pendaftaran_eIDRT','') }}"+"/"+id;
	}

    function htmlEntities(str) {
        return String(str).replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;')
        .replace(/!/g, '&#33;');
    }
        
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop