@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">    
    
	$(document).ready( function () {

		/* Maklumat KRT Yang Dimohon */
			$('#kpk_krt_nama').html("{{$profile_krt->krt_nama}}");
			$('#kpk_krt_alamat').html("{{$profile_krt->krt_alamat}}");
			$('#kpk_tarikh_memohon').html("{{$profile_krt->created_at}}");

		/* Maklumat Pemohon */
			$('#kpk_pemohon_name').val("{{$profile_krt->user_fullname}}");
			$('#kpk_pemohon_ic').val("{{$profile_krt->no_ic}}");
			$('#kpk_pemohon_alamat').val("{{$profile_krt->user_address}}");

		url_komposisi_penduduk_table 			= "{{ route('rt-sm1.get_komposisi_penduduk_table','') }}"+"/"+{{$profile_krt->id}};
		url_pekerjaan_table 					= "{{ route('rt-sm1.get_pekerjaan_table','') }}"+"/"+{{$profile_krt->id}};
		url_jenis_rumah_table 					= "{{ route('rt-sm1.get_jenis_rumah_table','') }}"+"/"+{{$profile_krt->id}};

		$('#krt_negeri_id').val("{{$profile_krt->state_id}}");
		$('#krt_daerah_id').val("{{$profile_krt->daerah_id}}");
		$('#krt_parlimen_id').val("{{$profile_krt->parlimen_id}}");
		$('#krt_dun_id').val("{{$profile_krt->dun_id}}");
		$('#krt_pbt_id').val("{{$profile_krt->pbt_id}}");
		$('#krt_balai').val("{{$profile_krt->krt_balai}}");
		$('#krt_ipd').val("{{$profile_krt->krt_ipd}}");
		$('#srs_nama').val("{{$profile_krt->srs_nama}}");
		$('#krt_tabika').val("{{$profile_krt->krt_tabika}}");
		$('#krt_taska').val("{{$profile_krt->krt_taska}}");
		$('#krt_kawasan').val("{{$profile_krt->krt_kawasan}}");
		$('#krt_keluasan').val("{{$profile_krt->krt_keluasan}}");
        
    	var komposisi_penduduk_table = $('#komposisi_penduduk_table').DataTable( {
    		processing: true,
			serverSide: true,
			ajax: url_komposisi_penduduk_table,
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
			"aoColumnDefs":[{          
                "aTargets": [ 0 ], 
                "width": "6%", 
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                    return  meta.row+1;
                }
            },{          
                "aTargets": [ 1 ], 
                "width": "60%", 
                "mRender": function ( value, type, full )  {
                    return full.kaum_description;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "28%", 
                "mRender": function ( value, type, full )  {
                    return full.komposisi_jumlah;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });

	    var pekerjaan_table = $('#pekerjaan_table').DataTable( {
    		processing: true,
			serverSide: true,
			ajax: url_pekerjaan_table,
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
			"aoColumnDefs":[{          
                "aTargets": [ 0 ], 
                "width": "6%", 
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                    return  meta.row+1;
                }
            },{          
                "aTargets": [ 1 ], 
                "width": "60%", 
                "mRender": function ( value, type, full )  {
                    return full.profession_description;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "28%", 
                "mRender": function ( value, type, full )  {
                    return full.pekerjaan_peratus;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });

	    var jenis_rumah_table = $('#jenis_rumah_table').DataTable( {
    		processing: true,
			serverSide: true,
			ajax: url_jenis_rumah_table,
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
			"aoColumnDefs":[{          
                "aTargets": [ 0 ], 
                "width": "6%", 
                sClass: 'text-center',
                "mRender": function (data, type, full, meta)  {
                    return  meta.row+1;
                }
            },{          
                "aTargets": [ 1 ], 
                "width": "60%", 
                "mRender": function ( value, type, full )  {
                    return full.jenis_rumah_description;
                }
            },{          
                "aTargets": [ 2 ], 
                "width": "28%", 
                "mRender": function ( value, type, full )  {
                    return full.jumlah_pintu;
                }
            }],
            "order": [[ 0, 'asc' ]],
            initComplete: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
	    });

		$('#btn_back').click(function(){
			window.location.href = "{{route('rt-sm1.pengesahan_permohonan_krt_ppn','')}}"+"/"+{{$profile_krt->id}};
		});

		$('#btn_next').click(function(){
			window.location.href = "{{route('rt-sm1.pengesahan_permohonan_krt_ppn_2','')}}"+"/"+{{$profile_krt->id}};
		});

	});

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop