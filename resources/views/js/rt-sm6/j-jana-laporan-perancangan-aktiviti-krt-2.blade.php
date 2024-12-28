@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<style type="text/css">
    .series-frame {
      /*max-width: 600px;*/
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-sizing: border-box;
      border: 2px solid #113f50;
      /*margin: 30px;*/
      padding: 10px;
    }

</style>
<script type="text/javascript">    
    
    $(document).ready( function () {

        /* Maklumat Kawasan Krt */
            $('#ppap2_nama_krt').html("{{$perancangan_aktiviti->nama_krt}}");
            $('#ppap2_alamat_krt').html("{{$perancangan_aktiviti->alamat_krt}}");
            $('#ppap2_negeri_krt').html("{{$perancangan_aktiviti->negeri_krt}}");
            $('#ppap2_parlimen_krt').html("{{$perancangan_aktiviti->parlimen_krt}}");
            $('#ppap2_pbt_krt').html("{{$perancangan_aktiviti->pbt_krt}}");
            $('#ppap2_daerah_krt').html("{{$perancangan_aktiviti->daerah_krt}}");
            $('#ppap2_dun_krt').html("{{$perancangan_aktiviti->dun_krt}}");

        /* Maklumat Tempat Aktiviti Perpaduan */
            $('#ppap2_state_id').val("{{$perancangan_aktiviti->state_id}}");
            $('#ppap2_daerah_id').val("{{$perancangan_aktiviti->daerah_id}}");
            $('#ppap2_aktiviti_tempat').val("{{$perancangan_aktiviti->aktiviti_tempat}}");
            var aktiviti_kawasan_DL = "{{$perancangan_aktiviti->aktiviti_kawasan_DL}}";
		    $("input[name=ppap2_aktiviti_kawasan_DL][value=" + aktiviti_kawasan_DL + "]").prop('checked', true);

        /* Maklumat Penyertaan */
            
            //my custom script
            url_senarai_penyertaan_table      = "{{ route('rt-sm6.get_penyertaan_table','') }}"+"/"+"{{$perancangan_aktiviti->id}}";
            
            var senarai_penyertaan_table      = $('#senarai_penyertaan_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_senarai_penyertaan_table,
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
                    "width": "13%", 
                    "mRender": function ( value, type, full )  {
                        return full.kaum;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "13%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.lelaki;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "29%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.perempuan;
                    }
                },{          
                    "aTargets": [ 4 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_1;
                    }
                },{          
                    "aTargets": [ 5 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_2;
                    }
                },{          
                    "aTargets": [ 6 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_3;
                    }
                },{          
                    "aTargets": [ 7 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_4;
                    }
                },{          
                    "aTargets": [ 8 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_5;
                    }
                },{          
                    "aTargets": [ 9 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_6;
                    }
                },{          
                    "aTargets": [ 10 ], 
                    "width": "6%", 
                    sClass: 'text-center',
                    "mRender": function ( value, type, full )  {
                        return full.umur_7;
                    }
                },{          
                    "aTargets": [ 11 ], 
                    "width": "13%", 
                    "mRender": function ( value, type, full )  {
                        return full.jumlah;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

        /* Maklumat Rakan Perpaduan */
            
            //my custom script
            url_rakan_perpaduan_table         = "{{ route('rt-sm6.get_rakan_perpaduan_table','') }}"+"/"+"{{$perancangan_aktiviti->id}}";
           
            var senarai_rakan_perpaduan_table = $('#senarai_rakan_perpaduan_table').DataTable( {
                processing: true,
                serverSide: true,
                ajax: url_rakan_perpaduan_table,
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
                    "width": "28%", 
                    "mRender": function ( value, type, full )  {
                        return full.rakan_perpaduan;
                    }
                },{          
                    "aTargets": [ 2 ], 
                    "width": "28%", 
                    "mRender": function ( value, type, full )  {
                        return full.bentuk_sumbangan;
                    }
                },{          
                    "aTargets": [ 3 ], 
                    "width": "28%",
                    sClass: 'text-center', 
                    "mRender": function ( value, type, full )  {
                        return full.jumlah;
                    }
                }],
                "order": [[ 0, 'asc' ]],
                initComplete: function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });
        
    	/* Button */
            $('#btn_back').click(function(){
                window.location.href = '{{route('rt-sm6.jana_laporan_perancangan_aktiviti_krt_1','')}}'+'/'+"{{$perancangan_aktiviti->id}}";
            });

            $('#btn_next').click(function(){
                window.location.href = '{{route('rt-sm6.jana_laporan_perancangan_aktiviti_krt_3','')}}'+'/'+"{{$perancangan_aktiviti->id}}";
            });
    });

</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>
@stop