@section('page-script')
@include('js.modal.j-modal-view-binaan-jambatan')
@include('js.modal.j-modal-view-bagunan-tumpang')
@include('js.modal.j-modal-view-kabin-sedia-ada')
@include('js.modal.j-modal-view-cadangan-pembinaan-prt')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {

		//my custom script
		url_get_senarai_binaan 			= "{{ route('rt-sm1.get_senarai_binaan','') }}"+"/"+{{$profile_krt->id}};
		url_get_senarai_bagunan_tumpang	= "{{ route('rt-sm1.get_senarai_bagunan_tumpang','') }}"+"/"+{{$profile_krt->id}};
		url_get_senarai_kabin 			= "{{ route('rt-sm1.get_senarai_kabin','') }}"+"/"+{{$profile_krt->id}};
		url_get_cadangan_pembinaan 		= "{{ route('rt-sm1.get_cadangan_pembinaan','') }}"+"/"+{{$profile_krt->id}};

		/* Maklumat KRT Yang Dimohon */
		$('#kpk_krt_nama').html("{{$profile_krt->krt_nama}}");
		$('#kpk_krt_alamat').html("{{$profile_krt->krt_alamat}}");
		$('#kpk_tarikh_memohon').html("{{$profile_krt->created_at}}");

		/* Maklumat Pemohon */
		$('#kpk_pemohon_name').val("{{$profile_krt->user_fullname}}");
		$('#kpk_pemohon_ic').val("{{$profile_krt->no_ic}}");
		$('#kpk_pemohon_alamat').val("{{$profile_krt->user_address}}");

		/* Maklumat Asas Kawasan*/
		$('#ppkp4_krt_status_bagunan_id').val("{{$profile_krt->krt_status_bagunan_id}}");

		if($('#ppkp4_krt_status_bagunan_id').val() == '1'){
			$(".for_binaan").css("display", "block");
			$(".for_tumpang").css("display", "none");
		} else if ($('#ppkp4_krt_status_bagunan_id').val() == '2') {
			$(".for_binaan").css("display", "none");
			$(".for_tumpang").css("display", "block");
		} else if ($('#ppkp4_krt_status_bagunan_id').val() == '3') {
			$(".for_binaan").css("display", "none");
			$(".for_tumpang").css("display", "none");
		}

		var senarai_binaan_table = $('#senarai_binaan_table').DataTable( {
    		processing: true,
			serverSide: true,
			ajax: url_get_senarai_binaan,
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
                "width": "6%", 
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                    return  meta.row+1;
                }
            },{          
                "aTargets": [ 1 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
					return full.jenis_premis_description;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.binaan_alamat;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.binaan_isu;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "6%", 
                "mRender": function ( value, type, full )  {
                    button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_binaan_jambatan(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
					return button_a;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });

		var senarai_bagunan_tumpang_table = $('#senarai_bagunan_tumpang_table').DataTable( {
    		processing: true,
			serverSide: true,
			ajax: url_get_senarai_bagunan_tumpang,
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
                "width": "6%", 
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                    return  meta.row+1;
                }
            },{          
                "aTargets": [ 1 ], 
                "width": "38%", 
                "mRender": function ( value, type, full )  {
					return full.jenis_premis_description;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "50%", 
                "mRender": function ( value, type, full )  {
                    return full.tumpang_alamat;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "6%", 
                "mRender": function ( value, type, full )  {
                    button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_bagunan_tumpang(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
					return button_a;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });

	    var senarai_kabin_table = $('#senarai_kabin_table').DataTable( {
    		processing: true,
			serverSide: true,
			ajax: url_get_senarai_kabin,
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
                "width": "6%", 
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                    return  meta.row+1;
                }
            },{          
                "aTargets": [ 1 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
					return full.jenis_kabin;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.kabin_alamat;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.kabin_kos;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "6%", 
                "mRender": function ( value, type, full )  {
                    button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_kabin(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
					return button_a;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });

		var cadangan_pembinaan_table = $('#cadangan_pembinaan_table').DataTable( {
    		processing: true,
			serverSide: true,
			ajax: url_get_cadangan_pembinaan,
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
                "width": "6%", 
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                    return  meta.row+1;
                }
            },{          
                "aTargets": [ 1 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
					jenis_premis = '';
					if (full.prt_jenis_premis == '1') {
                        jenis_premis = 'Kompleks Perpaduan';
                    } else if (full.prt_jenis_premis == '2') {
                        jenis_premis = 'Pusat Rukun Tetangga';
                    }
                    return jenis_premis;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.prt_status_tanah_terkini;
                }
            },{          
                "aTargets": [ 3 ], 
                "width": "20%", 
                "mRender": function ( value, type, full )  {
                    return full.prt_cadangan_tahun;
                }
            },{          
                "aTargets": [ 4 ], 
                "width": "6%", 
                "mRender": function ( value, type, full )  {
                    button_a = '<button type="button" class="btn btn-icon" title="Lihat Paparan" onclick="load_view_cadangan_pembinaan_prt(\'' + full.id + '\');"><i class="fa fa-search"></i></button>';
					return button_a;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });

		$('#btn_back').click(function(){
			window.location.href = "{{route('rt-sm1.pengesahan_permohonan_krt_ppn_3','')}}"+"/"+{{$profile_krt->id}};
		});

		$('#btn_next').click(function(){
			window.location.href = "{{route('rt-sm1.pengesahan_permohonan_krt_ppn_5','')}}"+"/"+{{$profile_krt->id}};
		});

	});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop