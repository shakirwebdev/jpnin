@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"> 

    $(document).ready( function () {
        
    	//my custom script
		var laporan_kewangan_rt_config = {
			routes: {
				laporan_kewangan_rt_url: "/rt/sm7/laporan-kewangan-rt"
			}
		};

		/* Maklumat Kewangan Rukun Tetangga */
            $('#lkr_krt_nama').val("{{$krt->krt_nama}}");
            $('#lkr_no_acc').val("{{$krt->bank_no_acc}}");
            $('#lkr_bank_nama').val("{{$krt->bank_nama}}");
            $('#lkr_no_evendor').val("{{$krt->no_evendor}}");
            $('#lkr_daerah').val("{{$krt->daerah}}");
            $('#lkr_negeri').val("{{$krt->state}}");

            var senarai_kewangan_rt_table = $('#senarai_kewangan_rt_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: {url: laporan_kewangan_rt_config.routes.laporan_kewangan_rt_url},
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
                    "width": "16%", 
                    "mRender": function ( value, type, full )  {
                        return full.kewangan_butiran;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "13%", 
                    "mRender": function ( value, type, full )  {
                        return full.tarikh_t_b;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "14%", 
                    "mRender": function ( value, type, full )  {
                        return full.kewangan_cek_baucer;
                    }
                },{          
                    "aTargets": [ 4 ], 
                    "width": "14%", 
                    "mRender": function ( value, type, full )  {
                        return full.kewangan_tarikh_cek;
                    }
                },{          
                    "aTargets": [ 5 ], 
                    "width": "10%", 
                    "mRender": function ( value, type, full )  {
                        return full.terima_tunai;
                    }
                },{          
                    "aTargets": [ 6 ], 
                    "width": "10%", 
                    "mRender": function ( value, type, full )  {
                        return full.terima_bank;
                    }
                },{          
                    "aTargets": [ 7 ], 
                    "width": "10%", 
                    "mRender": function ( value, type, full )  {
                        return full.bayar_tunai;
                    }
                },{          
                    "aTargets": [ 8 ], 
                    "width": "10%", 
                    "mRender": function ( value, type, full )  {
                        return full.bayar_bank;
                    }
                },{          
                    "aTargets": [ 9 ], 
                    "width": "10%", 
                    "mRender": function ( value, type, full )  {
                        return full.kewangan_baki_tunai;
                    }
                },{          
                    "aTargets": [ 10 ], 
                    "width": "10%", 
                    "mRender": function ( value, type, full )  {
                        return full.kewangan_baki_bank;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
	        });
    });

    function print_laporan_kewangan_rt(){
        window.location.href = "{{route('pdf.laporan_kewangan_rt','')}}"+"/"+"{{$krt->id}}";
	}

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop